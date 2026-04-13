<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdministrarMe - Gestión Moderna para tu Iglesia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body class="font-[figtree] antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 selection:bg-indigo-500 selection:text-white">

    <nav class="absolute top-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-3xl">⛪</span>
                    <span class="font-extrabold text-2xl tracking-tight text-indigo-600 dark:text-indigo-400">AdministrarMe</span>
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition">Ir al Panel &rarr;</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400 transition">Iniciar Sesión</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-full shadow-lg transition transform hover:scale-105">Crear Cuenta</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="flex justify-center mb-8">
                <img src="{{ asset('image\logo.png') }}" alt="AdministrarMe Escudo" class="h-28 md:h-32 w-auto object-contain drop-shadow-2xl" 
                     onerror="this.outerHTML='<div class=\'h-24 w-24 md:h-28 md:w-28 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl rotate-45 flex items-center justify-center shadow-2xl mx-auto border-4 border-white dark:border-gray-800\'><span class=\'-rotate-45 text-4xl md:text-5xl text-white font-extrabold\'>AM</span></div>'">
            </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-sm">
                Organiza tu ministerio, campos, devocionales personales, lleva un registro dia a dia.<br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">sin complicaciones</span>
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-10">
                La plataforma todo en uno para iglesias. Gestiona miembros, organiza tus lecturas biblicas, actividades, devocionales y predicas, crea calendarios y mantén a tu comunidad conectada desde cualquier lugar.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-full shadow-xl transition transform hover:-translate-y-1 text-lg">
                    Comenzar Gratis
                </a>
                <a href="#caracteristicas" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 font-bold py-4 px-8 rounded-full shadow-md transition text-lg">
                    Ver Funciones
                </a>
            </div>
        </div>
        
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-10 opacity-20 dark:opacity-10 pointer-events-none">
            <div class="absolute w-[800px] h-[800px] rounded-full bg-indigo-500 blur-3xl -top-40 left-1/2 transform -translate-x-1/2"></div>
        </div>
    </div>

    <div id="caracteristicas" class="py-20 bg-white dark:bg-gray-800/50 border-y border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-indigo-600 dark:text-indigo-400 font-bold tracking-wide uppercase mb-2">Características Principales</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold">Todo lo que tu ministerio necesita</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition">
                    <div class="text-4xl mb-4">👥</div>
                    <h4 class="text-xl font-bold mb-3">Gestión de Miembros</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Crea un directorio digital completo. Registra bautismos, fechas de nacimiento, información de contacto y asigna roles y privilegios de manera segura.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition relative overflow-hidden">
                    <div class="text-4xl mb-4">📅</div>
                    <h4 class="text-xl font-bold mb-3">Calendario y actividades</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Programa reuniones, cultos y actividades. Genera y exporta en PDF el orden de servicio, incluyendo bosquejos de predicación y lecturas bíblicas.
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition">
                    <div class="text-4xl mb-4">🔒</div>
                    <h4 class="text-xl font-bold mb-3">Roles y Privacidad</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Protege la información de tu iglesia. Decide quién puede ver eventos privados, administrar finanzas o dar de alta a nuevos miembros o creyentes(crea un seguimiento personal a los nuevos).
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-24 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-6">¿Listo para modernizar tu iglesia?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-10">Únete a AdministrarMe hoy y dedica menos tiempo a la administración y más tiempo a las personas.</p>
            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-10 rounded-full shadow-2xl transition transform hover:scale-105 text-xl">
                Crea tu cuenta ahora
            </a>
        </div>
    </div>

<footer class="bg-gray-100 dark:bg-gray-950 py-10 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl">⛪</span>
                <span class="font-bold text-gray-800 dark:text-gray-200">AdministrarMe.com</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} Todos los derechos reservados.
            </p>
            <div class="flex gap-6 items-center">
                <a href="{{ route('privacidad') }}" class="text-sm text-gray-500 hover:text-indigo-500 transition">Aviso de Privacidad</a>
                
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-indigo-500 transition">Iniciar Sesión</a>
            </div>
        </div>
    </footer>

</body>
</html>