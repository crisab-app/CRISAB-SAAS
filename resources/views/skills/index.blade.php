<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Catálogo de Privilegios y Dones</h2>
            <a href="{{ route('privilegios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">+ Nuevo Privilegio</a>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        @forelse ($skills as $skill)
            <a href="{{ route('privilegios.show', $skill) }}" class="block bg-white p-6 rounded-lg shadow hover:shadow-md transition border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-gray-800">{{ $skill->name }}</h3>
                <p class="text-sm text-gray-500 mt-2">Ver hermanos con este don &rarr;</p>
            </a>
        @empty
            <div class="col-span-1 md:col-span-4 text-center bg-white p-10 rounded-lg shadow-sm border-2 border-dashed border-gray-300">
                <p class="text-gray-500 mb-4 font-medium">Aún no hay privilegios registrados en el catálogo.</p>
                <p class="text-sm text-gray-400">Haz clic en el botón azul de arriba para crear el primero (Ej. Pastor, Predicador, Diacono, Alabanza, etc..).</p>
            </div>
        @endforelse
    </div>
    </div>
</x-app-layout>