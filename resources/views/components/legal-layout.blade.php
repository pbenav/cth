<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sientia') }} - {{ $title ?? 'Legal' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        .prose h1 { font-size: 1.875rem !important; font-weight: 800 !important; margin-bottom: 1.5rem !important; }
        .prose h2 { margin-top: 2.5rem !important; margin-bottom: 1.25rem !important; font-weight: 800 !important; font-size: 1.25rem !important; }
        .prose p { margin-bottom: 1.5rem !important; line-height: 1.8 !important; }
        .prose ul, .prose ol { margin-bottom: 1.5rem !important; }
        .prose li { margin-bottom: 0.75rem !important; list-style-type: disc !important; margin-left: 1.25rem !important; }
    </style>
</head>

<body class="font-sans text-gray-950 dark:text-gray-100 antialiased bg-gray-50 dark:bg-gray-950">
    <div class="min-h-screen flex flex-col items-center pt-12 pb-20 px-4">
        <div class="mb-12">
            <a href="/">
                <img src="{{ asset('images/sientiaCTH-logo.png') }}" class="h-12 w-auto" alt="sientiaCTH Logo">
            </a>
        </div>

        <div class="w-full max-w-4xl p-8 sm:p-16 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden sm:rounded-3xl mx-auto">
            <div class="prose dark:prose-invert prose-blue max-w-none text-gray-800 dark:text-gray-200 leading-relaxed">
                {{ $slot }}
            </div>
            
            <div class="mt-16 pt-8 border-t border-gray-100 dark:border-gray-800 text-center">
                <a href="/" class="text-sm font-bold text-violet-600 dark:text-violet-400 hover:text-violet-500 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</body>

</html>
