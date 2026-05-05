<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrarme | Software de Gestión Organizacional y Financiera</title>
    <meta name="description" content="Optimiza la gestión de tu organización con Administrarme. Controla la tesorería, asigna tareas y genera reportes financieros en minutos. ¡Prueba gratis!">
    
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Administrarme | Software de Gestión Organizacional y Financiera">
    <meta property="og:description" content="Optimiza la gestión de tu organización con Administrarme. Controla la tesorería, asigna tareas y genera reportes financieros en minutos.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}"> <script type="application/ld+json">
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

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100">

    <header class="fixed w-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-md z-50 border-b border-gray-100 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-application-logo class="h-8 w-auto text-indigo-600 dark:text-indigo-400" />
                <span class="font-bold text-xl tracking-tight">Administrarme</span>
            </div>
            
            <nav class="hidden md:flex gap-6">
                <a href="#soluciones" class="hover:text-indigo-600 transition">Soluciones</a>
                <a href="#precios" class="hover:text-indigo-600 transition">Precios</a>
            </nav>

            <div>
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md">
                    Regístrate Gratis
                </a>
            </div>
        </div>
    </header>

    <section class="pt-32 pb-20 px-4 text-center max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 text-gray-900 dark:text-white">
            La plataforma SaaS para la administración <span class="text-indigo-600 dark:text-indigo-400">inteligente de tu organización</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">
            Organiza tareas, controla la tesorería y genera reportes automatizados desde una sola aplicación intuitiva y rápida.
        </p>
        
        <form action="{{ route('register') }}" method="GET" class="flex flex-col sm:flex-row justify-center gap-3 max-w-lg mx-auto mb-16">
            <input type="email" name="email" placeholder="Tu correo electrónico" required class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-700">
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition whitespace-nowrap">
                Crear Cuenta
            </button>
        </form>

        <div class="relative mx-auto rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <img src="{{ asset('images/dashboard-mockup.png') }}" alt="Dashboard de administración financiera en la plataforma Administrarme" class="w-full h-auto">
        </div>
    </section>

    <section class="border-y border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800/50 py-8">
        <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-center gap-8 md:gap-16 text-gray-500 dark:text-gray-400 font-semibold text-center">
            <div>✅ +10,000 tareas completadas</div>
            <div>⏱️ Horas ahorradas en administración</div>
            <div>📊 Reportes listos al instante</div>
        </div>
    </section>

    <section id="soluciones" class="py-20 px-4 max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Todo lo que necesitas para tu comunidad</h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-4xl mb-4">💰</div>
                <h3 class="text-xl font-bold mb-3">Control de Tesorería</h3>
                <p class="text-gray-600 dark:text-gray-400">Administra ingresos, cuotas y gastos con transparencia total y sin hojas de cálculo complejas.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-xl font-bold mb-3">Gestión de Tareas</h3>
                <p class="text-gray-600 dark:text-gray-400">Asigna responsabilidades, monitorea el progreso de los proyectos y mantén a todos coordinados.</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-4xl mb-4">📄</div>
                <h3 class="text-xl font-bold mb-3">Reportes Automatizados</h3>
                <p class="text-gray-600 dark:text-gray-400">Exporta estados financieros y resúmenes en PDF con un solo clic para tus juntas y asambleas.</p>
            </div>
        </div>
    </section>

    <section class="bg-indigo-50 dark:bg-indigo-900/10 py-20 px-4">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold mb-6">Lleva la administración a tu escritorio</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">Nuestra plataforma funciona como una App instalable. Carga al instante, funciona de manera independiente sin pestañas que distraigan y te da acceso directo desde el inicio de tu dispositivo.</p>
                <ul class="space-y-3 font-medium">
                    <li>📱 Instalable en Windows, macOS, Android y iOS</li>
                    <li>⚡ Velocidad de carga instantánea</li>
                    <li>🔔 Notificaciones nativas integradas</li>
                </ul>
            </div>
            <div class="md:w-1/2">
                <div class="aspect-video bg-gray-200 dark:bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">
                    [Imagen de la App en Escritorio / Celular]
                </div>
            </div>
        </div>
    </section>

    <section id="precios" class="py-20 px-4 max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-4">Un modelo transparente para todos</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto">Creemos en empoderar a las organizaciones. Por eso, nuestro sistema base es gratuito y se sostiene gracias a las aportaciones de la comunidad.</p>
        
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto text-left">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold mb-2">Acceso Base</h3>
                <div class="text-4xl font-extrabold mb-6">$0</div>
                <ul class="space-y-3 mb-8 text-gray-600 dark:text-gray-400">
                    <li>✔️ Gestión de miembros</li>
                    <li>✔️ Calendario de eventos</li>
                    <li>✔️ Tesorería básica</li>
                </ul>
                <a href="{{ route('register') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-bold py-3 rounded-lg transition">Comenzar Gratis</a>
            </div>
            
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-8 rounded-2xl shadow-xl text-white transform md:-translate-y-4">
                <div class="inline-block bg-white/20 px-3 py-1 rounded-full text-sm font-bold mb-4 border border-white/30">☕ Apoya el Proyecto</div>
                <h3 class="text-2xl font-bold mb-2">Aportación Voluntaria</h3>
                <div class="text-lg mb-6 opacity-90">Tú decides el valor</div>
                <ul class="space-y-3 mb-8 opacity-90">
                    <li>✨ Sin anuncios intrusivos</li>
                    <li>✨ Desbloquea reportes avanzados PDF</li>
                    <li>✨ Mantiene los servidores encendidos</li>
                </ul>
                <button class="w-full bg-white text-indigo-600 hover:bg-gray-50 font-bold py-3 rounded-lg transition shadow-md">
                    Invítanos un Café
                </button>
            </div>
        </div>
    </section>

    <section class="py-20 px-4 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Preguntas Frecuentes</h2>
            
            <div class="space-y-4" x-data="{ selected: null }">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button @click="selected !== 1 ? selected = 1 : selected = null" class="w-full text-left px-6 py-4 font-bold flex justify-between items-center">
                        ¿Cómo protege administrarme.com mis datos financieros?
                        <span x-text="selected === 1 ? '-' : '+'" class="text-xl text-gray-500"></span>
                    </button>
                    <div x-show="selected === 1" class="px-6 pb-4 text-gray-600 dark:text-gray-400">
                        Tus datos están protegidos con encriptación de extremo a extremo y respaldos automáticos. Solo los usuarios con permisos administrativos en tu congregación pueden acceder a esta información.
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <button @click="selected !== 2 ? selected = 2 : selected = null" class="w-full text-left px-6 py-4 font-bold flex justify-between items-center">
                        ¿Puedo usar la plataforma de forma gratuita?
                        <span x-text="selected === 2 ? '-' : '+'" class="text-xl text-gray-500"></span>
                    </button>
                    <div x-show="selected === 2" class="px-6 pb-4 text-gray-600 dark:text-gray-400">
                        Sí, las herramientas esenciales para organizar tu comunidad son completamente gratuitas. Si deseas apoyar el mantenimiento de la plataforma, contamos con un modelo de aportación voluntaria.
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>