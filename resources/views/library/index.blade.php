<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                📚 Biblioteca Digital Global
            </h2>
            
            @if(Auth::user()->is_super_admin)
                <a href="{{ route('biblioteca.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-sm transition">
                    + Agregar Recurso
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">          
           

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <form action="{{ route('biblioteca.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Título o descripción..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500">
                    </div>

                    <div class="w-full md:w-64">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Categoría</label>
                        <select name="category" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500">
                            <option value="">Todas las Categorías</option>
                            <option value="Biblias de Consulta" {{ request('category') == 'Biblias de Consulta' ? 'selected' : '' }}>📖 Biblias de Consulta</option>
                            <option value="Libros de Consulta" {{ request('category') == 'Libros de Consulta' ? 'selected' : '' }}>📚 Libros de Consulta</option>
                            <option value="Cuadernillos" {{ request('category') == 'Cuadernillos' ? 'selected' : '' }}>📝 Cuadernillos</option>
                            <option value="Videos, Himnos y Alabanzas" {{ request('category') == 'Videos, Himnos y Alabanzas' ? 'selected' : '' }}>🎵 Videos y Alabanzas</option>
                            <option value="Otros" {{ request('category') == 'Otros' ? 'selected' : '' }}>📦 Otros</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-auto">
                        @if(request('search') || request('category'))
                            <a href="{{ route('biblioteca.index') }}" class="w-full md:w-auto text-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 transition font-bold">Limpiar</a>
                        @endif
                        <button type="submit" class="w-full md:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm transition">Buscar</button>
                    </div>
                </form>
            </div>

            @if($items->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl p-10 text-center border border-gray-200 dark:border-gray-700">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No hay resultados</h3>
                    <p class="text-gray-500 dark:text-gray-400">Intenta buscar con otras palabras o selecciona otra categoría.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($items as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all flex flex-col">
                            
                            <div class="h-40 w-full flex items-center justify-center {{ $item->type == 'pdf' ? 'bg-red-50 dark:bg-red-900/20 text-red-500' : ($item->type == 'video' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-500' : 'bg-green-50 dark:bg-green-900/20 text-green-500') }}">
                                @if($item->type == 'pdf')
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                @elseif($item->type == 'video')
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                                @else
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path></svg>
                                @endif
                            </div>

                            <div class="p-5 flex-1 flex flex-col">
                                
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $item->type == 'pdf' ? 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/40 dark:text-red-400' : ($item->type == 'video' ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-400' : 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900/40 dark:text-green-400') }}">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-lg text-gray-900 dark:text-white line-clamp-2 mb-1 leading-tight">{{ $item->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 flex-1">{{ $item->description ?? 'Sin descripción adicional.' }}</p>
                                
                                <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    
                                    <div>
                                        @if(Auth::user()->is_super_admin)
                                        <form action="{{ route('biblioteca.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este recurso global?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-full transition" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>

                                    <a href="{{ route('biblioteca.show', $item) }}" class="text-sm font-bold text-white flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        Abrir
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
             @if(!Auth::user()->is_super_admin)
                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl p-4 flex items-start gap-4 shadow-sm">
                    <div class="text-2xl">💡</div>
                    <div>
                        <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-300">¿Tienes alguna sugerencia para la Biblioteca?</h4>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-1">Para mantener la calidad, el contenido es administrado globalmente. Contacta a soporte para sugerir nuevos libros, biblias o videos.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>