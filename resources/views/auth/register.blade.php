<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" class="required" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="family_name1" value="{{ __('Family Name 1') }}" class="required" />
                <x-input id="family_name1" class="block mt-1 w-full" type="text" name="family_name1"
                    :value="old('family_name1')" required autofocus autocomplete="familyname1" />
            </div>

            <div class="mt-4">
                <x-label for="family_name2" value="{{ __('Family Name 2') }}" />
                <x-input id="family_name2" class="block mt-1 w-full" type="text" name="family_name2"
                    :value="old('family_name2')" autocomplete="familyname2" />
            </div>

            <div class="mt-4">
                <x-label for="dni" value="{{ __('DNI/NIE') }}" class="required" />
                <x-input id="dni" class="block mt-1 w-full" type="text" name="dni"
                    :value="old('dni')" required autocomplete="dni" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" class="required" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="required" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <p class="text-sm text-gray-600 mt-1">{{ __('Must be at least 8 characters.') }}</p>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="required" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="user_code" value="{{ __('Choose a User Code') }}" class="required" />
                <x-input id="user_code" class="block mt-1 w-full" type="text" name="user_code" :value="old('user_code')"
                    required auto-complete="user_code" />
                <p class="text-sm text-gray-600 mt-1">{{ __('Must be between 8 and 10 characters.') }}</p>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" />

                            <div class="ml-2 required">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('privacy') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">                

                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('front') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
