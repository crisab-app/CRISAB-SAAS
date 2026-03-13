<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div style="background-color: #1f2937; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg p-8">
                
                <h2 style="color: #f3f4f6;" class="text-2xl font-bold mb-6 flex items-center gap-2">
                    📅 Crear Nuevo Evento / Servicio
                </h2>

                @if ($errors->any())
                    <div style="background-color: #7f1d1d; color: #fef2f2;" class="p-4 mb-6 rounded-lg border-l-4 border-red-500">
                        <p class="font-bold">Hay errores en el formulario:</p>
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('calendario.store') }}" method="POST">
                    @csrf 
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="col-span-2">
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Título del Evento *</label>
                            <input type="text" name="title" required 
                                style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                                class="w-full rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500"
                                placeholder="Escribe el nombre aquí..." value="{{ old('title') }}">
                        </div>
                        
                        <div>
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Color</label>
                            <input type="color" name="color" value="#4f46e5" 
                                style="background-color: #ffffff; border: 1px solid #d1d5db;"
                                class="h-11 w-full rounded-lg cursor-pointer p-1">
                        </div>
                    </div>

                    <div style="background-color: #111827;" class="mb-6 p-4 rounded-lg border border-gray-700">
                        <label style="color: #e5e7eb;" class="block text-sm font-medium mb-2">🌍 Privacidad del Evento *</label>
                        <select name="visibility" required 
                            style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                            class="w-full rounded-lg p-2.5">
                            <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Público (Toda la iglesia)</option>
                            <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Personal (Solo tú)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Fecha y Hora de Inicio *</label>
                            <input type="datetime-local" name="start" required 
                                style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                                class="w-full rounded-lg p-2.5" value="{{ old('start') }}">
                        </div>
                        <div>
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Fecha y Hora de Fin *</label>
                            <input type="datetime-local" name="end" required 
                                style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                                class="w-full rounded-lg p-2.5" value="{{ old('end') }}">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">📖 Seleccionar Plantilla (Opcional)</label>
                        <select name="template_id" 
                            style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                            class="w-full rounded-lg p-2.5">
                            <option value="">-- Sin plantilla --</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-8">
                        <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Descripción (Opcional)</label>
                        
                        <textarea name="description" rows="3" 
                            style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                            class="w-full rounded-lg p-2.5" placeholder="Escribe detalles aquí...">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4">
                        <a href="{{ route('calendario') }}" style="color: #9ca3af;" class="hover:text-white transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                            style="background-color: #4f46e5; color: #ffffff;"
                            class="px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition-all">
                            Guardar Evento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>