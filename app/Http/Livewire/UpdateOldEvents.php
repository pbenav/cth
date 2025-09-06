<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\EventType;
use Livewire\Component;

class UpdateOldEvents extends Component
{
    public $oldEvents;
    public $proposedChanges;
    public $updateSuccess = false;

    public function mount()
    {
        $this->oldEvents = Event::whereNull('event_type_id')->get();
        $this->proposedChanges = $this->classifyEvents($this->oldEvents);
    }

    private function classifyEvents($events)
    {
        $eventTypes = EventType::all()->keyBy('name');
        $changes = [];

        $jornadaLaboralId = $eventTypes->get('Jornada laboral')->id ?? null;
        $eventoEspecialId = $eventTypes->get('Evento especial')->id ?? null;
        $vacacionesId = $eventTypes->get('vacaciones')->id ?? null;
        $asuntosPropiosId = $eventTypes->get('asuntos propios')->id ?? null;

        foreach ($events as $event) {
            $newTypeId = null;
            $description = strtolower($event->description);
            $observations = strtolower($event->observations);

            if ($description === 'jornada laboral') {
                $newTypeId = $jornadaLaboralId;
            } elseif ($description === 'otros') {
                $newTypeId = $eventoEspecialId;
            } elseif (str_contains($description, 'vacaciones') || str_contains($observations, 'vacaciones')) {
                $newTypeId = $vacacionesId;
            } elseif (str_contains($description, 'asuntos propios') || str_contains($observations, 'asuntos propios')) {
                $newTypeId = $asuntosPropiosId;
            } else {
                $newTypeId = $eventoEspecialId;
            }

            if ($newTypeId) {
                $changes[$event->id] = [
                    'old_description' => $event->description,
                    'old_observations' => $event->observations,
                    'new_event_type' => EventType::find($newTypeId)->name,
                    'new_event_type_id' => $newTypeId,
                ];
            }
        }

        return $changes;
    }

    public function updateEvents()
    {
        foreach ($this->proposedChanges as $eventId => $change) {
            $event = Event::find($eventId);
            if ($event) {
                $event->event_type_id = $change['new_event_type_id'];
                $event->save();
            }
        }

        $this->updateSuccess = true;
    }

    public function render()
    {
        return view('livewire.update-old-events');
    }
}
