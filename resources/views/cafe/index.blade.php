<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ☕ Invítame un Café
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                <div class="bg-gradient-to-r from-amber-500 to-orange-400 h-32 flex items-center justify-center">
                    <span class="text-6xl filter drop-shadow-md">☕</span>
                </div>

                <div class="p-8 text-center sm:p-12">
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                        Apoya el desarrollo del sistema
                    </h3>
                    
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                        Este software ha sido creado para bendecir y facilitar la administración de las iglesias. Si el sistema ha sido de ayuda para tu ministerio, puedes apoyarnos a mantener los servidores encendidos y crear nuevas funciones con una aportación mensual. Si tienes otra forma de aportar a nuestro ministerio te escuchamos en nuestras redes sociales. ¡Gracias por tu bendición!
                    </p>

                    <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-6 mb-8 inline-block border border-orange-100 dark:border-orange-800/50">
                        <p class="text-orange-800 dark:text-orange-300 font-bold mb-1">Tu donación incluye:</p>
                        <ul class="text-sm text-orange-700 dark:text-orange-400 text-left list-disc list-inside">
                            <li>El pago de los servidores y medios para que puedas usar nuestro sistema.</li>
                            <li>Insignia especial en tu perfil (Próximamente).</li>
                            <li>Apoyo directo al equipo de desarrollo.</li>
                        </ul>
                    </div>

                    <form action="{{ route('cafe.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-lg py-4 px-10 rounded-full shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                            💳 Suscribirme y Donar
                        </button>
                    </form>

                    <p class="text-xs text-gray-400 mt-6 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Pago seguro procesado por Stripe. No es necesario cancelar es una aportación voluntaria.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>