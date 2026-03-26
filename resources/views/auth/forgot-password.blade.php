<x-guest-layout>
    <x-slot name="logo">
        <div class="flex justify-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Administrarme" class="w-48 h-auto drop-shadow-sm">
            </a>
        </div>
    </x-slot>

    <div class="mb-6 text-sm text-gray-400 leading-relaxed text-center max-w-sm mx-auto">
        ¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu correo electrónico y te enviaremos un enlace seguro para que puedas elegir una nueva.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-700 space-y-5 relative overflow-hidden">
        @csrf

        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10">
            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Correo Electrónico</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="tu@correo.com"
                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <div class="pt-2 relative z-10">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 sm:py-4 rounded-xl font-bold shadow-lg hover:shadow-indigo-500/30 transition transform active:scale-95 text-lg">
                Enviar Enlace de Recuperación
            </button>
        </div>

        <div class="text-center mt-6 pt-4 border-t border-gray-700 relative z-10">
            <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-400 hover:text-indigo-300 transition">
                ← Regresar al inicio de sesión
            </a>
        </div>
    </form>
</x-guest-layout>