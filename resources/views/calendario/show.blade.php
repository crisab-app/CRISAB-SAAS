<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div style="background-color: #1f2937; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg p-8">
                
                <div class="flex justify-between items-start mb-8 border-b border-gray-700 pb-6">
                    <div>
                        <h2 style="color: #f3f4f6;" class="text-3xl font-bold">📅 {{ $event->title }}</h2>
                        <p class="text-gray-400 mt-2">
                            <span class="font-bold">Inicio:</span> {{ \Carbon\Carbon::parse($event->start)->format('d/m/Y h:i A') }} | 
                            <span class="font-bold">Fin:</span> {{ \Carbon\Carbon::parse($event->end)->format('d/m/Y h:i A') }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('calendario') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition">← Volver</a>
                        <a href="{{ route('calendario.edit', $event->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">✏️ Editar</a>
                        <form action="{{ route('calendario.destroy', $event->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este evento?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">🗑️ Eliminar</button>
                        </form>
                    </div>
                </div>

                <h3 style="color: #e5e7eb;" class="text-xl font-bold mb-6 flex items-center gap-2">
                    📋 Orden de Servicio Actual
                </h3>

                @if($event->items->count() > 0)
                    <div class="space-y-4">
                        @foreach($event->items as $item)
                            <div style="background-color: #111827; border: 1px solid #374151;" class="p-5 rounded-xl flex flex-col md:flex-row justify-between items-center gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="bg-indigo-900 text-indigo-200 w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h4 class="text-white font-bold text-lg uppercase">{{ $item->name }}</h4>
                                        <p class="text-xs text-indigo-400">Requisito: {{ $item->skill->name ?? 'Cualquiera' }}</p>
                                    </div>
                                </div>

                                <form action="{{ route('calendario.assignItem', $item->id) }}" method="POST" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                                    @csrf
                                    <select name="user_id" style="background-color: #ffffff; color: #000000;" class="rounded-lg text-sm p-2 w-full md:w-64 border-none">
                                        <option value="">-- Selecciona quién ejecuta --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <input type="text" name="details" list="hymn-options" placeholder="Detalles o busca un himno..." 
                                           style="background-color: #ffffff; color: #000000;" 
                                           class="rounded-lg text-sm p-2 w-full md:w-64 border-gray-300"
                                           value="{{ $item->details }}" autocomplete="off">

                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                        + Asignar
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-900 border border-dashed border-gray-600 p-10 rounded-xl text-center">
                        <p class="text-gray-500 italic">Este evento no tiene una liturgia asignada.</p>
                        <p class="text-gray-600 text-sm">(Recuerda seleccionar una plantilla al crear el evento).</p>
                    </div>
                @endif

                <div style="background-color: #111827; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg p-8 mt-10">
                    <h3 style="color: #e5e7eb;" class="text-xl font-bold mb-6 flex items-center gap-2">
                        🎤 Bosquejo de Predicación
                    </h3>

                    <form action="{{ route('calendario.sermon.update', $event->id) }}" method="POST">
                        @csrf 
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Tema / Título de la Enseñanza</label>
                            <input type="text" name="preaching_topic" value="{{ $event->preaching_topic }}" 
                                style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                                class="w-full rounded-lg p-2.5" placeholder="Ej: La fe que mueve montañas">
                        </div>

                        <div class="mb-4">
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Desarrollo del Bosquejo</label>
                            <textarea id="sermon_editor" name="sermon_notes">{{ $event->sermon_notes }}</textarea>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="px-6 py-2.5 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition-all">
                                💾 Guardar Bosquejo
                            </button>
                        </div>
                    </form>
                </div>
                
            </div> </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#sermon_editor',
            height: 400,
            skin: 'oxide-dark', 
            content_css: 'dark', 
            plugins: 'lists link image table code wordcount',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link | code',
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); 
                });
            }
        });
    </script>
    <datalist id="hymn-options">
                    @foreach($hymns as $hymn)
                        <option value="Himno #{{ $hymn->number }} - {{ $hymn->title }}"></option>
                    @endforeach
                </datalist>
</x-app-layout>