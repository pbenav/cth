<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'sientiaCTH :: Control Horario') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <div class="font-sans antialiased text-gray-900 border-b border-gray-100 min-h-screen">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="mt-auto border-t border-gray-200 py-4 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 font-medium">
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
</body>

</html>