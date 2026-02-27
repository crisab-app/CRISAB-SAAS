<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Grupos y Sociedades') }}
            </h2>
            <a href="{{ route('grupos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Nuevo Grupo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($groups as $group)
                    <a href="{{ route('grupos.show', $group) }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $group->name }}</h3>
                            <p class="text-gray-600">{{ $group->description ?? 'Sin descripción' }}</p>
                            <div class="mt-4 text-sm text-blue-600 font-semibold">
                                Ver Directiva &rarr;
                            </div>
                        </div>
                    </a>
                @endforeach
                
                @if($groups->isEmpty())
                    <div class="col-span-3 text-center py-10 text-gray-500">
                        No hay grupos registrados aún. ¡Crea el primero!
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>