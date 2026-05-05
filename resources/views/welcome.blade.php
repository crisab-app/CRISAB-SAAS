<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Administrarme | Software de Gestión Organizacional y Financiera</title>
    <meta name="description" content="Optimiza la gestión de tu organización con Administrarme. Controla la tesorería, asigna tareas y genera reportes financieros en minutos. ¡Prueba gratis!">
    
    <meta property="og:title" content="Administrarme | Software de Gestión Organizacional y Financiera">
    <meta property="og:description" content="Plataforma SaaS integral para la administración, gestión de tareas y control de tesorería.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ asset('images/og-card.png') }}">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Administrarme",
      "operatingSystem": "Windows, macOS, Android, iOS, Web",
      "applicationCategory": "BusinessApplication",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      },
      "description": "Plataforma SaaS integral para la administración, gestión de tareas y control de tesorería de organizaciones y proyectos."
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 selection:bg-indigo-500 selection:text-white">

    <header class="fixed w-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-md z-50 border-b border-gray-100 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-application-logo class="h-10 w-auto text-indigo-600 dark:text-indigo-400" />
                <span class="font-black text-2xl tracking-tighter text-gray-900 dark:text-white">Administrarme</span>
            </div>
            
            <nav class="hidden md:flex gap-8 font-bold text-sm uppercase tracking-widest text-gray-600 dark:text-gray-400">
                <a href="#soluciones" class="hover:text-indigo-600 transition">Soluciones</a>
                <a href="#precios" class="hover:text-indigo-600 transition">Precios</a>
                <a href="#faq" class="hover:text-indigo-600 transition">Preguntas</a>
            </nav>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-indigo-600 hover:underline">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-indigo-600 transition">Entrar</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden sm:block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-lg shadow-indigo-500/20">
                                Regístrate Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main>
        <section class="relative pt-32 pb-20 px-4 overflow-hidden">
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-6 text-gray-900 dark:text-white leading-tight">
                    La plataforma SaaS para la <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">administración inteligente</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-10 max-w-3xl mx-auto font-medium">
                    Organiza tareas, controla la tesorería y genera reportes automatizados desde una sola aplicación intuitiva y rápida.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-20">
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/40 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                        Iniciar en 2 Minutos
                    </a>
                    <a href="#soluciones" class="px-10 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-black rounded-2xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                        Ver Soluciones
                    </a>
                </div>

                <div class="relative max-w-5xl mx-auto group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur-2xl opacity-20 group-hover:opacity-30 transition duration-1000"></div>

                    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-[0_32px_64px_-15px_rgba(0,0,0,0.2)] overflow-hidden border border-gray-100 dark:border-gray-700 transform transition-all duration-500 group-hover:scale-[1.02]">
                        
                        <div class="bg-gray-100 dark:bg-gray-900 px-5 py-3 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <span class="ml-4 text-xs font-bold text-gray-400 tracking-widest uppercase">administrarme.com - dashboard</span>
                        </div>

                        <div class="p-4 md:p-8 bg-gray-50 dark:bg-gray-900 text-left">
                            <div class="bg-indigo-950 p-4 rounded-xl flex items-center justify-between text-white mb-8 shadow-inner">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center font-black">A</div>
                                    <span class="font-bold hidden sm:block">Panel de Control</span>
                                </div>
                                <div class="flex gap-2 text-[10px] font-black uppercase tracking-tighter">
                                    <span class="bg-indigo-700 px-3 py-1 rounded-md">Inicio</span>
                                    <span class="opacity-50 px-3 py-1">Finanzas</span>
                                    <span class="opacity-50 px-3 py-1">Tareas</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <div class="flex justify-between items-center mb-6">
                                        <h4 class="font-bold text-gray-400 text-xs uppercase">Tesorería</h4>
                                        <span class="text-green-500 font-black">+$4,250.00</span>
                                    </div>
                                    <div class="flex items-end gap-2 h-24">
                                        <div class="flex-1 bg-indigo-100 dark:bg-indigo-900/50 h-12 rounded-lg"></div>
                                        <div class="flex-1 bg-indigo-100 dark:bg-indigo-900/50 h-16 rounded-lg"></div>
                                        <div class="flex-1 bg-indigo-600 h-24 rounded-lg"></div>
                                        <div class="flex-1 bg-indigo-200 h-20 rounded-lg"></div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <h4 class="font-bold text-gray-400 text-xs uppercase mb-4">Tareas Próximas</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                            <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                            <span class="text-sm font-bold">Reporte de Cuotas</span>
                                        </div>
                                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-xl">
                                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                            <span class="text-sm font-bold">Reunión de Mesa Directiva</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-white dark:bg-gray-800 border-y border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-center gap-10 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                <span class="font-black text-xl">+10,000 TAREAS</span>
                <span class="font-black text-xl">FINANZAS CLARAS</span>
                <span class="font-black text-xl">REPORTES PDF</span>
                <span class="font-black text-xl">MÁXIMA SEGURIDAD</span>
            </div>
        </section>

        <section id="soluciones" class="py-24 px-4 max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black mb-4">Diseñado para resolver lo difícil</h2>
                <p class="text-gray-500 font-medium">Olvida las hojas de cálculo confusas y el caos de mensajes.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 transition shadow-sm">
                    <div class="w-14 h-14 bg-indigo-100 dark:bg-indigo-900 rounded-2xl flex items-center justify-center text-2xl mb-6">💰</div>
                    <h3 class="text-xl font-black mb-4">Control de Tesorería</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">
                        Administra ingresos, cuotas y gastos con transparencia total y sin hojas de cálculo complejas. Todo cuadra siempre.
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 transition shadow-sm">
                    <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-2xl flex items-center justify-center text-2xl mb-6">👥</div>
                    <h3 class="text-xl font-black mb-4">Gestión de Tareas</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">
                        Asigna responsabilidades a tu equipo, monitorea el progreso de los proyectos y mantén a todos en la misma página.
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500 transition shadow-sm">
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-2xl flex items-center justify-center text-2xl mb-6">📊</div>
                    <h3 class="text-xl font-black mb-4">Reportes Automatizados</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed font-medium">
                        Exporta estados financieros y resúmenes ejecutivos en PDF o Excel con un solo clic. Listos para tus juntas.
                    </p>
                </div>
            </div>
        </section>

        <section id="precios" class="py-24 bg-gray-900 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 blur-[120px]"></div>
            <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                <h2 class="text-4xl font-black mb-16 text-white">Transparencia desde el primer día</h2>
                
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="p-10 bg-white/5 border border-white/10 rounded-[2.5rem] backdrop-blur-md">
                        <h4 class="text-xl font-bold mb-2">Plan Gratuito</h4>
                        <div class="text-5xl font-black mb-6">$0 <span class="text-sm font-medium opacity-50">/ siempre</span></div>
                        <ul class="text-left space-y-4 mb-10 opacity-70">
                            <li class="flex items-center gap-2"><span>✅</span> Control básico de miembros</li>
                            <li class="flex items-center gap-2"><span>✅</span> Gestión de tesorería</li>
                            <li class="flex items-center gap-2"><span>✅</span> Registro de actividades</li>
                        </ul>
                        <a href="{{ route('register') }}" class="block w-full py-4 rounded-2xl border border-white/20 font-black hover:bg-white/10 transition">Empezar Ahora</a>
                    </div>
                    <div class="p-10 bg-indigo-600 rounded-[2.5rem] shadow-2xl shadow-indigo-500/40 transform md:-translate-y-6">
                        <div class="inline-block bg-white/20 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4">Soporte Solidario</div>
                        <h4 class="text-xl font-bold mb-2">Invitarnos un Café</h4>
                        <div class="text-2xl font-black mb-6">Aportación Voluntaria</div>
                        <ul class="text-left space-y-4 mb-10">
                            <li class="flex items-center gap-2"><span>🚀</span> Sin límites de almacenamiento</li>
                            <li class="flex items-center gap-2"><span>🚀</span> Reportes avanzados PDF</li>
                            <li class="flex items-center gap-2"><span>🚀</span> Soporte prioritario</li>
                        </ul>
                        <a href="{{ route('register') }}" class="block w-full py-4 bg-white text-indigo-600 rounded-2xl font-black shadow-xl transition hover:bg-gray-100">Donar y Unirse</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-24 px-4 max-w-3xl mx-auto">
            <h2 class="text-3xl font-black text-center mb-12">Dudas frecuentes</h2>
            <div class="space-y-4" x-data="{ active: null }">
                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                    <button @click="active !== 1 ? active = 1 : active = null" class="w-full p-6 text-left font-black flex justify-between items-center bg-white dark:bg-gray-800">
                        ¿Cómo protege administrarme.com mis datos financieros?
                        <span class="text-xl" x-text="active === 1 ? '-' : '+'"></span>
                    </button>
                    <div x-show="active === 1" x-collapse class="p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700 text-gray-500">
                        Utilizamos encriptación SSL de nivel bancario y respaldos diarios para asegurar que tu información esté siempre disponible y segura.
                    </div>
                </div>
                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                    <button @click="active !== 2 ? active = 2 : active = null" class="w-full p-6 text-left font-black flex justify-between items-center bg-white dark:bg-gray-800">
                        ¿Es realmente gratuito para organizaciones pequeñas?
                        <span class="text-xl" x-text="active === 2 ? '-' : '+'"></span>
                    </button>
                    <div x-show="active === 2" x-collapse class="p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700 text-gray-500">
                        Sí, las funciones principales no tienen costo. Nuestro modelo se basa en aportaciones voluntarias de quienes desean funciones extra o simplemente apoyar el proyecto.
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12 border-t border-gray-100 dark:border-gray-800 text-center">
        <p class="text-gray-400 text-sm font-bold">© 2026 Administrarme.com - Gestión Inteligente.</p>
    </footer>

</body>
</html>