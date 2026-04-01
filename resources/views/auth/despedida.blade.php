<x-guest-layout>
    <div class="text-center py-8">
        <div class="text-6xl mb-4 drop-shadow-lg">👋</div>
        <h2 class="text-3xl font-extrabold text-white mb-2">¡Hasta pronto!</h2>
        <p class="text-gray-400 text-lg mb-8">Has cerrado sesión correctamente de AdministrarMe. Que Dios te bendiga y tengas un excelente día.</p>
        
        <a href="{{ route('login') }}" class="inline-block w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:scale-105 active:scale-95">
            Volver a Iniciar Sesión
        </a>
    </div>
</x-guest-layout>