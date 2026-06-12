<div>
    <x-button wire:click="$set('showModal', true)">
        {{ __('Move') }}
    </x-button>

    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            {{ __('Move User') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Select a destination team for') }} {{ $user->name }}.</p>

            <div class="mt-4">
                <x-label for="destination_team" value="{{ __('Destination Team') }}" />
                <select id="destination_team" class="form-select block w-full mt-1" wire:model.live="destinationTeamId">
                    <option value="">{{ __('Select a team') }}</option>
                    @foreach($eligibleTeams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <label for="transfer_events" class="flex items-center">
                    <x-checkbox id="transfer_events" wire:model.live="transferEvents" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Transfer all user event records to the new team') }}</span>
                </label>
                <p class="mt-1 text-xs text-gray-500 ml-6">
                    {{ __('If checked, all historical records from any previous team will be moved to the destination team.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="moveUser" wire:loading.attr="disabled">
                {{ __('Move User') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
