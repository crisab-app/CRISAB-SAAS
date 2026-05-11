<x-guest-layout>
    <x-slot name="logo">
        <div class="flex justify-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Administrarme" class="w-48 h-auto drop-shadow-sm transition-transform hover:scale-105">
            </a>
        </div>
    </x-slot>

    <div class="text-center mb-6 max-w-sm mx-auto">
        <h2 class="text-2xl font-bold text-gray-200 mb-2">Únete a administrarme.com</h2>
        <p class="text-sm text-gray-400">Comienza a gestionar tu ministerio de forma inteligente</p>
    </div>

    <div class="bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-700 space-y-5 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 relative z-10">
            @csrf
            
            <div class="border-b border-gray-700 pb-4 mb-4">
                <h3 class="text-sm font-bold text-indigo-400 uppercase mb-3 flex items-center">
                    <span class="bg-indigo-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs mr-2">1</span> 
                    Datos del Ministerio
                </h3>
                <div>
                    <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Nombre de la Iglesia / Ministerio *</label>
                    <input type="text" name="church_name" value="{{ old('church_name') }}" required autofocus placeholder="Ej. Iglesia Nueva Vida"
                        class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                    @error('church_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-indigo-400 uppercase mb-3 flex items-center">
                    <span class="bg-indigo-500 text-white w-5 h-5 flex items-center justify-center rounded-full text-xs mr-2">2</span> 
                    Datos del Administrador
                </h3>
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Tu Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ej. Juan Pérez"
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Teléfono (Obligatorio) *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+52 998 123 4567"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Correo (Opcional)</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Contraseña *</label>
                            <input type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase mb-1">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite la contraseña"
                                class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-700/50 mt-4">
                        <label for="captcha" class="block text-xs font-bold text-gray-400 uppercase mb-2">Resuelve el Captcha de Seguridad *</label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-3">
                            <div class="bg-white rounded-lg overflow-hidden border border-gray-600 inline-block shadow-sm">
                                {!! captcha_img('flat', ['class' => 'captcha-img-reg h-12 w-auto cursor-pointer hover:opacity-90 transition', 'title' => 'Haz clic para recargar la imagen', 'onclick' => 'this.src="/captcha/flat?"+Math.random()']) !!}
                            </div>
                            <button type="button" class="text-indigo-400 hover:text-indigo-300 transition text-sm flex items-center justify-center gap-1 bg-gray-900 border border-gray-700 py-2 px-4 rounded-lg flex-1 sm:flex-none" onclick="document.querySelector('.captcha-img-reg').src = '/captcha/flat?' + Math.random()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Recargar
                            </button>
                        </div>
                        <input type="text" name="captcha" id="captcha" required placeholder="Escribe el texto de la imagen..."
                            class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                        @error('captcha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4 pt-2">
                        <label for="terms_register" class="inline-flex items-start">
                            <input id="terms_register" type="checkbox" class="rounded bg-gray-900 border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 mt-1 cursor-pointer transition" name="terms" required>
                            <span class="ms-3 text-sm text-gray-400">
                                He leído y acepto los <a href="{{ route('terminos') }}" target="_blank" class="font-bold text-indigo-400 hover:text-indigo-300 transition">Términos de Servicio</a> y el <a href="{{ route('privacidad') }}" target="_blank" class="font-bold text-indigo-400 hover:text-indigo-300 transition">Aviso de Privacidad</a>.
                            </span>
                        </label>
                        @error('terms') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 sm:py-4 rounded-xl font-bold shadow-lg hover:shadow-indigo-500/30 transition transform active:scale-95 text-lg">
                    Registrarme
                </button>
            </div>
        </form>

        <div class="relative z-10 mt-6 pt-4 border-t border-gray-700">
            <div class="absolute inset-0 flex items-center mt-4">
                <div class="w-full border-t border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-gray-800 text-gray-400 font-medium">Registro Rápido</span>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-600 rounded-xl shadow-sm bg-gray-900 text-sm font-bold text-gray-300 hover:bg-gray-700 transition duration-150 transform active:scale-95">
                    <svg class="h-5 w-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Registrarme con Google
                </a>
            </div>
        </div>

        <div class="text-center mt-6 relative z-10">
            <a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-white transition font-medium">¿Ya tienes una cuenta? <span class="text-indigo-400 underline hover:text-indigo-300">Inicia sesión aquí</span></a>
        </div>
    </div>
</x-guest-layout>