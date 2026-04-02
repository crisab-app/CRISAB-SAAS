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
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
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
        @auth
            @if(!auth()->user()->is_active_donor && !request()->routeIs('cafe.*'))
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3 text-white text-center text-sm shadow-md relative z-50">
                    <p class="flex items-center justify-center flex-wrap gap-2">
                        <span>⏳ Tu cuenta está usando la versión gratuita de AdministrarMe.</span>
                        <span class="hidden sm:inline">|</span>
                        <span>Apoya este ministerio invitándonos un café al mes.</span>
                        <a href="{{ route('cafe.index') }}" class="inline-block bg-white text-indigo-700 font-bold px-3 py-1 rounded-full text-xs hover:bg-gray-100 transition shadow-sm ml-2">
                            ☕ Invitar un café
                        </a>
                    </p>
                </div>
            @endif
        @endauth
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
                    ⏳ Tu iglesia está usando una versión de gratuita. Disfruta la plataforma y <a href="{{ route('cafe.index') }}" class="underline hover:text-white transition">invitanos un cafe al equipo</a>.
                </div>
            @endif

            <main>
                {{ $slot }}
            </main>
            </main>
        </div>
    </body>
</html>
