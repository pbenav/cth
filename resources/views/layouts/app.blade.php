<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="Sientia Open Labs">

    <!-- Datos estructurados de Schema.org para Google (Site Name) -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "name": "Sientia Open Labs",
      "alternateName": ["Sientia", "sientiaMTX", "sientiaERP", "sientiaCTH"],
      "url": "https://sientia.com"
    }
    </script>

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    @stack('styles')

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src=" https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8" defer></script>

    <!-- Alpine.js x-cloak style -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- AlpineJS for dashboard customization (Stores are now handled by Livewire 3 bundled Alpine) -->
    @stack('alpine-stores')
</head>

<body class="font-sans antialiased">
    <x-banner />

    {{-- Impersonation Banner --}}
    @if (session()->has('impersonator_id'))
        <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white shadow-lg sticky top-0 z-50">
            <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-secret text-2xl animate-pulse"></i>
                        <div>
                            <p class="font-bold text-sm">
                                {{ __('Viewing as') }}: {{ Auth::user()->name }} {{ Auth::user()->family_name1 }}
                            </p>
                            <p class="text-xs opacity-90">
                                {{ __('You are impersonating this user') }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('impersonate.leave') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-2 bg-white text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg font-medium text-sm transition shadow-md hover:shadow-lg">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{ __('Exit Impersonation') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="h-auto bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-[90rem] sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div>
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-auto border-t border-gray-200 py-4 bg-white">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 font-medium">
            <div class="mb-2 md:mb-0 flex items-center gap-2">
                <span class="font-bold">© {{ date('Y') }} <a href="https://www.sientia.com" class="hover:underline hover:text-blue-600 transition-colors">Sientia</a></span>
                <span class="mx-1">|</span>
                <span>v{{ config('app.version', '1.0.0') }}</span>
                <span class="mx-1">|</span>
                <a href="https://www.gnu.org/licenses/agpl-3.0.txt" target="_blank"
                    class="hover:text-blue-600 transition-colors">Licencia AGPL v3</a>
            </div>
            <div class="flex items-center space-x-6">
                <!-- Open Source Links -->
                <div class="flex items-center gap-3 border-r border-gray-200 pr-4 mr-2">
                    <a href="https://github.com/pbenav" target="_blank" title="GitHub" class="hover:text-gray-900 transition-colors">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    </a>
                    <a href="https://gitlab.com/pbenav" target="_blank" title="GitLab" class="hover:text-gray-900 transition-colors">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M23.955 13.587l-1.342-4.135-2.664-8.189c-.135-.417-.724-.417-.86 0L16.425 9.452h-8.85l-2.664-8.189c-.135-.417-.724-.417-.86 0L1.387 9.452.045 13.587c-.11.34.01.711.306.925l11.65 8.458 11.648-8.458c.296-.214.416-.585.306-.925z"/></svg>
                    </a>
                </div>
                
                <div class="flex items-center gap-4 text-[10px]">
                    <a href="{{ route('privacy') }}" class="hover:text-blue-600 transition-colors">{{ __('Privacidad') }}</a>
                    <a href="{{ route('terms') }}" class="hover:text-blue-600 transition-colors">{{ __('Términos') }}</a>
                    <a href="{{ route('cookies') }}" class="hover:text-blue-600 transition-colors">{{ __('Cookies') }}</a>
                </div>
                <span class="text-gray-300 mx-1">|</span>
                <div class="flex items-center gap-5">
                    <a href="https://www.patreon.com/cw/sientia" target="_blank"
                        class="text-orange-600 hover:text-orange-700 font-bold transition-colors flex items-center gap-1.5 group">
                        <i class="fab fa-patreon group-hover:scale-110 transition-transform"></i>
                        Patreon
                    </a>
                    <span class="text-gray-300 mx-1">|</span>
                    <a href="https://buymeacoffee.com/sientia" target="_blank"
                        class="text-yellow-600 hover:text-yellow-700 font-bold transition-colors flex items-center gap-1.5 group">
                        <i class="fas fa-coffee group-hover:scale-110 transition-transform"></i>
                        Buy me a coffee
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('modals')

    @livewireScripts

    <!-- Tag to include scripts pushed from components with push -->
    @stack('scripts')

    @auth
        <script>
            window.addEventListener('new-notification', event => {
                if ({{ Auth::user()->notify_new_messages ? 'true' : 'false' }}) {
                    Swal.fire({
                        title: "{{ __('sweetalert.new_notification.title') }}",
                        text: "{{ __('sweetalert.new_notification.text') }}",
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            });
        </script>

        <!-- SweetAlert2 Listeners -->
        <script>
            // Listener for 'alertFail' events
            window.addEventListener('alertFail', event => {
                const data = event.detail[0] || event.detail;
                Swal.fire({
                    icon: 'info',
                    title: "{{ __('sweetalert.alert_fail.title') }}",
                    text: data.message,
                    showConfirmButton: true,
                    confirmButtonText: "{{ __('sweetalert.ok_button') }}",
                });
            });

            // Listener for simple success alerts
            window.addEventListener('swal:alert', event => {
                const data = event.detail[0] || event.detail;
                Swal.fire({
                    title: data.title,
                    text: data.text,
                    icon: data.icon,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            // Listener for modals that require a page reload on close
            window.addEventListener('swal:modal-reload', event => {
                const data = event.detail[0] || event.detail;
                Swal.fire({
                    icon: data.type || 'info',
                    title: data.title,
                    text: data.text,
                    showConfirmButton: true,
                    confirmButtonText: "{{ __('sweetalert.ok_button') }}",
                }).then((result) => {
                    window.location.reload();
                });
            });

            // Listener for session-flashed alerts
            @if (session()->has('alert'))
                Swal.fire({
                    title: '{{ session('alert') }}',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if (session()->has('alert-success'))
                Swal.fire({
                    title: "{{ session('alert-success') }}",
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if (session()->has('alert-fail'))
                Swal.fire({
                    icon: 'error',
                    title: "{{ __('Error') }}",
                    text: "{{ session('alert-fail') }}",
                    showConfirmButton: true,
                    confirmButtonText: "{{ __('sweetalert.ok_button') }}",
                });
            @endif
        </script>

        {{-- Geolocation capture for web events (global) --}}
        @if (Auth::user()->geolocation_enabled)
            <script>
                // Global variable to cache geolocation
                window.cachedGeoPosition = null;

                // Capture geolocation on page load
                document.addEventListener('DOMContentLoaded', function () {
                    if (navigator.geolocation) {
                        console.log('[GPS] Requesting location on page load...');
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                window.cachedGeoPosition = {
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                };
                                console.log('[GPS] Location cached globally:', window.cachedGeoPosition.latitude, window
                                    .cachedGeoPosition.longitude);
                            },
                            function (error) {
                                console.warn('[GPS] Initial capture failed:', error.message);
                            }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                        );
                    } else {
                        console.warn('[GPS] Geolocation not supported by this browser');
                    }
                });
            </script>
        @endif
    @endauth
</body>

</html>