<div>
    <div wire:ignore id='calendar' style="width: 100%; height: 100%;"></div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                events: {!! $events !!},
                editable: true,
                selectable: true,
                dateClick: function(info) {
                    @this.emit('addEvent', info.dateStr);
                },
                eventClick: function(info) {
                    @this.emit('editEvent', info.event.id);
                }
            });
            calendar.render();
        });
    </script>
    @endpush

    @livewire('events.add-event')
    @livewire('events.edit-event')
</div>
