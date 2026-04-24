<x-legal-layout title="Términos de Servicio">
    @if($content)
        {!! $content !!}
    @else
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
            Términos de Servicio
        </h1>

        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 mb-6">
            Bienvenido a <strong>{{ config('app.name', 'Sientia') }}</strong>. Al registrarte y utilizar nuestra plataforma, aceptas de manera íntegra y sin reservas los presentes Términos de Servicio. Por favor, léelos detenidamente.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">1. Descripción del Servicio</h2>
        <p class="mb-4">
            SientiaMTX es una plataforma integral de productividad que combina la Matriz de Eisenhower (MTX), Diagramas de Gantt y Tableros Kanban, diseñada para la gestión eficiente de tareas, equipos y proyectos. El acceso a ciertas funciones puede requerir una cuenta de usuario activa.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">2. Registro y Responsabilidad de la Cuenta</h2>
        <p class="mb-4">Para utilizar SientiaMTX, debes cumplir con los siguientes requisitos:</p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li>Ser mayor de 16 años o tener el consentimiento de tus tutores legales.</li>
            <li>Proporcionar información veraz y completa durante el registro.</li>
            <li>Mantener la confidencialidad de tu contraseña y cuenta.</li>
            <li>Eres responsable de toda la actividad que ocurra bajo tu usuario.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">3. Normas de Uso</h2>
        <p class="mb-4">Nos reservamos el derecho de suspender o cancelar cuentas que incumplan las siguientes normas:</p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li>No utilizar la plataforma para actividades ilícitas o fraudulentas.</li>
            <li>Respetar la propiedad intelectual y los derechos de terceros.</li>
            <li>No subir archivos maliciosos (virus, malware) o contenido ofensivo.</li>
            <li>No interferir con el correcto funcionamiento de los servidores de Sientia.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">4. Propiedad Intelectual</h2>
        <p class="mb-4">
            El software, diseño, logotipos y contenidos de SientiaMTX son propiedad exclusiva de <strong>Pablo Benavides</strong> y están protegidos por leyes de propiedad intelectual. La licencia de uso que se concede es personal, intransferible y revocable.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">5. Limitación de Responsabilidad</h2>
        <p class="mb-4">
            SientiaMTX se ofrece "tal cual" (as is). Aunque nos esforzamos por ofrecer un servicio ininterrumpido y de calidad, no nos hacemos responsables de:
        </p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li>Pérdidas de datos accidentales (se recomienda realizar exportaciones periódicas).</li>
            <li>Interrupciones del servicio por causas técnicas ajenas a nuestro control.</li>
            <li>El mal uso de la plataforma por parte de otros usuarios en equipos compartidos.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">6. Modificaciones de los Términos</h2>
        <p class="mb-6">
            Podemos actualizar estos términos en cualquier momento. Si los cambios son significativos, te notificaremos a través del correo electrónico asociado a tu cuenta o mediante un aviso en la plataforma.
        </p>

        <div class="bg-blue-50 dark:bg-blue-900/30 p-6 rounded-2xl border border-blue-100 dark:border-blue-800 text-sm italic">
            Última actualización: 31 de marzo de 2026.
        </div>
    @endif
</x-legal-layout>
