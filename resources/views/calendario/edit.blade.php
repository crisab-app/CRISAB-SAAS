<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✏️ Editar Evento: <span class="text-indigo-500">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md dark:bg-red-900/30 dark:border-red-800 dark:text-red-400">
                            <ul class="list-disc ml-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('calendario.update', $event->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="md:col-span-3">
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título del Evento *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                            </div>
                            
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                                <input type="color" name="color" id="color" value="{{ old('color', $event->color ?? '#3b82f6') }}" 
                                    class="mt-1 block w-full h-9 rounded-md border-gray-300 shadow-sm cursor-pointer p-0.5 dark:bg-gray-900 dark:border-gray-700">
                            </div>
                        </div>

                        @if(isset($templates) && $templates->count() > 0)
                        <div class="mb-6 bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg border border-indigo-100 dark:border-indigo-800">
                            <label for="template_id" class="block text-sm font-bold text-indigo-800 dark:text-indigo-300">📋 Aplicar Plantilla de Actividad (Opcional)</label>
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mb-2">Si seleccionas una nueva plantilla, se agregarán sus puntos a este evento.</p>
                            <select name="template_id" id="template_id" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300 sm:text-sm">
                                <option value="">-- Mantener la configuración actual sin cambios --</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="mb-6 bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            <label for="visibility" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Privacidad del Evento *</label>
                            <select name="visibility" id="visibility" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 sm:text-sm">
                                <option value="public" {{ old('visibility', $event->visibility) == 'public' ? 'selected' : '' }}>Público (Visible para toda la iglesia)</option>
                                <option value="private" {{ old('visibility', $event->visibility) == 'private' ? 'selected' : '' }}>Personal (Solo visible para ti)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="start" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Inicio *</label>
                                <input type="datetime-local" name="start" id="start" 
                                    value="{{ old('start', \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i')) }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                            </div>
                            <div>
                                <label for="end" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora de Fin *</label>
                                <input type="datetime-local" name="end" id="end" 
                                    value="{{ old('end', \Carbon\Carbon::parse($event->end)->format('Y-m-d\TH:i')) }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción (Opcional)</label>
                            <textarea name="description" id="description" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300 sm:text-sm"
                                placeholder="Escribe detalles o notas adicionales aquí...">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('calendario') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-150">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 flex items-center gap-2">
                                💾 Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>