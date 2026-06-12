<div>
    <x-form-section submit="updateSettings">
        <x-slot name="title">
            {{ __('Global Application Settings') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Configure global parameters for the application, such as the background image for login and home pages.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Background Image -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="background" value="{{ __('Current Background Image') }}" />
                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ asset($state['LOGIN_BACKGROUND_IMAGE']) }}" class="h-20 w-32 object-cover rounded shadow border border-gray-200">
                    <span class="text-xs text-gray-500">{{ $state['LOGIN_BACKGROUND_IMAGE'] }}</span>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="newBackground" value="{{ __('Upload New Background') }}" />
                <input type="file" id="newBackground" class="mt-1 block w-full" wire:model.live="newBackground" accept="image/*" />
                <x-input-error for="newBackground" class="mt-2" />
                
                <div wire:loading wire:target="newBackground" class="mt-2 text-sm text-blue-500">
                    {{ __('Uploading...') }}
                </div>
                
                @if ($newBackground)
                    <div class="mt-4">
                        <span class="text-xs text-gray-500">{{ __('Preview') }}:</span>
                        <img src="{{ $newBackground->temporaryUrl() }}" class="h-20 w-32 object-cover rounded shadow mt-1">
                    </div>
                @endif
                
                <p class="mt-2 text-xs text-gray-500">
                    {{ __('Recommended size: 1920x1080px. Format: JPG, PNG. Max: 2MB.') }}
                </p>
            </div>

            <!-- Divider -->
            <div class="col-span-6 border-t border-gray-100 dark:border-gray-800 my-4"></div>

            <!-- Legal Configuration Section Header -->
            <div class="col-span-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                    ⚖️ {{ __('Información Legal y de Privacidad') }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ __('Configura los datos del representante legal y de la empresa para que se muestren dinámicamente en las páginas de políticas de privacidad, términos de servicio y cookies.') }}
                </p>
            </div>

            <!-- Legal Representative -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="legal_representative" value="{{ __('Representante Legal') }}" />
                <x-input id="legal_representative" type="text" class="mt-1 block w-full" wire:model="state.LEGAL_REPRESENTATIVE" />
                <x-input-error for="state.LEGAL_REPRESENTATIVE" class="mt-2" />
            </div>

            <!-- Legal Company -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="legal_company" value="{{ __('Nombre de la Empresa') }}" />
                <x-input id="legal_company" type="text" class="mt-1 block w-full" wire:model="state.LEGAL_COMPANY" />
                <x-input-error for="state.LEGAL_COMPANY" class="mt-2" />
            </div>

            <!-- Legal Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="legal_email" value="{{ __('Email de Contacto') }}" />
                <x-input id="legal_email" type="email" class="mt-1 block w-full" wire:model="state.LEGAL_EMAIL" />
                <x-input-error for="state.LEGAL_EMAIL" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="newBackground, updateSettings">
                {{ __('Save Settings') }}
            </x-button>
        </x-slot>
    </x-form-section>

    @if (session()->has('message'))
        <div class="mt-4 p-4 rounded-md {{ session('messageType') === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
            {{ session('message') }}
        </div>
    @endif
</div>
