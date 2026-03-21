<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('biblioteca.index') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight line-clamp-1">
                    📖 {{ $biblioteca->title }}
                </h2>
            </div>
            
            <a href="{{ $biblioteca->url }}" target="_blank" rel="noopener noreferrer" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 bg-white dark:bg-gray-800 py-2 px-4 rounded-full shadow-sm flex items-center gap-2 border border-indigo-100 dark:border-indigo-900/50 transition whitespace-nowrap">
                <span>Abrir original</span> <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>
    </x-slot>

    @php
        $url = $biblioteca->url;
        
        // 1. Detección SÚPER MEJORADA de YouTube
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            // Buscamos el ID exacto de 11 letras de YouTube
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches);
            if (isset($matches[1])) {
                $url = "https://www.youtube.com/embed/" . $matches[1];
            }
        }
        
        // 2. Detección SÚPER MEJORADA de Google Drive
        if (str_contains($url, 'drive.google.com')) {
            // Cambiamos /view por /preview para que permita incrustarse
            $url = str_replace('/view', '/preview', $url);
            $url = str_replace('/edit', '/preview', $url);
            // Le quitamos la basura del final (?usp=sharing) que bloquea el visor
            if (str_contains($url, '?')) {
                $url = explode('?', $url)[0];
            }
        }
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-100 dark:bg-gray-900 shadow-lg rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700">
                
                <iframe 
                    src="{{ $url }}" 
                    class="w-full border-0" 
                    style="height: 75vh; min-height: 500px;" 
                    allowfullscreen 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                </iframe>
                
            </div>

        </div>
    </div>
</x-app-layout>