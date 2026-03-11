<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdministrarMe - Gestión y administracion de Iglesias, congregaciones y personal.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <main class="flex-grow flex items-center justify-center">
        <div class="max-w-3xl mx-auto text-center px-4">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-6">Bienvenido a <span class="text-blue-600">AdministrarMe</span></h1>
            <p class="text-xl text-gray-600 mb-10">El sistema integral para la gestión, organización y administración personal y de tu iglesia.</p>
            
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ url('/calendario') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-1">Ir a mi Panel</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:-translate-y-1">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </main>
    <footer class="text-center py-6 text-gray-500 text-sm">
        &copy; {{ date('Y') }} CRISAB. Todos los derechos reservados.
    </footer>
</body>
</html>