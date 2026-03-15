<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-4xl mt-6 p-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg prose dark:prose-invert">
                
                <h1 class="text-3xl font-bold mb-6 text-indigo-600 dark:text-indigo-400">Términos y Condiciones de Uso</h1>
                <p class="text-sm text-gray-500 mb-8">Última actualización: {{ date('d/m/Y') }}</p>

                <h3 class="text-xl font-bold mt-6 mb-2">1. Aceptación de los Términos</h3>
                <p>Al acceder y utilizar <strong>Administrarme.com</strong>, usted acepta estar sujeto a estos Términos y Condiciones. Si no está de acuerdo con alguna parte de estos términos, no podrá acceder al servicio.</p>

                <h3 class="text-xl font-bold mt-6 mb-2">2. Uso de la Plataforma y Cuentas</h3>
                <p>El usuario es responsable de mantener la confidencialidad de su cuenta y contraseña. <strong>Administrarme.com</strong> proporciona herramientas para la gestión de iglesias, pero la veracidad y legalidad de los datos ingresados son responsabilidad exclusiva del usuario administrador (la iglesia).</p>

                <h3 class="text-xl font-bold mt-6 mb-2">3. Descargo de Responsabilidad (Disclaimer)</h3>
                <p>El servicio se proporciona "tal cual". <strong>Administrarme.com</strong> no garantiza que el servicio será ininterrumpido o libre de errores (por ejemplo, caídas de servidores de terceros). No nos hacemos responsables por la pérdida de datos accidental causada por el mal uso de los usuarios dentro de sus paneles de administración.</p>

                <h3 class="text-xl font-bold mt-6 mb-2">4. Cancelación y Suspensión</h3>
                <p>Nos reservamos el derecho de suspender o cancelar cuentas que violen estos términos, realicen actividades ilícitas o incumplan con los pagos de suscripción correspondientes.</p>

                <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                    <a href="{{ url('/') }}" class="text-indigo-600 hover:text-indigo-500 font-bold">← Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>