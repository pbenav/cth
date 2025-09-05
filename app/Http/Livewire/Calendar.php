<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    protected $listeners = ['addEvent', 'editEvent'];

    public function addEvent($date)
    {
        $this->emitTo('events.add-event', 'add', 'calendar', $date);
    }

    public function editEvent($eventId)
    {
        $this->emitTo('events.edit-event', 'edit', $eventId);
    }

    public function render()
    {
        $events = Event::with('eventType')->where('user_id', Auth::id())->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->eventType ? $event->eventType->color : null,
            ];
        });

        return view('livewire.calendar', [
            'events' => json_encode($events)
        ]);
    }
}
