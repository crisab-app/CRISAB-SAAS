<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ministerios, Grupos y Sociedades') }}
            </h2>
            <a href="{{ route('grupos.create') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition transform active:scale-95">
                + Nuevo Grupo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($groups as $group)
                    <a href="{{ route('grupos.show', $group) }}" class="block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-xl hover:shadow-lg hover:border-indigo-500/50 transition group relative">
                        
                        @if($group->has_sales)
                            <div class="absolute top-4 right-4 bg-green-500/10 text-green-600 dark:text-green-400 text-xs font-black px-3 py-1 rounded-full border border-green-500/20">
                                🏪 Tiendita
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2 group-hover:text-indigo-500 transition">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $group->description ?? 'Sin descripción' }}</p>
                            <div class="mt-6 text-sm text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-2">
                                Administrar Grupo <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
                
                @if($groups->isEmpty())
                    <div class="col-span-3 text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm border-2 border-dashed border-gray-300 dark:border-gray-700">
                        <span class="text-4xl block mb-3 opacity-50">👥</span>
                        <p class="text-gray-800 dark:text-gray-200 font-bold text-lg">No hay grupos registrados aún.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Organiza a los jóvenes, mujeres o proyectos haciendo clic en "+ Nuevo Grupo".</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>