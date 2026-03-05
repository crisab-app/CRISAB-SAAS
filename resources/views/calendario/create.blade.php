<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-200">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('calendario.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del Evento (Ej. Culto Dominical)</label>
                            <input type="text" name="title" id="title" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Inicio</label>
                                <input type="datetime-local" name="start" id="start" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Fin</label>
                                <input type="datetime-local" name="end" id="end" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="template_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                📖 Plantilla de Liturgia / Orden de Servicio (Opcional)
                            </label>
                            <select name="template_id" id="template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                                <option value="">-- Evento normal (Sin plantilla) --</option>
                                
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                                
                            </select>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Si seleccionas una plantilla, todos sus bloques se copiarán automáticamente a este evento para que puedas asignar a los participantes.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción breve (Opcional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('calendario') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition shadow-sm font-bold">
                                Guardar Evento
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>