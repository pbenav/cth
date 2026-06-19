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

            <!-- Divider -->
            <div class="col-span-6 border-t border-gray-100 dark:border-gray-800 my-4"></div>

            <!-- Integrations Section Header -->
            <div class="col-span-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                    🔗 {{ __('Integración con MTX') }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ __('Configura la URL y la clave compartida (Secret) para conectarte con la plataforma de administración Sientia MTX.') }}
                </p>
            </div>

            <!-- MTX URL -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="mtx_url" value="{{ __('URL del Servidor MTX') }}" />
                <x-input id="mtx_url" type="url" class="mt-1 block w-full bg-gray-50 dark:bg-gray-800" wire:model="state.MTX_API_URL" placeholder="https://mtx.sientia.com" />
                <x-input-error for="state.MTX_API_URL" class="mt-2" />
                <p class="text-[11px] text-gray-400 mt-1">La URL base de MTX (ej: https://mtx.sientia.com).</p>
            </div>

            <!-- MTX Secret -->
            <div class="col-span-6 sm:col-span-4" x-data="{ showSecret: false }">
                <x-label for="mtx_secret" value="{{ __('Clave de Seguridad S2S') }}" />
                <div class="relative mt-1">
                    <x-input id="mtx_secret" x-bind:type="showSecret ? 'text' : 'password'" class="block w-full bg-gray-50 dark:bg-gray-800 pr-10" wire:model="state.MTX_S2S_SECRET" />
                    <button type="button" @click="showSecret = !showSecret" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg x-show="!showSecret" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showSecret" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error for="state.MTX_S2S_SECRET" class="mt-2" />
                <p class="text-[11px] text-gray-400 mt-1">Debe coincidir exactamente con el Secret configurado en el servidor MTX.</p>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="saved">
                Guardado.
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="newBackground, updateSettings">
                Guardar Configuración
            </x-button>
        </x-slot>
    </x-form-section>

    @if (session()->has('message'))
        <div class="mt-4 p-4 rounded-md {{ session('messageType') === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
            {{ session('message') }}
        </div>
    @endif
</div>
