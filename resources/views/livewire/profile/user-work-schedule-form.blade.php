<div id="work-schedule-section">
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Horario Laboral') }}
        </x-slot>

    <x-slot name="description">
        {{ __('Define los tramos horarios de tu jornada laboral. Esto ayudará a que el sistema te sugiera la hora de entrada y salida al crear un nuevo evento.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        @foreach ($schedule as $index => $item)
            <div class="col-span-6 sm:col-span-2">
                <x-label for="start_time_{{ $index }}" value="{{ __('Hora de inicio') }}" />
                <x-input id="start_time_{{ $index }}" type="time" class="mt-1 block w-full"
                    wire:model="schedule.{{ $index }}.start" />
                <x-input-error for="schedule.{{ $index }}.start" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-2">
                <x-label for="end_time_{{ $index }}" value="{{ __('Hora de fin') }}" />
                <x-input id="end_time_{{ $index }}" type="time" class="mt-1 block w-full"
                    wire:model="schedule.{{ $index }}.end" />
                <x-input-error for="schedule.{{ $index }}.end" class="mt-2" />
            </div>
            <div class="col-span-6 sm:w-full">
                <div class="flex flex-col">
                    <div>
                        <x-label value="{{ __('Días') }}" />
                        <div class="mt-2 flex flex-wrap space-x-4">
                            @php
                                $daysISO = [
                                    1 => 'L', // Lunes
                                    2 => 'M', // Martes
                                    3 => 'X', // Miércoles
                                    4 => 'J', // Jueves
                                    5 => 'V', // Viernes
                                    6 => 'S', // Sábado
                                    7 => 'D'  // Domingo
                                ];
                            @endphp
                            @foreach ($daysISO as $isoNumber => $dayLabel)
                                <label class="inline-flex items-center">
                                    <span class="mr-2 ml-2 text-gray-700">{{ $dayLabel }}</span>
                                    <input type="checkbox" wire:model.live="schedule.{{ $index }}.days"
                                        value="{{ $isoNumber }}" class="form-checkbox h-5 w-5 text-indigo-600">
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <x-danger-button type="button" wire:click="removeScheduleRow({{ $index }})">
                            {{ __('Eliminar') }}
                        </x-danger-button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-span-6 text-right">
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-secondary-button type="button" wire:click="addScheduleRow" class="mr-3">
            {{ __('Añadir tramo') }}
        </x-secondary-button>

        <x-button>
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
</div>
