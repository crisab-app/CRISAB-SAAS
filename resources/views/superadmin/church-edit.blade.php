<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            👑 Editar Iglesia: <span class="text-indigo-600">{{ $church->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('superadmin.church.update', $church->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Iglesia</label>
                        <input type="text" name="name" value="{{ $church->name }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estatus de la Cuenta</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                            <option value="trial" {{ $church->status == 'trial' ? 'selected' : '' }}>🟡 En Prueba (Trial)</option>
                            <option value="active" {{ $church->status == 'active' ? 'selected' : '' }}>🟢 Activa</option>
                            <option value="suspended" {{ $church->status == 'suspended' ? 'selected' : '' }}>🔴 Suspendida</option>
                        </select>
                    </div>

                    <div class="mb-8 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-lg">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active_donor" value="1" {{ $church->is_active_donor ? 'checked' : '' }} 
                                class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-500 dark:bg-gray-900 dark:border-gray-600 w-5 h-5">
                            <span class="ml-3 text-sm text-amber-900 dark:text-amber-300 font-bold">Cuenta ACTIVADA (Donador Activo)</span>
                        </label>
                        <p class="text-xs text-amber-700 dark:text-amber-400 ml-8 mt-1">
                            Si este switch está encendido, el usuario puede saltarse el mensaje de cobro y usar todo el sistema.
                        </p>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ url('/master-panel') }}" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-bold">← Cancelar</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-bold hover:bg-indigo-700">Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>