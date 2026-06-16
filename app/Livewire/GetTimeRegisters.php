<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Notifications\EventAuthorized;
use App\Notifications\EventDeAuthorized;
use App\Traits\InsertHistory;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;
use Laravel\Jetstream\HasTeams;
use Illuminate\Support\Facades\Auth;

/**
 * A Livewire component for displaying and managing time registers.
 *
 * This component provides a paginated and filterable table of events, with
 * functionality for searching, sorting, and performing actions on events.
 */
class GetTimeRegisters extends Component
{
    use WithPagination;
    use HasTeams;
    use InsertHistory;

    public bool $showFiltersModal = false;
    public ?string $search = '';
    public Event $filter;
    public ?string $sort = 'start';
    public ?string $direction = 'desc';
    public ?string $qtytoshow = '10';
    public bool $readyonload = false;
    public $user;
    public $team;
    public array $teamUsers;
    public $teamUserList;
    public $eventTypes;
    public bool $isTeamAdmin = false;
    public bool $isInspector = false;
    public bool $confirmed = false;
    public bool $filtered = false;
    public bool $showOnlyMine = false;

    
    // Propiedades individuales para el filtro (para queryString)
    public ?string $filterStart = '';
    public ?string $filterEnd = '';
    public ?int $filterUserId = null;
    public ?int $filterEventTypeId = null;

    protected $listeners = [
        'render',
        'confirm',
        'delete',
        'eventAuthorizationChanged' => '$refresh',
        '$refresh' => 'refreshComponent'
    ];
    /**
     * Forzar refresco y reinicio de paginación tras eliminación
     */
    public function refreshComponent(): void
    {
        $this->readyonload = true; // Ensure events can be loaded
        $this->resetPage();
        // No need to call getEvents() - render() will do it
    }

    public ?int $targetEventId = null;

    protected $queryString = [
        'sort' => ['except' => 'start'],
        'direction' => ['except' => 'desc'],
        'qtytoshow' => ['except' => '10'],
        'search' => ['except' => ''],
        'confirmed' => ['except' => false],
        'filtered' => ['except' => false],
        'showOnlyMine' => [],
        'filterStart' => ['except' => '', 'as' => 'start'],
        'filterEnd' => ['except' => '', 'as' => 'end'],
        'filterUserId' => ['except' => null, 'as' => 'user'],
        'filterEventTypeId' => ['except' => null, 'as' => 'type'],
        'targetEventId' => ['except' => null, 'as' => 'event_id']
    ];

    protected $rules = [
        'filter.start' => 'required|date',
        'filter.end' => 'required|date|after:filter.start',
        'filter.user_id' => 'nullable|integer',
        'filter.is_open' => 'boolean',
        'filter.event_type_id' => 'nullable|integer',
        'filterStart' => 'required|date',
        'filterEnd' => 'required|date|after:filterStart',
        'filterUserId' => 'nullable|integer',
        'filterEventTypeId' => 'nullable|integer',
    ];

    /**
     * Initialize the component and set default values.
     */
    public function mount()
    {
        // Inicializar propiedades del filtro si no vienen de URL
        
        // Crear objeto filter sincronizado con las propiedades individuales
        $this->filter = new Event([
            "start" => $this->filterStart,
            "end" => $this->filterEnd,
            "user_id" => $this->filterUserId,
            "is_open" => false,
            "event_type_id" => $this->filterEventTypeId,
        ]);
        
        $this->user = Auth::user();
        $this->team = $this->user ? $this->user->currentTeam : null;
        $this->teamUserList = $this->team ? $this->team->allUsers()->sortBy(function ($user) {
            return strtolower($user->full_name_with_dni);
        })->values() : collect();
        $this->eventTypes = $this->team ? $this->team->eventTypes : collect();
        $this->isTeamAdmin = $this->user->isTeamAdmin() || $this->user->is_admin;
        $this->isInspector = $this->user->isInspector();
        
        // Establecer valores por defecto solo si no vienen de la URL
        if (!request()->has('confirmed')) {
            $this->confirmed = false;
        }
        if (!request()->has('filtered')) {
            $this->filtered = false;
        }
        if (!request()->has('showOnlyMine')) {
            // Para administradores, inicializar con showOnlyMine = true por defecto
            $this->showOnlyMine = $this->isTeamAdmin;
        }
        
        if ($this->team && ($this->isTeamAdmin || $this->isInspector)) {
            $this->teamUsers = $this->team->allUsers()->pluck('id')->toArray();
        } else {
            $this->teamUsers = [$this->user->id];
        }

        // Limit maximum events to show per page to 100
        if ($this->qtytoshow > 100) {
            $this->qtytoshow = '100';
        }

        // Open edit modal if event_id is present in URL
        if ($this->targetEventId) {
            $targetEvent = Event::find($this->targetEventId);
            if ($targetEvent && $targetEvent->user_id !== $this->user->id) {
                // Automáticamente desactivamos 'showOnlyMine' para que el evento sea visible
                $this->showOnlyMine = false;
            }
        }
    }

    /**
     * Toggle the sorting direction for the specified column.
     *
     * @param string $sort The column to sort by.
     * @return void
     */
    public function order(string $sort): void
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            } else {
                $this->direction = 'asc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        };
    }

    /**
     * Toggle the filter to show only the current user's events.
     *
     * @return void
     */
    public function filterOnlyMine(): void
    {
        $this->showOnlyMine = !$this->showOnlyMine;
    }
    /**
     * Emit the event to edit an existing event.
     *
     * @param int $eventId The event ID to edit.
     * @return void
     */
    public function edit($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with(['eventType', 'team'])->find($eventId);
        if (!$ev) {
            return;
        }
        $this->dispatch('edit', eventId: $ev->id)->to('edit-event');
    }

    /**
     * Show event details modal (Deep Link or View).
     *
     * @param int $eventId The event ID to show.
     * @return void
     */
    public function showEvent($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with(['user', 'eventType', 'workCenter', 'team'])->find($eventId);
        if (!$ev) return;
        
        $this->dispatch('showEventDetails', data: $ev->id);
    }


    /**
     * Confirm an event based on user role and event status.
     *
     * @param \App\Models\Event $ev The event to confirm.
     * @return void
     */
    public function confirm($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with(['user', 'team'])->find($eventId);
        if (!$ev || !$ev->hasCompleteDates()) {
            $this->dispatch('incompleteEventConfirmation');
            return;
        }

        // Validate max workday duration before closing
        if ($ev->is_open) {
            $validation = app(\App\Services\SmartClockInService::class)->validateMaxDuration($ev->user, $ev, $ev->end);
            if (!$validation['success']) {
                $this->dispatch('alertFail', $validation['message'] . ' ' . __('Use the smart clock button to finalise with adjustments.'));
                return;
            }
        }

        if ($this->isTeamAdmin) {
            $wasOpen = $ev->is_open;
            if ($ev->toggleConfirm()) {
                if ($wasOpen) {
                    $this->dispatch('alert', __('event_confirmation.confirmed'));
                } else {
                    $this->dispatch('alert', __('event_confirmation.unconfirmed'));
                }
            } else {
                $this->dispatch('incompleteEventConfirmation');
            }
        } else if ($ev->is_open) {
            if ($ev->confirm()) {
                $this->dispatch('alert', __('event_confirmation.confirmed'));
            } else {
                $this->dispatch('incompleteEventConfirmation');
            }
        }
    }

    /**
     * Emit the confirmation alert for an event.
     *
     * @param \App\Models\Event $ev The event to confirm.
     * @return void
     */
    public function alertConfirm($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with('team')->find($eventId);
        if (!$ev) return;
        if (!$ev->is_open && !$this->isTeamAdmin) {
            $this->dispatch('alertFail', __("This event is already closed and cannot be modified."));
            return;
        }
        if (!$ev->hasCompleteDates()) {
            $this->dispatch('incompleteEventConfirmation');
            return;
        }
        $this->dispatch('confirmConfirmation', eventId: $ev->id);
    }

    /**
     * Emit the deletion alert for an event.
     *
     * @param \App\Models\Event $ev The event to delete.
     * @return void
     */
    public function alertDelete($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with('team')->find($eventId);
        if (!$ev) return;
        if (!$ev->is_open && !$this->isTeamAdmin) {
            $this->dispatch('alertFail', __("This event is already closed and cannot be modified."));
            return;
        }
        $this->dispatch('deleteConfirmation', eventId: $ev->id);
    }

    /**
     * Delete an event if authorized and refresh the component.
     *
     * @param int $eventId The ID of the event to delete.
     * @return void
     */
    public function delete($eventId): void
    {
        if (is_array($eventId)) { $eventId = $eventId['eventId'] ?? $eventId[0] ?? $eventId; }
        $ev = Event::with('team')->find($eventId);
        if (!$ev) return;
        if ($this->isTeamAdmin || $ev->is_open) {
            $ev->delete();
            $this->dispatch('alert', __('Event has been removed!'));
            $this->refreshComponent(); // Ensure the component refreshes after deletion
        }
    }

    /**
     * Close the filters modal without resetting values.
     * This allows the user to reopen the modal with the same filters.
     *
     * @return void
     */
    public function closeFiltersModal(): void
    {
        $this->showFiltersModal = false;
    }

    /**
     * Deactivate filters and reset all filter values to defaults.
     * This is called when the user explicitly wants to remove the filters.
     *
     * @return void
     */
    public function unsetFilter(): void
    {
        $this->showFiltersModal = false;
        $this->filtered = false;
        $this->confirmed = false;
        $this->resetFilters();
    }

    /**
     * Reset all filters to default values
     */
    protected function resetFilters(): void
    {
        $this->search = '';
        $this->filterStart = '';
        $this->filterEnd = '';
        $this->filterUserId = null;
        $this->filterEventTypeId = null;
        
        // Sincronizar con el objeto filter
        $this->filter->start = '';
        $this->filter->end = '';
        $this->filter->user_id = null;
        $this->filter->event_type_id = null;
    }

    /**
     * Open the filters modal.
     * If filters are already set, keep them. Otherwise, set default dates.
     *
     * @return void
     */
    public function openFiltersModal(): void
    {
        // Solo establecer fechas por defecto si están vacías
        if (empty($this->filterStart)) $this->filterStart = date('Y-m-01');
        if (empty($this->filterEnd)) $this->filterEnd = date('Y-m-t');
        
        // Sincronizar con el objeto filter
        $this->filter->start = $this->filterStart;
        $this->filter->end = $this->filterEnd;
        $this->filter->user_id = $this->filterUserId;
        $this->filter->event_type_id = $this->filterEventTypeId;

        $this->showFiltersModal = true;
    }
    
    /**
     * Apply the filters and close the modal.
     *
     * @return void
     */
    public function applyFiltersFromModal(): void
    {
        // Sincronizar propiedades individuales con el objeto filter
        $this->filterStart = $this->filter->start ?? '';
        $this->filterEnd = $this->filter->end ?? '';
        $this->filterUserId = $this->filter->user_id;
        $this->filterEventTypeId = $this->filter->event_type_id;
        
        $this->filtered = true;
        $this->confirmed = false;
        $this->showFiltersModal = false;
    }

    /**
     * Sincronizar propiedades individuales con el objeto filter
     */
    public function syncFilterProperties(): void
    {
        $this->filterStart = $this->filter->start ?? date('Y-m-01');
        $this->filterEnd = $this->filter->end ?? date('Y-m-t');
        $this->filterUserId = $this->filter->user_id;
        $this->filterEventTypeId = $this->filter->event_type_id;
    }

    /**
     * Retrieve and filter events based on the current settings.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    /**
     * Retrieve and filter events based on the current settings.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEvents()
    {
        if (!$this->readyonload) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->qtytoshow);
        }

        $query = Event::query()->with(['user', 'eventType', 'team']);
        $this->applyFilters($query);

        // Sorting
        if ($this->sort === 'name') {
            $query->join('users', 'events.user_id', '=', 'users.id')
                ->select('events.*')
                ->orderBy('users.family_name1', $this->direction)
                ->orderBy('users.name', $this->direction);
        } else {
            // Default sort or specific column sort
            $query->orderBy('events.' . $this->sort, $this->direction);
        }
        
        // Secondary sort to ensure deterministic order
        if ($this->sort !== 'start') {
            $query->orderBy('events.start', 'desc');
        }

        return $query->paginate($this->qtytoshow);
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Recargar equipo actual del usuario por si cambió con el selector
        $this->user = Auth::user();
        $currentTeam = $this->user ? $this->user->currentTeam : null;

        // Ensure currentTeam is not null before proceeding
        if ($currentTeam && (!$this->team || $this->team->id !== $currentTeam->id)) {
            $this->team = $currentTeam;
            $this->teamUserList = $this->team ? $this->team->allUsers()->sortBy(function ($user) {
                return strtolower($user->full_name);
            })->values() : collect();
            $this->eventTypes = $this->team ? $this->team->eventTypes : collect();
            $this->isTeamAdmin = $this->user ? ($this->user->isTeamAdmin() || $this->user->is_admin) : false;
            $this->isInspector = $this->user ? $this->user->isInspector() : false;

            if ($this->team && ($this->isTeamAdmin || $this->isInspector)) {
                $this->teamUsers = $this->team->allUsers()->pluck('id')->toArray();
            } else {
                $this->teamUsers = $this->user ? [$this->user->id] : [];
            }
        }
        
        
        // Si el equipo cambió, actualizar todo el contexto
        if (!$this->team || ($currentTeam && $this->team->id !== $currentTeam->id) || (!$currentTeam && $this->team)) {
            $this->team = $currentTeam;
            $this->teamUserList = $this->team ? $this->team->allUsers()->sortBy(function ($user) {
                return strtolower($user->full_name_with_dni);
            })->values() : collect();
            $this->eventTypes = $this->team ? $this->team->eventTypes : collect();
            $this->isTeamAdmin = $this->user ? ($this->user->isTeamAdmin() || $this->user->is_admin) : false;
            $this->isInspector = $this->user ? $this->user->isInspector() : false;
            
            if ($this->team && ($this->isTeamAdmin || $this->isInspector)) {
                $this->teamUsers = $this->team->allUsers()->pluck('id')->toArray();
            } else {
                $this->teamUsers = $this->user ? [$this->user->id] : [];
            }
        }
        
        
        
        $events = $this->getEvents();
        
        // Calculate summary statistics
        // Note: calculateSummary uses applyFilters internally
        $summary = $this->calculateSummary();
        
        return view('livewire.events.get-time-registers')
            ->with('events', $events)
            ->with('isTeamAdmin', $this->isTeamAdmin)
            ->with('isInspector', $this->isInspector)
            ->with('summary', $summary);
    }

    /**
     * Calculate summary statistics for the filtered events
     *
     * @return array
     */
    private function calculateSummary(): array
    {
        if (!$this->readyonload) {
            return ['workedSeconds' => 0, 'pauseSeconds' => 0, 'netSeconds' => 0];
        }

        $query = Event::query()
            ->leftJoin('event_types', 'events.event_type_id', '=', 'event_types.id')
            ->whereNotNull('events.end');
            
        $this->applyFilters($query);

        $result = $query->selectRaw('
            SUM(CASE WHEN event_types.is_pause_type = 1 THEN TIMESTAMPDIFF(SECOND, events.start, events.end) ELSE 0 END) as pause_seconds,
            SUM(CASE WHEN event_types.is_pause_type = 0 OR event_types.is_pause_type IS NULL THEN TIMESTAMPDIFF(SECOND, events.start, events.end) ELSE 0 END) as worked_seconds
        ')->first();

        $workedSeconds = (int) $result->worked_seconds;
        $pauseSeconds = (int) $result->pause_seconds;

        return [
            'workedSeconds' => $workedSeconds,
            'pauseSeconds' => $pauseSeconds,
            'netSeconds' => $workedSeconds - $pauseSeconds,
        ];
    }

    /**
     * Reset the pagination when the event is updated.
     *
     * @return void
     */
    public function updatingEvent(): void
    {
        $this->resetPage();
    }

    /**
     * Reset the pagination when the confirmation status is updated.
     *
     * @return void
     */
    public function updatingConfirmed(): void
    {
        $this->resetPage();
    }

    /**
     * Reset the pagination when the quantity to show is updated.
     * Cap the value at 100 to prevent DoS attacks.
     *
     * @param mixed $value The new quantity value
     * @return void
     */
    public function updatingQtytoshow($value): void
    {
        // Cap the value at 100 to prevent DoS attacks
        // Ensure minimum of 1 and cast to integer for type safety
        $this->qtytoshow = (string) min(100, max(1, (int)$value));
        $this->resetPage();
    }

    /**
     * Mark the events as ready to load.
     *
     * @return void
     */
    public function loadEvents(): void
    {
        $this->readyonload = true;
    }

    /**
     * Check if a color is dark.
     *
     * @param string $hexColor
     * @return boolean
     */
    public function isDark(string $hexColor): bool
    {
        if(empty($hexColor)) return false;
        $hexColor = str_replace('#', '', $hexColor);
        if(strlen($hexColor) != 6) return false;
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        return $luminance < 0.5;
    }

    /**
     * Toggle the authorization status of an event.
     *
     * @param int $eventId
     * @return void
     */
    public function toggleAuthorization(int $eventId): void
    {
        if (!$this->isTeamAdmin) {
            $this->dispatch('alertFail', __('You are not authorized to perform this action.'));
            return;
        }

        $event = Event::with(['eventType', 'team', 'user'])->find($eventId);

        if (!$event || !$event->eventType || !$event->eventType->is_authorizable) {
            $this->dispatch('alertFail', __('This event cannot be authorized.'));
            return;
        }

        // Clonar el evento original para auditoría
        $originalEvent = clone $event;
        
        $event->is_authorized = !$event->is_authorized;
        $event->is_open = !$event->is_authorized;

        if ($event->is_authorized) {
            $event->authorized_by_id = Auth::id();
        } else {
            $event->authorized_by_id = null;
        }

        $event->save();
        
        // Registrar auditoría SIEMPRE para cambios de autorización
        $this->insertHistory('events', $originalEvent, $event, true);
        unset($originalEvent);

        if ($event->is_authorized) {
            $event->user->notify(new EventAuthorized($event));
            $this->dispatch('alert', __('Event :id has been authorized (Status: Closed)', ['id' => $event->id]));
        } else {
            $event->user->notify(new EventDeAuthorized($event));
            $this->dispatch('alert', __('Event :id has been un-authorized (Status: Open)', ['id' => $event->id]));
        }

        $this->dispatch('eventAuthorizationChanged');
    }



    /**
     * Get the color for an event based on its type and properties.
     *
     * @param Event $event
     * @return string
     */
    public function getEventColor(Event $event): string
    {
        $defaultColor = '#3788d8';
        $specialColor = $this->team ? ($this->team->special_event_color ?? '#DC2626') : '#DC2626';
        
        if ($event->is_exceptional) {
            // Use special event color if event is exceptional
            return $specialColor;
        } elseif ($event->eventType) {
            if ($event->eventType->color) {
                // Use event type color if available
                return $event->eventType->color;
            } elseif (!$event->eventType->is_workday_type) {
                // Use special event color for non-workday types without specific color
                return $specialColor;
            }
        } else {
            // Use special event color for events without type
            return $specialColor;
        }
        
        return $defaultColor;
    }

    /**
     * Apply common filters to the query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyFilters($query)
    {
        if ($this->team) {
            $query->whereIn('events.user_id', $this->teamUsers)
                  ->where('events.team_id', $this->team->id);
        } else {
            // If no team is selected, only show user's own events or nothing
            $query->where('events.user_id', Auth::id());
        }

        $query->when($this->search, function ($q, $search) {
            $q->where(function ($subq) use ($search) {
                $subq->whereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('family_name1', 'like', '%' . $search . '%')
                            ->orWhere('family_name2', 'like', '%' . $search . '%');
                    })
                    ->orWhere('events.user_id', $search)
                    ->orWhere('events.description', 'like', '%' . $search . '%');
            });
        });

        $query->when($this->filtered, function ($q) {
            $q->when($this->filterStart, fn($query) => $query->whereDate('events.start', '>=', $this->filterStart))
              ->when($this->filterEnd, fn($query) => $query->whereDate('events.end', '<=', $this->filterEnd))
              ->when($this->filterUserId, fn($query) => $query->where('events.user_id', $this->filterUserId))
              ->when($this->filterEventTypeId, fn($query) => $query->where('events.event_type_id', $this->filterEventTypeId));
        });

        $query->when($this->confirmed, function ($q) {
            $q->where('events.is_open', '=', '1');
        });

        $query->when($this->showOnlyMine, function ($q) {
            $q->where('events.user_id', Auth::id());
        });

        return $query;
    }
}
