<?php

namespace App\Actions\Events;

use App\Models\Event;
use App\Models\ExceptionalClockInToken;
use App\Models\Message;
use App\Models\User;
use App\Notifications\EventCreated;
use App\Notifications\NewMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateEventAction
{
    public function execute(
        User $user,
        array $data,
        bool $isWithinEntryWindow
    ): array {
        $team = $user->currentTeam;
        $appTimezone = config('app.timezone');
        $teamTimezone = $team->timezone ?? $appTimezone;

        // Extract required data
        $eventType = $data['selectedEventType'] ?? null;
        $startDate = $data['start_date'];
        $startTime = $data['start_time'];
        $endDate = $data['end_date'] ?? $startDate;
        $endTime = $data['end_time'] ?? null;
        $isWorkdayType = $eventType && $eventType->is_workday_type;
        $origin = $data['origin'] ?? 'events';
        $latitude = $data['latitude'] ?? null;
        $longitude = $data['longitude'] ?? null;

        $eventStartTime = Carbon::parse($startDate . ' ' . $startTime, $teamTimezone);
        $nowInTeamTz = Carbon::now($teamTimezone);

        // 1. Block future events for WORKDAY types
        if ($isWorkdayType && $eventStartTime->isAfter($nowInTeamTz->copy()->addMinutes(5))) {
            return [
                'status' => 'future_error',
                'message' => __('No se pueden registrar fichajes de jornada laboral en fechas futuras.')
            ];
        }

        // 2. Exceptional Clock-In logic (outside schedule)
        $currentTime = Carbon::now($appTimezone);
        $forceDelay = $team->force_clock_in_delay ?? false;

        if ($forceDelay && $isWorkdayType && !$isWithinEntryWindow) {
            $token = Str::random(60);
            ExceptionalClockInToken::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
                'token' => $token,
                'expires_at' => now()->addMinutes($team->clock_in_grace_period_minutes ?? 10),
            ]);

            $adminSender = $team->owner;
            $url = route('exceptional.clock-in.form', ['token' => $token]);
            $messageContent = __('exceptional_clock_in.message_content', [
                'minutes' => $team->clock_in_grace_period_minutes ?? 10,
                'url' => $url
            ]);

            $message = Message::create([
                'sender_id' => $adminSender->id,
                'subject' => __('exceptional_clock_in.message_subject'),
                'body' => $messageContent,
                'is_log' => true,
            ]);

            $message->recipients()->attach($user->id);
            $user->notify(new NewMessage($message));

            return [
                'status' => 'exceptional_token',
                'message' => __('exceptional_clock_in.validation_error'),
                'token' => $token
            ];
        }

        // 3. Prepare event data
        $isExtraHours = !$isWorkdayType;
        $isExceptional = $data['isExceptionalOverride'] ?? false;

        $defaultWorkCenter = $user->meta->where('meta_key', 'default_work_center_id_team_' . $team->id)->first();
        $defaultWorkCenterId = ($defaultWorkCenter && !empty($defaultWorkCenter->meta_value)) ? $defaultWorkCenter->meta_value : null;

        $eventData = [
            'user_id' => $user->id,
            'team_id' => $team->id,
            'work_center_id' => $defaultWorkCenterId,
            'description' => !empty($data['description']) ? $data['description'] : ($eventType ? $eventType->name : __('Workday')),
            'observations' => $data['observations'] ?? '',
            'event_type_id' => $data['event_type_id'],
            'is_open' => true,
            'is_authorized' => false,
            'is_extra_hours' => $isExtraHours,
            'is_exceptional' => $isExceptional,
        ];

        if ($eventType && $eventType->is_all_day) {
            $eventData['start'] = Carbon::createFromFormat('Y-m-d', $startDate, 'UTC')->startOfDay()->toDateTimeString();
            $eventData['end'] = Carbon::createFromFormat('Y-m-d', $endDate, 'UTC')->startOfDay()->toDateTimeString();
        } else {
            $eventData['start'] = Carbon::parse($startDate . ' ' . $startTime, $teamTimezone)->setTimezone('UTC');
            $eventData['end'] = null;
            $eventData['is_open'] = true;
        }

        if (Schema::hasColumn('events', 'is_authorized')) {
            $eventData['is_authorized'] = false;
        }

        if ($user->geolocation_enabled && $latitude !== null && $longitude !== null) {
            $eventData['latitude'] = $latitude;
            $eventData['longitude'] = $longitude;
        }

        // 4. Try creating the event
        try {
            $event = Event::create($eventData);
        } catch (\App\Exceptions\MaxWorkdayDurationExceededException $e) {
            return [
                'status' => 'max_duration',
                'maxMinutes' => $e->maxMinutes,
                'currentMinutes' => $e->currentMinutes
            ];
        }

        // 5. Post-creation logic
        if ($eventType && $eventType->is_all_day) {
            $admins = $team->allUsers()->filter(function ($u) use ($team) {
                return $u->hasTeamRole($team, 'admin');
            });

            if ($admins->isNotEmpty()) {
                Notification::send($admins, new EventCreated($event));
            }
        }

        return [
            'status' => 'success',
            'event' => $event,
            'isExtraHours' => $isExtraHours
        ];
    }
}
