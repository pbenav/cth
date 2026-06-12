<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;
use App\Traits\InsertHistory;
use App\Traits\HasWorkScheduleHint;
use App\Traits\HandlesEventAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * A Livewire component for editing existing events.
 *
 * This component provides a modal form for editing events, including
 * authorization checks and history logging.
 */
class EditEvent extends Component
{
    use InsertHistory, HasWorkScheduleHint, HandlesEventAuthorization;
    use \App\Traits\HandlesTimezoneConversion;

    /**
     * Determines if the event can be modified by the current user.
     *
     * @var bool
     */
    public bool $canBeModified = false;

    /**
     * Determines if the edit event modal is visible.
     *
     * @var bool
     */
    public bool $showModalEditEvent = false;

    /**
     * A hint about the user's work schedule.
     *
     * @var string
     */
    public string $workScheduleHint = '';

    /**
     * Holds the collection of event types.
     *
     * @var \Illuminate\Support\Collection
     */
    public $eventTypes;

    /**
     * @var Event $event Holds the event being edited.
     * @var Event $original_event Holds the original state of the event for logging.
     */
    public Event $event, $original_event;

    /**
     * The start and end date/time of the event.
     *
     * @var string
     */
    public $start_date, $end_date, $start_time, $end_time, $start_datetime, $end_datetime;

    /**
     * Holds the user associated with the event.
     *
     * @var User
     */
    public $user;
    
    /**
     * The origin of the edit request (e.g., 'events', 'calendar').
     *
     * @var string
     */
    public string $origin = 'events';

    /**
     * The event listeners for the component.
     *
     * @var array
     */
    protected $listeners = ['edit'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        if (isset($this->event->eventType) && $this->event->eventType->is_all_day) {
            return [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'event.observations' => 'nullable|string|max:255',
            ];
        }

        return [
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'event.observations' => 'nullable|string|max:255',
        ];
    }

    /**
     * Initialize the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->event = new Event();
        $this->user = User::find(Auth::user()->id);
        $this->eventTypes = collect();
        
        // Initialize all date/time fields
        $this->start_date = '';
        $this->end_date = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->start_datetime = '';
        $this->end_datetime = '';
    }

    /**
     * Show the edit event modal.
     *
     * @param \App\Models\Event $ev
     * @return void
     */
    public function edit($eventId, string $origin = 'events'): void
    {
        \Log::info('EditEvent::edit RECEIVED', ['eventId' => $eventId, 'origin' => $origin]);
        $this->origin = $origin;
        $ev = Event::find($eventId);
        if (!$ev) return;
        $this->event = $ev->load('workCenter');
        $this->original_event = clone $ev;
        $this->user = User::find($ev->user_id);

        // Obtener zona horaria del equipo del evento
        // Esto permite que la aplicación funcione correctamente en múltiples localizaciones
        $teamTimezone = $this->getEventTimezone($ev);

        // Populate the properties for the form
        // IMPORTANTE: Siempre convertir de UTC a zona horaria local ANTES de formatear o calcular
        if ($ev->eventType && $ev->eventType->is_all_day) {
            // Para eventos de día completo: convertir UTC a zona horaria del equipo
            $startCarbon = $this->utcToTeamTimezone($ev->start, $teamTimezone);
            $this->start_date = $startCarbon->format('Y-m-d');
            
            if ($ev->end) {
                // Parse the end date (which is stored at 23:59:59 of the event day)
                $endCarbon = $this->utcToTeamTimezone($ev->end, $teamTimezone);
                $this->end_date = $endCarbon->format('Y-m-d');
            } else {
                $this->end_date = $startCarbon->format('Y-m-d');
            }
            // Don't set times for all-day events
            $this->start_time = '';
            $this->end_time = '';
            $this->start_datetime = '';
            $this->end_datetime = '';
        } else {
            // Para eventos con hora: convertir UTC a zona horaria del equipo
            $startCarbon = $this->utcToTeamTimezone($ev->start, $teamTimezone);
            
            $this->start_datetime = $startCarbon->toDateTimeLocalString();
            $this->start_date = $startCarbon->format('Y-m-d');
            $this->start_time = $startCarbon->format('H:i');

            if ($ev->end) {
                $endCarbon = $this->utcToTeamTimezone($ev->end, $teamTimezone);
                
                $this->end_datetime = $endCarbon->toDateTimeLocalString();
                $this->end_date = $endCarbon->format('Y-m-d');
                $this->end_time = $endCarbon->format('H:i');
            } else {
                $nowCarbon = \Carbon\Carbon::now($teamTimezone);
                $this->end_datetime = $nowCarbon->toDateTimeLocalString();
                $this->end_date = $nowCarbon->format('Y-m-d');
                $this->end_time = $nowCarbon->format('H:i');
            }
        }

        // Force refresh the component to ensure values are updated
        $this->dispatch('refresh-edit-modal');

        if ($this->event->is_exceptional) {
            $workScheduleMeta = $this->user->meta()->where('meta_key', 'work_schedule')->first();
            $schedule = $workScheduleMeta ? json_decode($workScheduleMeta->meta_value, true) : [];

            $eventStartTime = Carbon::parse($this->start_datetime);
            $dayOfWeek = $eventStartTime->format('N');
            $dayMap = [1 => 'L', 2 => 'M', 3 => 'X', 4 => 'J', 5 => 'V', 6 => 'S', 7 => 'D'];
            $dayAbbr = $dayMap[$dayOfWeek] ?? null;

            $todaysSlots = collect($schedule)->filter(function ($slot) use ($dayAbbr) {
                return in_array($dayAbbr, $slot['days']);
            });

            if ($todaysSlots->isNotEmpty()) {
                $closestSlot = null;
                $smallestDiff = null;

                foreach ($todaysSlots as $slot) {
                    $slotStart = Carbon::parse($eventStartTime->format('Y-m-d') . ' ' . $slot['start']);
                    $diff = abs($eventStartTime->timestamp - $slotStart->timestamp);

                    if (is_null($smallestDiff) || $diff < $smallestDiff) {
                        $smallestDiff = $diff;
                        $closestSlot = $slot;
                    }
                }

                if ($closestSlot) {
                    $this->start_datetime = Carbon::parse($eventStartTime->format('Y-m-d') . ' ' . $closestSlot['start'])->toDateTimeLocalString();
                    $this->end_datetime = Carbon::parse($eventStartTime->format('Y-m-d') . ' ' . $closestSlot['end'])->toDateTimeLocalString();
                }
            }
        }

        $this->setWorkScheduleHint();

        $this->canBeModified = $this->canModifyEvent($this->event);
        \Log::info('EditEvent::edit - canBeModified check', ['canBeModified' => $this->canBeModified, 'eventId' => $this->event->id, 'is_open' => $this->event->is_open]);

        if ($this->canBeModified) {
            $this->showModalEditEvent = true;
            \Log::info('EditEvent::edit - Modal should open now', ['showModalEditEvent' => $this->showModalEditEvent]);
            // Force Browser to open modal
            $this->dispatch('open-edit-modal');
        } else {
            \Log::info('EditEvent::edit - Cannot modify event, emitting alertFail');
            $this->dispatch('alertFail', __("Event is confirmed."));
            $this->reset(["showModalEditEvent"]);
        }

        $this->dispatch('render')->to('get-time-registers');
    }

    /**
     * Update the event.
     *
     * @return void
     */
    /**
     * @var bool Show adjustment modal
     */
    public $showAdjustmentModal = false;
    public $maxMinutes = 0;
    public $currentMinutes = 0;

    /**
     * @var bool Flag to skip duration validation when called from applyAdjustment.
     */
    protected bool $isApplyingAdjustment = false;

    /**
     * Update the event.
     *
     * @return void
     */
    public function update(): void
    {
        if (!$this->canModifyEvent($this->event)) {
            $this->dispatch('alertFail', __("You are not authorized to perform this action."));
            $this->reset(["showModalEditEvent"]);
            return;
        }

        $this->validate();

        // If it's an exceptional event and has observations, prepend "Exceptional event:"
        if ($this->event->is_exceptional && !empty($this->event->observations)) {
            // Only add the prefix if it doesn't already have it
            $exceptionalPrefix = __('exceptional_event.prefix');
            if (!str_starts_with($this->event->observations, $exceptionalPrefix)) {
                $this->event->observations = $exceptionalPrefix . ' ' . $this->event->observations;
            }
        }

        if ($this->event->eventType && $this->event->eventType->is_all_day) {
            // For all-day events, store pure dates in UTC without timezone conversion
            $this->event->start = Carbon::createFromFormat('Y-m-d', $this->start_date, 'UTC')->startOfDay()->toDateTimeString();
            $this->event->end = Carbon::createFromFormat('Y-m-d', $this->end_date, 'UTC')->startOfDay()->toDateTimeString();
        } else {
            // Combine separate date and time fields
            $startDateTime = $this->start_date . ' ' . $this->start_time;
            $endDateTime = $this->end_date . ' ' . $this->end_time;
            
            // Use team timezone (same as used when populating the edit form)
            $teamTimezone = $this->getEventTimezone($this->event);
            
            $this->event->start = Carbon::parse($startDateTime, $teamTimezone)
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
            $this->event->end = Carbon::parse($endDateTime, $teamTimezone)
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
        }

        // If description is empty, use event type name
        if (empty($this->event->description) && $this->event->eventType) {
            $this->event->description = $this->event->eventType->name;
        }

        // Update is_extra_hours based on new logic: only main workday events are NOT overtime
        if ($this->event->eventType) {
            $this->event->is_extra_hours = !$this->event->eventType->is_workday_type;
        }

        // Skip duration validation if we are in the process of applying an adjustment.
        // The adjustment itself has already determined the correct time limits.
        if (!$this->isApplyingAdjustment) {
            // REDUNDANT VALIDATION: Explicitly check max duration before saving
            // This acts as a fallback in case EventObserver is bypassed or fails
            if ($this->event->end && $this->event->eventType && $this->event->eventType->is_workday_type) {
                $service = app(\App\Services\SmartClockInService::class);
                
                // Ensure we use the correct user (from event or auth)
                $targetUser = $this->event->user ?? User::find($this->event->user_id);
                
                if ($targetUser) {
                    $validation = $service->validateMaxDuration($targetUser, $this->event, $this->event->end);
                    
                    if (!$validation['success'] && isset($validation['status_code']) && $validation['status_code'] === \App\Services\SmartClockInService::STATUS_MAX_DURATION_EXCEEDED) {
                        \Log::info('EditEvent: Manual validation caught duration exceeded', $validation);
                        $this->showAdjustmentModal = true;
                        $this->maxMinutes = $validation['max_minutes'];
                        $this->currentMinutes = $validation['current_minutes'];
                        return;
                    }
                }
            }
        }

        try {
            if ($this->isApplyingAdjustment) {
                // Save without firing the observer to avoid double-validation loop
                Event::withoutEvents(fn () => $this->event->save());
            } else {
                $this->event->save();
            }
        } catch (\App\Exceptions\MaxWorkdayDurationExceededException $e) {
            $this->showAdjustmentModal = true;
            $this->maxMinutes = $e->maxMinutes;
            $this->currentMinutes = $e->currentMinutes;
            // Don't close the modal, let user choose adjustment
            return;
        }

        if (auth()->user()->isTeamAdmin()) {
            // Audita todas las modificaciones realizadas por un administrador
            $this->insertHistory('events', $this->original_event, $this->event, false);
            unset($this->original_event);
        }

        $this->reset(["showModalEditEvent", "showAdjustmentModal"]);
        $this->dispatch('alert', __('Event updated!'));
        $this->dispatch('render')->to('get-time-registers');
        $this->dispatch('refreshCalendar');
    }

    public function applyAdjustment($type, \App\Services\EventAdjustmentService $adjustmentService)
    {
        $result = $adjustmentService->apply(
            $this->event,
            $type,
            $this->maxMinutes,
            $this->start_date,
            $this->start_time,
            $this->end_date,
            $this->end_time,
            $this->getEventTimezone($this->event),
            $this->user
        );

        if (!$result['success']) {
            $this->dispatch('alertFail', $result['message']);
            return;
        }

        $this->start_date = $result['start_date'];
        $this->start_time = $result['start_time'];
        $this->start_datetime = $result['start_datetime'];
        $this->end_date = $result['end_date'];
        $this->end_time = $result['end_time'];
        $this->end_datetime = $result['end_datetime'];

        // Hide modal and save with the adjustment flag set to skip re-validation
        $this->showAdjustmentModal = false;
        $this->isApplyingAdjustment = true;
        $this->update();
        $this->isApplyingAdjustment = false;
    }


    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.events.edit-event');
    }

    /**
     * Validate a single property.
     *
     * @param string $propertyName
     * @return void
     */
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Delete an event.
     *
     * @param int $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $eventId)
    {
        // Use the component's origin property
        $origin = $this->origin;
        $event = Event::find($eventId);
        if ($event) {
            // Auditar la eliminación (guardar que fue eliminado para que quede rastro)
            if (auth()->check() && auth()->user()->isTeamAdmin()) {
                $deletedState = clone $event;
                $deletedState->observations = '[EVENTO ELIMINADO] ' . ($deletedState->observations ?? '');
                $this->insertHistory('events', $event, $deletedState, false, true);
            }

            $event->delete();
            Log::info("Evento eliminado: ID {$eventId}"); // Registro de depuración
        } else {
            Log::warning("Intento de eliminar un evento inexistente: ID {$eventId}");
        }

        session()->flash('alert', __('Event has been removed!'));
        
        if ($origin === 'events') {
            return redirect()->route('events');
        }

        $this->dispatch('$refresh')->to('get-time-registers'); // Forzar refresco del listado de eventos
        Log::info('Señal dispatch(\'$refresh\')->to(\'get-time-registers\') enviada.');

        // Refresh the entire calendar component to keep Livewire in sync
        $this->dispatch('refreshCalendar');

        $this->showModalEditEvent = false;
        Log::info("Modal de edición cerrado.");
    }

    /**
     * Close the modal and emit an event to maintain the current view.
     *
     * @return void
     */
    public function closeModal(): void
    {
        $this->showModalEditEvent = false;

        // Emit an event to notify the parent component
        $this->dispatch('modalClosed');
    }
}
