<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            👑 Editar Usuario: <span class="text-indigo-600">{{ $user->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Información del Usuario</h3>
                <form method="POST" action="{{ route('master.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md font-bold hover:bg-indigo-700">Guardar Datos</button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 border-t-4 border-red-500">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">🔐 Forzar Cambio de Contraseña</h3>
                <p class="text-sm text-gray-500 mb-4">Usa esto si el usuario perdió el acceso a su cuenta.</p>
                
                <form method="POST" action="{{ route('master.users.password', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Contraseña (mínimo 8 caracteres)</label>
                        <input type="text" name="password" required placeholder="Escribe la nueva clave..." class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md font-bold hover:bg-red-700">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-6">
                <a href="{{ url('/master-panel/church/' . $user->contract_id . '/users') }}" class="text-indigo-600 hover:text-indigo-800 font-bold">← Regresar a la lista de usuarios</a>
            </div>

        </div>
    </div>
</x-app-layout>