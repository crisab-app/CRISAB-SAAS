<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Crear Privilegio</h2></x-slot>
    <div class="py-12 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('privilegios.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf
            <label class="block font-bold mb-2">Nombre del Privilegio (Ej: Lector de Biblia)</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-md mb-4" required>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Guardar</button>
        </form>
    </div>
</x-app-layout>