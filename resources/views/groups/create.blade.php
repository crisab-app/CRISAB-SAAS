<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Grupo o Ministerio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('grupos.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nombre del Grupo *</label>
                        <input type="text" name="name" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Sociedad Femenil Dorcas o Jóvenes" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Descripción (Opcional)</label>
                        <textarea name="description" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" placeholder="¿Cuál es el propósito de este grupo?"></textarea>
                    </div>

                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-5 shadow-inner">
                        <label class="block text-sm font-black text-indigo-400 mb-3 flex items-center gap-2">
                            <span class="text-lg">🏪</span> Módulo de Tiendita / Ventas
                        </label>
                        <p class="text-xs text-gray-400 mb-5">
                            ¿Este grupo administrará su propio inventario y ventas (ej. venta de sodas, kermés, recaudación de fondos)?
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="has_sales" value="1" class="w-5 h-5 text-indigo-500 bg-gray-800 border-gray-600 focus:ring-indigo-500 focus:ring-offset-gray-900">
                                <span class="ml-3 text-sm text-gray-300 font-bold group-hover:text-white transition">Sí, habilitar ventas</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="has_sales" value="0" class="w-5 h-5 text-indigo-500 bg-gray-800 border-gray-600 focus:ring-indigo-500 focus:ring-offset-gray-900" checked>
                                <span class="ml-3 text-sm text-gray-300 font-bold group-hover:text-white transition">No, es un grupo normal</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('grupos.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition transform active:scale-95">
                            💾 Guardar Grupo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>