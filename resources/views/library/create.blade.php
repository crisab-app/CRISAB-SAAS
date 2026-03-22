<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('biblioteca.index') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Agregar Recurso a la Biblioteca') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 shadow-sm">
                            <ul class="list-disc pl-5 text-sm font-bold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('biblioteca.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Título del Recurso <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Ej. Biblia NVI en línea" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Enlace / URL del archivo <span class="text-red-500">*</span></label>
                            <input type="url" name="url" required placeholder="Ej. https://www.biblegateway.com/" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Pega aquí el link directo al PDF, página web o video de YouTube.</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tipo de Recurso <span class="text-red-500">*</span></label>
                            <select name="type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="pdf">📄 Documento PDF</option>
                                <option value="link">🔗 Enlace a Sitio Web</option>
                                <option value="video">▶️ Video</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Categoría <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Biblias de Consulta">📖 Biblias de Consulta</option>
                                <option value="Libros de Consulta">📚 Libros de Consulta</option>
                                <option value="Cuadernillos">📝 Cuadernillos de Discipulado</option>
                                <option value="Videos, Himnos y Alabanzas">🎵 Videos, Himnos y Alabanzas</option>
                                <option value="Otros">📦 Otros Recursos</option>
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Descripción (Opcional)</label>
                            <textarea name="description" rows="3" placeholder="Breve resumen de este material..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('biblioteca.index') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                                💾 Guardar en Biblioteca
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>