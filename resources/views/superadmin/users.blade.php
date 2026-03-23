<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('superadmin.index') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ⛪ Usuarios de: <span class="text-indigo-600 dark:text-indigo-400">{{ $church->name }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400 rounded-xl p-4 shadow-sm font-bold flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Lista de Miembros ({{ $users->count() }})</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Todos los usuarios registrados bajo esta iglesia.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="py-3 px-4">Nombre Completo</th>
                                <th class="py-3 px-4">Correo Electrónico</th>
                                <th class="py-3 px-4">Privilegios (Roles)</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition">
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                    @if($user->is_church_owner)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200" title="Es el creador de la cuenta">
                                            Dueño
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-1 flex-wrap">
                                        @if($user->role == 'pastor')
                                            <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 px-2 py-0.5 rounded text-xs font-bold border border-blue-200 dark:border-blue-800">Pastor</span>
                                        @elseif($user->role == 'admin')
                                            <span class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 px-2 py-0.5 rounded text-xs font-bold border border-indigo-200 dark:border-indigo-800">Admin</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 px-2 py-0.5 rounded text-xs font-bold border border-gray-200 dark:border-gray-600">Miembro</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 flex justify-center gap-2">
                                    <a href="{{ route('superadmin.users.edit', $user) }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-300 rounded text-xs font-bold transition">
                                        Editar
                                    </a>
                                    
                                    <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar a este miembro de la iglesia?');">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/50 dark:text-red-300 rounded text-xs font-bold transition">Borrar</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 font-bold">
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