<x-legal-layout title="Política de Privacidad">
    @if($content)
        {!! $content !!}
    @else
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
            Política de Privacidad
        </h1>

        <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 mb-6">
            En <strong>{{ config('app.name', 'Sientia') }}</strong>, nos tomamos muy en serio la privacidad de tus datos. Esta Política de Privacidad describe cómo recopilamos, utilizamos y protegemos tu información personal cuando utilizas nuestra plataforma integral de gestión de proyectos (MTX, Gantt y Kanban).
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">1. Identificación del Responsable</h2>
        <p class="mb-4">
            De conformidad con el Reglamento General de Protección de Datos (RGPD) y la Ley Orgánica 3/2018 de Protección de Datos Personales y garantía de los derechos digitales, te informamos de que el responsable del tratamiento de tus datos es <strong>Pablo Benavides</strong> en representación de Sientia.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">2. Datos que Recopilamos</h2>
        <p class="mb-4">Para el correcto funcionamiento de SientiaMTX, recopilamos los siguientes datos:</p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li><strong>Información de Registro:</strong> Nombre, apellidos, dirección de correo electrónico y contraseña (cifrada).</li>
            <li><strong>Información de Uso:</strong> Registro de tareas (MTX, Gantt, Kanban), mensajes en foros, eventos de calendario y archivos adjuntos subidos a la plataforma.</li>
            <li><strong>Preferencias del Usuario:</strong> Idioma, zona horaria y configuración de la interfaz (tema oscuro/claro).</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">3. Finalidad del Tratamiento</h2>
        <p class="mb-4">Tus datos se utilizan exclusivamente para:</p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li>Proporcionar y gestionar tu acceso a la plataforma.</li>
            <li>Sincronizar tus tareas y eventos con servicios externos autorizados (como Google Calendar).</li>
            <li>Enviar notificaciones críticas relacionadas con tus tareas y equipos.</li>
            <li>Mejorar continuamente la experiencia de usuario y la seguridad del sistema.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">4. Base Legal</h2>
        <p class="mb-4">
            La base legal para el tratamiento de tus datos es la ejecución del contrato de servicio que aceptas al registrarte y, en su caso, el consentimiento explícito que nos prestas.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">5. Tus Derechos (ARCO-POL)</h2>
        <p class="mb-4">Puedes ejercer en cualquier momento tus derechos de:</p>
        <ul class="list-disc pl-5 mb-6 space-y-2">
            <li><strong>Acceso:</strong> Consultar qué datos tenemos sobre ti.</li>
            <li><strong>Rectificación:</strong> Corregir datos inexactos.</li>
            <li><strong>Supresión (Derecho al Olvido):</strong> Solicitar la eliminación total de tu cuenta y datos.</li>
            <li><strong>Portabilidad:</strong> Descargar tus datos en un formato legible (JSON/CSV).</li>
            <li><strong>Oposición y Limitación:</strong> Oponerte al tratamiento de ciertos datos.</li>
        </ul>
        <p class="mt-4">
            Para ejercer estos derechos, puedes utilizar las herramientas disponibles en tu perfil o contactar con nosotros directamente.
        </p>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-8 mb-4">6. Conservación de Datos</h2>
        <p class="mb-6">
            Mantendremos tus datos mientras tu cuenta esté activa. Si decides cerrarla, tus datos serán eliminados de forma permanente, salvo aquellos que debamos conservar por imperativo legal.
        </p>

        <div class="bg-blue-50 dark:bg-blue-900/30 p-6 rounded-2xl border border-blue-100 dark:border-blue-800 text-sm italic">
            Última actualización: 31 de marzo de 2026.
        </div>
    @endif
</x-legal-layout>
