<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Diseño de Liturgia:') }} {{ $template->name }}
            </h2>
            <a href="{{ route('templates.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                &larr; Volver a plantillas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Agregar Bloque</h3>
                    
                    <form action="{{ route('templates.items.store', $template) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Bloque</label>
                            <input type="text" name="name" required placeholder="Ej: Bienvenida, Alabanza..." 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Privilegio Requerido</label>
                            <select name="skill_id" required 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Selecciona quién ejecuta --</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orden en el servicio</label>
                                <input type="number" name="order_index" value="{{ $template->items->count() + 1 }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div><div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Orden en el servicio</label>
                            <input type="number" name="order" value="{{ $template->items->count() + 1 }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-bold transition shadow-md">
                            + Añadir al Orden
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Orden del Servicio Actual</h3>
                    
                    <div class="space-y-3">
                        @forelse($template->items->sortBy('order') as $item)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 font-bold px-3 py-1 rounded-full mr-4 text-sm">
                                        {{ $item->order_index }}
                                    </span>
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-white">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Requisito: <span class="font-semibold">{{ $item->skill->name ?? 'Cualquiera' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form action="{{ route('templates.items.up', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-bold px-3 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 rounded transition shadow-sm">
                                            ↑
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('templates.items.down', $item->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-bold px-3 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 rounded transition shadow-sm">
                                            ↓
                                        </button>
                                    </form>

                                    <form action="{{ route('templates.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas borrar este bloque?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-white dark:text-red-400 dark:hover:text-white hover:bg-red-600 dark:hover:bg-red-600 font-bold px-3 py-1 bg-red-100 dark:bg-red-900/30 rounded transition shadow-sm">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg p-10 text-center">
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No hay bloques definidos aún.</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500">Comienza agregando "Bienvenida" o "Alabanza" a la izquierda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>