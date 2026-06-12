<x-authentication-card>
    <x-slot name="logo">
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/sientiaCTH-logo.png') }}" alt="{{ config('app.name') }}" class="w-20 h-20 object-contain mb-2">
            <h1 class="text-2xl font-bold text-gray-800">{{ config('app.name') }}</h1>
        </div>
    </x-slot>

    <div class="mb-6 text-sm text-gray-600 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-md">
        <div class="flex items-center gap-2 mb-1">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
            <strong class="font-bold text-blue-800">{{ __('Modo Fichaje') }}</strong>
        </div>
        <p class="text-blue-700 ml-7">
            {{ __('Para acceder a las opciones avanzadas de gestión debes verificar tu identidad introduciendo tu contraseña.') }}
        </p>
    </div>

    <form wire:submit="unlock">
        <div>
            <x-label for="password" value="{{ __('Contraseña') }}" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <x-input id="password" class="block w-full pl-10 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" type="password" wire:model="password" required autofocus autocomplete="current-password" placeholder="{{ __('Tu contraseña') }}" />
            </div>
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('inicio') }}" class="text-sm text-gray-500 hover:text-gray-800 transition-colors underline decoration-gray-300 hover:decoration-gray-800">
                &larr; {{ __('Volver a Fichaje') }}
            </a>
            
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-blue-700 hover:to-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition-all shadow-md">
                <svg wire:loading wire:target="unlock" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Desbloquear') }}
            </button>
        </div>
    </form>
</x-authentication-card>
