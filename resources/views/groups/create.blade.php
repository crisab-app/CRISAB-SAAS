<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Grupo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('grupos.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nombre del Grupo</label>
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ej: Sociedad Femenil Dorcas" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Descripción (Opcional)</label>
                        <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('grupos.index') }}" class="text-gray-600 hover:text-gray-900 py-2">Cancelar</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Guardar Grupo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>