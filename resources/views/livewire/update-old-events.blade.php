<div>
    <div class="p-4 bg-white border-b border-gray-200 sm:p-6">
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Update Old Events') }}
        </h3>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('This tool will help you update old events with the correct event type. Below is a preview of the changes that will be made. Please review them carefully before confirming.') }}
        </p>
    </div>

    <div class="p-4 bg-white border-b border-gray-200 sm:p-6">
        @if ($updateSuccess)
            <div class="p-4 text-sm text-green-700 bg-green-100 border border-green-400 rounded-md">
                {{ __('Events updated successfully.') }}
            </div>
        @else
            @if (count($proposedChanges) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Event ID') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Old Description') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Old Observations') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Proposed Event Type') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach (array_slice($proposedChanges, 0, 100) as $eventId => $change)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $eventId }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $change['old_description'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $change['old_observations'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $change['new_event_type'] }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if (count($proposedChanges) > 100)
                    <div class="mt-4 text-sm text-gray-600">
                        {{ __('Showing the first 100 changes. There are a total of :count changes to be made.', ['count' => count($proposedChanges)]) }}
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button wire:click="updateEvents">
                        {{ __('Confirm and Update Events') }}
                    </x-jet-button>
                </div>
            @else
                <p class="text-sm text-gray-600">
                    {{ __('No old events found to update.') }}
                </p>
            @endif
        @endif
    </div>
</div>
