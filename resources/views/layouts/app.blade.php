<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @if(config('app.env') === 'production' && env('GOOGLE_ANALYTICS_ID'))
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ env('G-EP2DGM4LVR') }}');
            </script>
        @endif
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                    }
        </script>    
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-gray-800 dark:text-gray-200">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main class="text-gray-900 dark:text-gray-100">
                @if(auth()->check() && auth()->user()->contract && auth()->user()->contract->status === 'trial')
                <div class="bg-yellow-500 text-black px-4 py-2.5 text-center font-bold shadow-md">
                    ⏳ Tu iglesia está usando una versión de prueba. Disfruta la plataforma y <a href="#" class="underline hover:text-white transition">adquiere tu plan aquí</a>.
                </div>
            @endif

            <main>
                {{ $slot }}
            </main>
            </main>
        </div>
    </body>
</html>
