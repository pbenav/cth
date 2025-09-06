<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('teams.event-type-manager', ['team' => $team])
            </div>

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                <div class="p-4 bg-white border-b border-gray-200 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Update Old Events') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('This tool will help you update old events with the correct event type.') }}
                    </p>
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('team.update-old-events') }}" class="ml-4">
                            <x-jet-button>
                                {{ __('Update Events') }}
                            </x-jet-button>
                        </a>
                    </div>
                </div>
            </div>

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
