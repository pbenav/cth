@props(['isteamadmin', 'isinspector', 'eventTypes', 'teamUserList'])
<div>
    <x-dialog-modal wire:model.live="showFiltersModal">

        <x-slot name="title">
            {{ __('Set filters to get time register') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label value="{{ __('Start date') }}" class="mt-3 mr-2 required" />
                <x-input type="date" class="mr-2" wire:model='filter.start' />
                <x-input-error for='filter.start' />

                <x-label value="{{ __('End date') }}" class="mt-3 mr-2 required" />
                <x-input type="date" class="mr-2" wire:model='filter.end' />
                <x-input-error for='filter.end' />
            </div>

            <div class="mb-4 flex flex-row flex-wrap gap-2">
                @if ($isteamadmin || $isinspector)
                    <div class="mb-4">
                        <x-label value="{{ __('User') }}" />
                        <select class="sl-select" wire:model='filter.user_id'>
                            <option value="">{{ __('All') }}</option>
                            @if (isset($teamUserList))
                                @foreach ($teamUserList as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name_with_dni }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error for='filter.user_id' />
                    </div>
                @endif
                <div class="mb-4 text-left sm:text-center">
                    <x-label class="whitespace-nowrap" value="{{ __('Not confirmed') }}" />

                    <x-checkbox class="h-6 w-6 text-gray-600 checked:text-green-600"
                        wire:model='filter.is_open' />
                    <x-input-error for='filter.is_open' />
                </div>
            </div>

            <div class="mb-4">
                <x-label value="{{ __('Event Type') }}" />
                <select class="sl-select" wire:model='filter.event_type_id'>
                    <option value="">{{ __('All') }}</option>
                    @if (isset($eventTypes))
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType->id }}">{{ $eventType->name }}</option>
                        @endforeach
                    @endif
                </select>
                <x-input-error for='filter.event_type_id' />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeFiltersModal">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button wire:click="applyFiltersFromModal" wire:loading.attr="disabled"
                class="ml-2 disabled:bg-blue-500">
                {{ __('Apply filters') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
