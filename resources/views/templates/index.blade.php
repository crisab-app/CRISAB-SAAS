<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Catalogo de Actividades') }}
            </h2>
            <a href="{{ route('templates.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
                + Nueva Plantilla
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($templates as $template)
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-lg border-t-4 border-blue-500">
                        <h3 class="text-xl font-bold dark:text-white">{{ $template->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $template->description ?? 'Sin descripción' }}</p>
                        <div class="mt-4 flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-3">
                        <a href="{{ route('templates.show', $template) }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                         Configurar Pasos &rarr;
                         </a>
    
                        <form action="{{ route('templates.destroy', $template) }}" method="POST" onsubmit="return confirm('¿Borrar esta plantilla y todos sus bloques?');">
                             @csrf
                             @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                 Eliminar
                             </button>
                        </form>
                        </div>
                    </div>
                @endforeach

                @if($templates->isEmpty())
                    <div class="col-span-3 text-center py-10 bg-white dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <p class="text-gray-500 dark:text-gray-400">No hay plantillas creadas. Diseña la primera para ahorrar tiempo en el calendario.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>