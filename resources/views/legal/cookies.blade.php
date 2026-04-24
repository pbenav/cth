<x-legal-layout title="Política de Cookies">
    @if($content)
        {!! $content !!}
    @else
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
            Política de Cookies
        </h1>

        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 mb-6">
            En <strong>{{ config('app.name', 'Sientia') }}</strong>, utilizamos cookies propias y de terceros para que tu experiencia sea lo más fluida y personalizada posible. A continuación, te explicamos qué son, cuáles usamos y cómo puedes gestionarlas.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">1. ¿Qué es una Cookie?</h2>
        <p class="mb-4">
            Una cookie es un pequeño archivo de texto que el sitio web almacena en tu navegador para "recordar" información sobre tu visita, como tu idioma preferido o tus credenciales de acceso.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">2. Tipos de Cookies que Usamos</h2>
        <div class="space-y-6">
            <div class="p-5 border border-gray-100 dark:border-gray-800 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">Cookies Técnicas (Necesarias)</h3>
                <p class="text-sm">
                    Son esenciales para que la plataforma funcione. Permiten el inicio de sesión seguro, la gestión de sesiones y la navegación por las diferentes secciones de SientiaMTX. Sin ellas, el servicio no podría prestarse correctamente.
                </p>
            </div>

            <div class="p-5 border border-gray-100 dark:border-gray-800 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">Cookies de Personalización</h3>
                <p class="text-sm">
                    Nos permiten recordar tus preferencias, como el idioma elegido, tu zona horaria o si prefieres el tema oscuro o claro. Hacen que no tengas que configurar todo de nuevo cada vez que entras.
                </p>
            </div>

            <div class="p-5 border border-gray-100 dark:border-gray-800 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">Cookies de Terceros (Google Calendar/OAuth)</h3>
                <p class="text-sm">
                    Si decides utilizar la sincronización con Google, Google podrá establecer sus propias cookies para gestionar la autenticación y la sincronización de datos de calendario.
                </p>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">3. Cómo Gestionar las Cookies</h2>
        <p class="mb-4">
            Puedes restringir, bloquear o borrar las cookies de SientiaMTX utilizando la configuración de tu navegador. Aquí tienes los enlaces de ayuda de los navegadores más comunes:
        </p>
        <ul class="list-disc pl-5 mb-6 space-y-2 text-blue-600 dark:text-blue-400 text-sm font-medium">
            <li><a href="https://support.google.com/chrome/answer/95647" target="_blank">Google Chrome</a></li>
            <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-sitios-web-rastrear-preferencias" target="_blank">Mozilla Firefox</a></li>
            <li><a href="https://support.apple.com/es-es/guide/safari/sfri11471/mac" target="_blank">Safari</a></li>
            <li><a href="https://support.microsoft.com/es-es/windows/eliminar-y-administrar-cookies-168dab11-0753-043d-7c16-ede5947fc64d" target="_blank">Microsoft Edge</a></li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">4. Consentimiento</h2>
        <p class="mb-6">
            Al navegar y continuar en nuestro sitio web estarás consintiendo el uso de las cookies en las condiciones contenidas en la presente Política de Cookies.
        </p>

        <div class="bg-blue-50 dark:bg-blue-900/30 p-6 rounded-2xl border border-blue-100 dark:border-blue-800 text-sm italic">
            Última actualización: 31 de marzo de 2026.
        </div>
    @endif
</x-legal-layout>
