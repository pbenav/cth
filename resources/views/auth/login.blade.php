<x-guest-layout>
    <div class="flex flex-col justify-center py-4 min-h-screen bg-gray-100 relative items-center dark:bg-gray-900 sm:pt-0"
        style="background-image: url('{{ config('view.login_background_image') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
        
        <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="mr-2 underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('front') }}">
                    {{ __('Login with code') }}
                </a>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-2">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    </div>
</x-guest-layout>
