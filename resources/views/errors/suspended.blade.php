<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 p-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-xl text-center border-t-8 border-red-600">
            
            <span class="text-7xl mb-6 block">🚫</span>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Cuenta Suspendida</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">
                El acceso para <strong>{{ auth()->user()->contract->name }}</strong> ha sido deshabilitado temporalmente.
            </p>

            <div class="bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 p-4 rounded-lg text-sm mb-8 border border-red-200 dark:border-red-800">
                Si crees que esto es un error o necesitas regularizar tu suscripción, por favor ponte en contacto con nuestro equipo de soporte.
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold py-3 px-4 rounded-lg transition">
                    Cerrar Sesión
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>