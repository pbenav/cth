<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventAdjustmentService
{
    /**
     * @param Event $event The main event to adjust
     * @param string $type The adjustment type ('adjust_start', 'adjust_end', 'adjust_schedule')
     * @param int $maxMinutes The maximum allowed minutes
     * @param string $startDate 'Y-m-d'
     * @param string $startTime 'H:i'
     * @param string $endDate 'Y-m-d'
     * @param string $endTime 'H:i'
     * @param string $teamTimezone 
     * @return array Returns updated start/end properties or an error signal
     */
    public function apply(
        Event $event,
        string $type,
        int $maxMinutes,
        string $startDate,
        string $startTime,
        string $endDate,
        string $endTime,
        string $teamTimezone,
        User $user
    ): array {
        $startCarbon = Carbon::parse($startDate . ' ' . $startTime);
        $endCarbon = Carbon::parse($endDate . ' ' . $endTime);

        switch ($type) {
            case 'adjust_start':
                $newStart = $endCarbon->copy()->subMinutes($maxMinutes);
                $this->appendObservation($event, __('Ajuste de hora de inicio para cumplir con el máximo de jornada (:minutes min)', ['minutes' => $maxMinutes]));
                
                return [
                    'success' => true,
                    'start_date' => $newStart->format('Y-m-d'),
                    'start_time' => $newStart->format('H:i'),
                    'start_datetime' => $newStart->format('Y-m-d H:i:s'),
                    'end_date' => $endDate,
                    'end_time' => $endTime,
                    'end_datetime' => $endCarbon->format('Y-m-d H:i:s'),
                ];

            case 'adjust_end':
                $newEnd = $startCarbon->copy()->addMinutes($maxMinutes);
                $this->appendObservation($event, __('Ajuste de hora de salida para cumplir con el máximo de jornada (:minutes min)', ['minutes' => $maxMinutes]));
                
                return [
                    'success' => true,
                    'start_date' => $startDate,
                    'start_time' => $startTime,
                    'start_datetime' => $startCarbon->format('Y-m-d H:i:s'),
                    'end_date' => $newEnd->format('Y-m-d'),
                    'end_time' => $newEnd->format('H:i'),
                    'end_datetime' => $newEnd->format('Y-m-d H:i:s'),
                ];

            case 'adjust_schedule':
                return $this->adjustBySchedule(
                    $event, $maxMinutes, $startDate, $startCarbon, $teamTimezone, $user
                );
        }

        return ['success' => false, 'message' => 'Invalid adjustment type'];
    }

    protected function appendObservation(Event $event, string $observation)
    {
        if (empty($event->observations)) {
            $event->observations = '';
        } else {
            $event->observations .= "\n";
        }
        $event->observations .= $observation;
    }

    protected function adjustBySchedule(
        Event $event,
        int $maxMinutes,
        string $startDate,
        Carbon $startCarbon,
        string $teamTimezone,
        User $user
    ): array {
        $scheduleMeta = $user->meta->where('meta_key', 'work_schedule')->first();
        $schedule = $scheduleMeta ? json_decode($scheduleMeta->meta_value, true) : [];
        
        if (empty($schedule)) {
            // Fallback to adjust end if no schedule
            return $this->apply($event, 'adjust_end', $maxMinutes, $startDate, $startCarbon->format('H:i'), $startDate, $startCarbon->format('H:i'), $teamTimezone, $user);
        }
        
        $team = $user->currentTeam;
        $eventDate = Carbon::parse($startDate)->startOfDay();
        $dayStartUTC = $eventDate->copy()->setTimezone('UTC');
        $dayEndUTC = $eventDate->copy()->endOfDay()->setTimezone('UTC');
        
        // Calculate used time
        $dayEvents = Event::where('user_id', $user->id)
            ->where('team_id', $team->id)
            ->where('id', '!=', $event->id)
            ->whereHas('eventType', function($q) {
                $q->where('is_workday_type', true);
            })
            ->where('is_open', false)
            ->where('start', '>=', $dayStartUTC)
            ->where('start', '<=', $dayEndUTC)
            ->get();
        
        $usedMinutes = 0;
        foreach ($dayEvents as $dayEvent) {
            if ($dayEvent->end) {
                $eStart = Carbon::parse($dayEvent->start, 'UTC');
                $eEnd = Carbon::parse($dayEvent->end, 'UTC');
                $usedMinutes += $eEnd->diffInMinutes($eStart);
            }
        }
        
        $maxDuration = $team->max_workday_duration_minutes ?? 480;
        $availableMinutes = max(0, $maxDuration - $usedMinutes);
        $remainingMinutes = min($maxMinutes, $availableMinutes);
        
        if ($remainingMinutes <= 0) {
            return [
                'success' => false,
                'message' => __('No hay tiempo disponible. Ya se ha alcanzado el máximo de jornada diaria.')
            ];
        }
        
        $slots = collect($schedule)->sortBy('start')->values();
        if ($slots->isEmpty()) {
            return [
                'success' => false,
                'message' => __('No hay tramos horarios definidos.')
            ];
        }
        
        $eventsToCreate = [];
        foreach ($slots as $slot) {
            if ($remainingMinutes <= 0) break;
            
            $slotStart = Carbon::parse($startDate . ' ' . $slot['start']);
            $slotEnd = Carbon::parse($startDate . ' ' . $slot['end']);
            
            if ($slotEnd->lt($slotStart)) {
                $slotEnd->addDay();
            }
            
            $slotDurationMinutes = $slotEnd->diffInMinutes($slotStart);
            $minutesToUse = min($remainingMinutes, $slotDurationMinutes);
            $actualEnd = $slotStart->copy()->addMinutes($minutesToUse);
            
            $eventsToCreate[] = [
                'start' => $slotStart,
                'end' => $actualEnd,
                'minutes' => $minutesToUse
            ];
            
            $remainingMinutes -= $minutesToUse;
        }
        
        if (empty($eventsToCreate)) {
            return $this->apply($event, 'adjust_end', $maxMinutes, $startDate, $startCarbon->format('H:i'), $startDate, $startCarbon->format('H:i'), $teamTimezone, $user);
        }
        
        $firstEvent = $eventsToCreate[0];
        $this->appendObservation($event, __('Ajuste automático al primer tramo horario (:minutes min)', ['minutes' => $firstEvent['minutes']]));
        
        // Create additional events
        for ($i = 1; $i < count($eventsToCreate); $i++) {
            $slotEvent = $eventsToCreate[$i];
            
            $startUTC = Carbon::parse($slotEvent['start'], $teamTimezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
            $endUTC = Carbon::parse($slotEvent['end'], $teamTimezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
            
            Event::withoutEvents(fn () => Event::create([
                'user_id' => $event->user_id,
                'event_type_id' => $event->event_type_id,
                'team_id' => $event->team_id,
                'work_center_id' => $event->work_center_id,
                'start' => $startUTC,
                'end' => $endUTC,
                'description' => $event->description,
                'observations' => __('Ajuste automático al tramo horario :number (:minutes min)', [
                    'number' => $i + 1,
                    'minutes' => $slotEvent['minutes']
                ]),
                'is_open' => true,
                'is_authorized' => false,
                'is_exceptional' => false,
                'is_extra_hours' => false,
                'is_closed_automatically' => false,
                'ip_address' => request()->ip(),
            ]));
        }
        
        return [
            'success' => true,
            'start_date' => $firstEvent['start']->format('Y-m-d'),
            'start_time' => $firstEvent['start']->format('H:i'),
            'start_datetime' => $firstEvent['start']->format('Y-m-d H:i:s'),
            'end_date' => $firstEvent['end']->format('Y-m-d'),
            'end_time' => $firstEvent['end']->format('H:i'),
            'end_datetime' => $firstEvent['end']->format('Y-m-d H:i:s'),
        ];
    }
}
