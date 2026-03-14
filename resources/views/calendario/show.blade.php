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
                        
                        <a href="{{ route('calendario.pdf', $event->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition flex items-center gap-1">
                            📄 Exportar PDF
                        </a>
                        
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
                                    <div class="w-48">
                                        <h4 class="text-white font-bold text-lg uppercase">{{ $item->name }}</h4>
                                        <p class="text-xs text-indigo-400">Requisito: {{ $item->skill->name ?? 'Cualquiera' }}</p>
                                    </div>
                                </div>

                                <form action="{{ route('calendario.assignItem', $item->id) }}" method="POST" class="flex flex-col md:flex-row gap-3 w-full md:flex-1 justify-end">
                                    @csrf
                                    <select name="user_id" style="background-color: #ffffff; color: #000000;" class="rounded-lg text-sm p-2 w-full md:w-48 border-none">
                                        <option value="">-- Selecciona quién ejecuta --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @if(str_contains(strtoupper($item->name), 'HIMNO') || str_contains(strtoupper($item->name), 'ALABANZA'))
                                        <input type="text" name="details" list="hymn-options" placeholder="Busca un himno..." 
                                            style="background-color: #ffffff; color: #000000;" 
                                            class="rounded-lg text-sm p-2 w-full md:w-64 border-gray-300"
                                            value="{{ $item->details }}" autocomplete="off">
                                    @else
                                        <input type="text" name="details" placeholder="Detalles de la participación..." 
                                            style="background-color: #ffffff; color: #000000;" 
                                            class="rounded-lg text-sm p-2 w-full md:w-64 border-gray-300"
                                            value="{{ $item->details }}">
                                    @endif

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

                <form action="{{ route('calendario.sermon.update', $event->id) }}" method="POST">
                    @csrf 
                    @method('PATCH')
                    
                    <div style="background-color: #111827; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg p-8 mt-10 mb-6">
                        <h3 style="color: #e5e7eb;" class="text-xl font-bold mb-6 flex items-center gap-2">
                            📖 Lectura Bíblica Principal
                        </h3>

                        <div style="background-color: #1f2937; border: 1px solid #374151;" class="p-4 rounded-xl mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Libro</label>
                                    <select id="reading_book" style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2">
                                        <option value="" disabled selected>Libro...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Cap.</label>
                                    <select id="reading_chapter" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Del Versículo...</label>
                                    <select id="reading_verse_start" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">...</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Hasta el Versículo...</label>
                                    <select id="reading_verse_end" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">(Opcional)</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="button" id="btn_insert_reading" disabled class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-lg shadow transition disabled:opacity-50 text-sm">
                                        ➕ Insertar Lectura
                                    </button>
                                </div>
                            </div>
                        </div>

                        <textarea id="reading_editor" name="bible_reading">{{ $event->bible_reading ?? '' }}</textarea>
                    </div>

                    <div style="background-color: #111827; border: 1px solid #374151;" class="shadow-xl sm:rounded-lg p-8">
                        <h3 style="color: #e5e7eb;" class="text-xl font-bold mb-6 flex items-center gap-2">
                            🎤 Bosquejo de Predicación
                        </h3>
                        
                        <div class="mb-6">
                            <label style="color: #9ca3af;" class="block text-sm font-medium mb-2">Tema / Título de la Enseñanza</label>
                            <input type="text" name="preaching_topic" value="{{ $event->preaching_topic }}" 
                                style="background-color: #ffffff; color: #000000; border: 1px solid #d1d5db;"
                                class="w-full rounded-lg p-2.5" placeholder="Ej: La fe que mueve montañas">
                        </div>

                        <div style="background-color: #1f2937; border: 1px solid #374151;" class="p-4 rounded-xl mb-4">
                            <h4 style="color: #9ca3af;" class="text-xs font-bold mb-2 uppercase">Insertar citas en el bosquejo</h4>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                                <div>
                                    <select id="sermon_book" style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2">
                                        <option value="" disabled selected>Libro...</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="sermon_chapter" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">Cap...</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="sermon_verse_start" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">Del Vers...</option>
                                    </select>
                                </div>
                                <div>
                                    <select id="sermon_verse_end" disabled style="background-color: #374151; color: #ffffff;" class="w-full rounded-lg border-none text-sm p-2 disabled:opacity-50">
                                        <option value="">Al Vers (Opcional)</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="button" id="btn_insert_sermon" disabled class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded-lg shadow transition disabled:opacity-50 text-sm">
                                        ➕ Añadir Cita
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <textarea id="sermon_editor" name="sermon_notes">{{ $event->sermon_notes }}</textarea>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" style="background-color: #4f46e5; color: #ffffff;" class="px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition-all text-lg">
                                💾 Guardar Todo
                            </button>
                        </div>
                    </div>
                </form>
                
            </div> 
        </div>
    </div>

    <datalist id="hymn-options">
        @foreach($hymns as $hymn)
            <option value="Himno #{{ $hymn->number }} - {{ $hymn->title }}"></option>
        @endforeach
    </datalist>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
        // Inicializar ambos editores de TinyMCE
        tinymce.init({
            selector: '#reading_editor, #sermon_editor',
            height: 300,
            skin: 'oxide-dark', 
            content_css: 'dark', 
            plugins: 'lists link code',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter | bullist numlist',
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () { editor.save(); });
            }
        });

        const books = [
            'Génesis', 'Éxodo', 'Levítico', 'Números', 'Deuteronomio', 'Josué', 'Jueces', 'Rut', '1 Samuel', '2 Samuel', '1 Reyes', '2 Reyes', '1 Crónicas', '2 Crónicas', 'Esdras', 'Nehemías', 'Ester', 'Job', 'Salmos', 'Proverbios', 'Eclesiastés', 'Cantares', 'Isaías', 'Jeremías', 'Lamentaciones', 'Ezequiel', 'Daniel', 'Oseas', 'Joel', 'Amós', 'Abdías', 'Jonás', 'Miqueas', 'Nahúm', 'Habacuc', 'Sofonías', 'Hageo', 'Zacarías', 'Malaquías', 'Mateo', 'Marcos', 'Lucas', 'Juan', 'Hechos', 'Romanos', '1 Corintios', '2 Corintios', 'Gálatas', 'Efesios', 'Filipenses', 'Colosenses', '1 Tesalonicenses', '2 Tesalonicenses', '1 Timoteo', '2 Timoteo', 'Tito', 'Filemón', 'Hebreos', 'Santiago', '1 Pedro', '2 Pedro', '1 Juan', '2 Juan', '3 Juan', 'Judas', 'Apocalipsis'
        ];

        // Función reutilizable para ambos buscadores bíblicos
        function initBibleSearch(prefix, targetEditorId) {
            const bookSelect = document.getElementById(prefix + 'book');
            const chapterSelect = document.getElementById(prefix + 'chapter');
            const verseStart = document.getElementById(prefix + 'verse_start');
            const verseEnd = document.getElementById(prefix + 'verse_end');
            const btnInsert = document.getElementById('btn_insert_' + prefix.replace('_', ''));

            books.forEach(book => {
                let option = document.createElement('option'); option.value = book; option.text = book;
                bookSelect.appendChild(option);
            });

            bookSelect.addEventListener('change', function() {
                chapterSelect.innerHTML = '<option value="">Cargando...</option>';
                chapterSelect.disabled = true; verseStart.disabled = true; verseEnd.disabled = true; btnInsert.disabled = true;

                fetch(`/api/bible/chapters?book=${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        chapterSelect.innerHTML = '<option value="" disabled selected>Cap...</option>';
                        data.forEach(c => {
                            let opt = document.createElement('option'); opt.value = c; opt.text = c;
                            chapterSelect.appendChild(opt);
                        });
                        chapterSelect.disabled = false;
                    });
            });

            chapterSelect.addEventListener('change', function() {
                verseStart.innerHTML = '<option value="">Cargando...</option>';
                verseStart.disabled = true; verseEnd.disabled = true; btnInsert.disabled = true;

                fetch(`/api/bible/verses?book=${bookSelect.value}&chapter=${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        verseStart.innerHTML = '<option value="" disabled selected>Vers...</option>';
                        verseEnd.innerHTML = '<option value="">(Opcional)</option>';
                        data.forEach(v => {
                            let opt1 = document.createElement('option'); opt1.value = v; opt1.text = v;
                            let opt2 = document.createElement('option'); opt2.value = v; opt2.text = v;
                            verseStart.appendChild(opt1);
                            verseEnd.appendChild(opt2);
                        });
                        verseStart.disabled = false;
                    });
            });

            verseStart.addEventListener('change', function() {
                verseEnd.disabled = false;
                btnInsert.disabled = false;
                verseEnd.value = this.value; // Pre-seleccionar el final igual que el inicio
            });

            btnInsert.addEventListener('click', function() {
                let book = bookSelect.value;
                let chapter = chapterSelect.value;
                let vStart = verseStart.value;
                let vEnd = verseEnd.value;
                
                let url = `/api/bible/text?book=${book}&chapter=${chapter}&verse=${vStart}`;
                if(vEnd && parseInt(vEnd) > parseInt(vStart)) {
                    url += `&verse_end=${vEnd}`;
                }

                btnInsert.innerHTML = '⏳...'; btnInsert.disabled = true;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if(data.text) {
                            let htmlToInsert = `
                            <div style="border-left: 3px solid #6366f1; padding-left: 15px; margin-bottom: 20px;">
                                <h3 style="color: #818cf8; margin-bottom: 5px;">${data.reference}</h3>
                                <p style="font-size: 1.1em; line-height: 1.6; color: #d1d5db;">${data.text}</p>
                            </div><p>&nbsp;</p>`;
                            
                            tinymce.get(targetEditorId).execCommand('mceInsertContent', false, htmlToInsert);
                        }
                        btnInsert.innerHTML = '➕ Insertar'; btnInsert.disabled = false;
                    });
            });
        }

        // Activamos los dos buscadores bíblicos
        initBibleSearch('reading_', 'reading_editor');
        initBibleSearch('sermon_', 'sermon_editor');
    </script>
</x-app-layout>