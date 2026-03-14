<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            👥 Usuarios de: <span class="text-indigo-400">{{ $church->name ?? 'Iglesia sin nombre' }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('superadmin.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition">
                    ← Volver al Panel
                </a>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                    ➕ Añadir Usuario Manualmente
                </button>
            </div>

            <div class="bg-gray-800 border border-gray-700 shadow-xl rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-700">
                    <h3 class="text-xl font-bold text-gray-100">Directorio de Miembros</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-900">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Nombre y Correo</th>
                                <th scope="col" class="px-6 py-4 text-center">Rol actual</th>
                                <th scope="col" class="px-6 py-4 text-center">Registro</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-b border-gray-700 hover:bg-gray-750 transition-colors">
                                    <td class="px-6 py-4 font-medium text-white">{{ $user->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-base">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-indigo-900 text-indigo-300 py-1 px-3 rounded-full text-xs font-bold">
                                            Miembro
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $user->created_at->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button class="text-yellow-400 hover:text-white font-bold bg-gray-900 p-2 rounded-lg transition" title="Cambiar Contraseña">🔑</button>
                                            <button class="text-red-400 hover:text-red-300 font-bold bg-red-900/20 p-2 rounded-lg transition" title="Eliminar Usuario">🗑️</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-lg">
                                        Esta iglesia aún no tiene usuarios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>