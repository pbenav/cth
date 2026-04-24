<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sientia') }} — {{ __('Consentimiento Legal Obligatorio') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .heading { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased h-full flex flex-col items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col max-h-[90vh]">
        
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-4 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center shadow-lg shadow-violet-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold heading">{{ __('Actualización de Términos Legales') }}</h1>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium lowercase">{{ __('Por favor, revisa y acepta los términos actuales para continuar.') }}</p>
                </div>
            </div>
            <x-application-logo class="w-auto h-7 dark:text-white" />
        </div>

        <!-- Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-6 space-y-10 trix-content">
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-extrabold flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-xs font-bold">1</span>
                        {{ __('Política de Privacidad') }}
                    </h2>
                    <a href="{{ route('privacy') }}" target="_blank" class="text-xs text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 font-medium transition-all">
                        {{ __('Ver página completa') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50/50 dark:bg-gray-800/20 p-5 rounded-2xl border border-gray-100 dark:border-gray-800/50">
                    {!! $privacy !!}
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-extrabold flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-violet-100 dark:bg-violet-900/30 text-violet-600 flex items-center justify-center text-xs font-bold">2</span>
                        {{ __('Términos de Servicio') }}
                    </h2>
                    <a href="{{ route('terms') }}" target="_blank" class="text-xs text-violet-600 dark:text-violet-400 hover:underline flex items-center gap-1 font-medium transition-all">
                        {{ __('Ver página completa') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50/50 dark:bg-gray-800/20 p-5 rounded-2xl border border-gray-100 dark:border-gray-800/50">
                    {!! $terms !!}
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-extrabold flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 flex items-center justify-center text-xs font-bold">3</span>
                        {{ __('Política de Cookies') }}
                    </h2>
                    <a href="{{ route('cookies') }}" target="_blank" class="text-xs text-amber-600 dark:text-amber-400 hover:underline flex items-center gap-1 font-medium transition-all">
                        {{ __('Ver página completa') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed bg-gray-50/50 dark:bg-gray-800/20 p-5 rounded-2xl border border-gray-100 dark:border-gray-800/50">
                    {!! $cookies !!}
                </div>
            </section>
        </div>

        <!-- Footer / Action -->
        <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/10 shrink-0">
            <form action="{{ route('legal.accept') }}" method="POST" class="flex flex-col md:flex-row items-center justify-between gap-6">
                @csrf
                <div class="flex flex-col gap-4 flex-1">
                    <div class="flex items-start gap-3">
                        <div class="pt-0.5">
                            <input type="checkbox" name="accept" id="accept" required class="w-5 h-5 rounded-lg border-gray-300 text-violet-600 focus:ring-violet-500 transition-all cursor-pointer">
                        </div>
                        <label for="accept" class="text-sm font-medium text-gray-600 dark:text-gray-400 cursor-pointer">
                            {{ __('He leído y acepto los') }}
                            <a href="{{ route('terms') }}" target="_blank" class="font-bold text-gray-900 dark:text-white hover:text-violet-600 dark:hover:text-violet-400 underline decoration-gray-200 dark:decoration-gray-700 underline-offset-4">{{ __('Términos de Servicio') }}</a>,
                            {{ __('la') }}
                            <a href="{{ route('privacy') }}" target="_blank" class="font-bold text-gray-900 dark:text-white hover:text-violet-600 dark:hover:text-violet-400 underline decoration-gray-200 dark:decoration-gray-700 underline-offset-4">{{ __('Política de Privacidad') }}</a>
                            {{ __('y la') }}
                            <a href="{{ route('cookies') }}" target="_blank" class="font-bold text-gray-900 dark:text-white hover:text-violet-600 dark:hover:text-violet-400 underline decoration-gray-200 dark:decoration-gray-700 underline-offset-4">{{ __('Política de Cookies') }}</a>.
                            @error('accept')
                                <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </label>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="pt-0.5">
                            <input type="checkbox" name="marketing" id="marketing" class="w-5 h-5 rounded-lg border-gray-300 text-violet-600 focus:ring-violet-500 transition-all cursor-pointer">
                        </div>
                        <label for="marketing" class="text-sm font-medium text-gray-500 dark:text-gray-400 cursor-pointer">
                            {{ __('Deseo recibir actualizaciones y noticias sobre Sientia (Opcional).') }}
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white px-8 py-3 rounded-xl font-bold text-base shadow-xl shadow-violet-600/30 hover:shadow-violet-600/40 transition-all active:scale-95 shrink-0">
                    {{ __('Aceptar y Continuar') }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>
