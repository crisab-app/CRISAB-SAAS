<x-guest-layout>
    @php
        $versiculos = [
            ["texto" => "Todo lo puedo en Cristo que me fortalece.", "cita" => "Filipenses 4:13"],
            ["texto" => "Porque yo sé los pensamientos que tengo acerca de vosotros, dice Jehová, pensamientos de paz, y no de mal...", "cita" => "Jeremías 29:11"],
            ["texto" => "Fíate de Jehová de todo tu corazón, y no te apoyes en tu propia prudencia.", "cita" => "Proverbios 3:5"],
            ["texto" => "Jehová es mi pastor; nada me faltará.", "cita" => "Salmos 23:1"],
            ["texto" => "Mira que te mando que te esfuerces y seas valiente; no temas ni desmayes, porque Jehová tu Dios estará contigo...", "cita" => "Josué 1:9"],
            ["texto" => "Clama a mí, y yo te responderé, y te enseñaré cosas grandes y ocultas que tú no conoces.", "cita" => "Jeremías 33:3"],
            ["texto" => "Mas buscad primeramente el reino de Dios y su justicia, y todas estas cosas os serán añadidas.", "cita" => "Mateo 6:33"],
            ["texto" => "Y sabemos que a los que aman a Dios, todas las cosas les ayudan a bien...", "cita" => "Romanos 8:28"],
            ["texto" => "Pon en manos del Señor todas tus obras, y tus proyectos se cumplirán.", "cita" => "Proverbios 16:3"]
        ];
        // Seleccionamos uno al azar
        $versiculo = $versiculos[array_rand($versiculos)];
    @endphp

    <x-slot name="logo">
        <div class="flex justify-center mb-2">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Administrarme" class="w-48 h-auto drop-shadow-sm">
            </a>
        </div>
    </x-slot>

    <div class="text-center mb-6 max-w-sm mx-auto">
        <h2 class="text-2xl font-bold text-gray-200 mb-2">¡Bienvenido de vuelta!</h2>
        
        <div class="bg-gray-800/80 border border-indigo-500/30 rounded-xl p-4 mt-4 shadow-inner relative overflow-hidden">
            <div class="absolute -top-4 -left-4 w-12 h-12 bg-indigo-500/20 rounded-full blur-xl"></div>
            
            <p class="text-sm text-indigo-100 italic mb-2 relative z-10 leading-relaxed">"{{ $versiculo['texto'] }}"</p>
            <p class="text-xs text-indigo-400 font-black tracking-wide relative z-10">- {{ $versiculo['cita'] }}</p>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-xl border border-gray-700 space-y-5 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Correo Electrónico o Teléfono</label>
                <input id="email" type="text" name="email" :value="old('email')" required autofocus placeholder="tu@correo.com o +52..."
                    class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <div class="relative z-10">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                    class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between pt-2 relative z-10">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-600 text-indigo-500 shadow-sm focus:ring-indigo-500 transition" name="remember">
                    <span class="ms-2 text-sm text-gray-400 group-hover:text-gray-200 transition">Recordarme</span>
                </label>
            <div class="mt-4">
                <label for="captcha" class="block text-sm font-medium text-gray-400 uppercase mb-1">Resuelve el Captcha de Seguridad *</label>
                <div class="flex items-center gap-3 mt-1 mb-2">
                    <span class="rounded-lg overflow-hidden border border-gray-600">{!! captcha_img('flat') !!}</span>
                    <button type="button" class="text-indigo-400 hover:text-indigo-300 transition text-sm flex items-center gap-1" onclick="document.querySelector('.captcha-img').src = '/captcha/flat?' + Math.random()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Recargar
                    </button>
                </div>
                <input type="text" name="captcha" id="captcha" required placeholder="Escribe el texto de la imagen..."
                    class="w-full bg-gray-900 border-gray-700 rounded-lg text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                
                <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
            </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <div class="pt-4 relative z-10">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 sm:py-4 rounded-xl font-bold shadow-lg hover:shadow-indigo-500/30 transition transform active:scale-95 text-lg">
                    Iniciar Sesión
                </button>
            </div>
        </div>

        <div class="text-center mt-8 pt-4">
            <p class="text-sm text-gray-500">¿Aún no tienes una cuenta para tu ministerio?</p>
            <a href="{{ route('register') }}" class="font-bold text-indigo-400 hover:text-indigo-300 transition inline-block mt-1">
                Registra tu iglesia gratis aquí
            </a>
        </div>
    </form>
</x-guest-layout>