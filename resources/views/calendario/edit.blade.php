<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✏️ Editar Evento: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('calendario.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del Evento</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Inicio</label>
                                <input type="datetime-local" name="start" id="start" value="{{ old('start', date('Y-m-d\TH:i', strtotime($event->start))) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                            </div>
                            <div>
                                <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Fin</label>
                                <input type="datetime-local" name="end" id="end" value="{{ old('end', date('Y-m-d\TH:i', strtotime($event->end))) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción (Opcional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('calendario.show', $event->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition duration-150">Cancelar</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150">Actualizar Evento</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>