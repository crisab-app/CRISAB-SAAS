<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            🛡️ Centro de Mando SuperAdmin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Iglesias Registradas</p>
                        <h3 class="text-3xl font-extrabold text-white mt-1">{{ $totalChurches }}</h3>
                    </div>
                    <div class="bg-indigo-600/20 p-4 rounded-full">
                        <span class="text-indigo-400 text-2xl">⛪</span>
                    </div>
                </div>
                <div class="mt-12 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">👥 Todos los Usuarios ({{ $allUsers->count() }})</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lista global sin filtros. Aquí puedes ver usuarios huérfanos o atorados.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="py-3 px-4">Nombre</th>
                            <th class="py-3 px-4">Correo</th>
                            <th class="py-3 px-4">Iglesia Perteneciente</th>
                            <th class="py-3 px-4">Estado</th>
                            <th class="py-3 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($allUsers as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/20 transition">
                            <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">
                                {{ $user->name }}
                                @if($user->is_church_owner)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        Dueño
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->contract)
                                    {{ $user->contract->name }}
                                @else
                                    <span class="text-red-500 font-bold">🚫 Huérfano (Sin iglesia)</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->trashed())
                                    <span class="text-red-500 font-bold">🗑️ Eliminado</span>
                                @else
                                    <span class="text-green-500 font-bold">✅ Activo</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 flex justify-center gap-2">
                                <a href="{{ route('superadmin.users.edit', $user) }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-300 rounded text-xs font-bold transition">
                                    Editar
                                </a>
                                @if(!$user->trashed())
                                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/50 dark:text-red-300 rounded text-xs font-bold transition">Borrar</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Suscripciones Activas</p>
                        <h3 class="text-3xl font-extrabold text-green-400 mt-1">{{ $activeChurches }}</h3>
                    </div>
                    <div class="bg-green-500/20 p-4 rounded-full">
                        <span class="text-green-400 text-2xl">✅</span>
                    </div>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Usuarios Globales</p>
                        <h3 class="text-3xl font-extrabold text-blue-400 mt-1">{{ $totalUsers }}</h3>
                    </div>
                    <div class="bg-blue-500/20 p-4 rounded-full">
                        <span class="text-blue-400 text-2xl">👥</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 mb-6">
                <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                    ➕ Registrar Nueva Iglesia
                </a>
                <a href="#" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition border border-gray-600">
                    ⚙️ Configuraciones Globales
                </a>
            </div>

            <div class="bg-gray-800 border border-gray-700 shadow-xl rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-100">Directorio de Iglesias (Tenants)</h3>
                    <input type="text" placeholder="Buscar iglesia..." class="bg-gray-900 border-gray-600 text-white rounded-lg text-sm px-4 py-2 w-64 focus:ring-indigo-500">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-900">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">Nombre de la Iglesia</th>
                                <th scope="col" class="px-6 py-4 text-center">Usuarios</th>
                                <th scope="col" class="px-6 py-4">Plan / Características</th>
                                <th scope="col" class="px-6 py-4 text-center">Estatus</th>
                                <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($churches as $church)
                                <tr class="border-b border-gray-700 hover:bg-gray-750 transition-colors">
                                    <td class="px-6 py-4 font-medium text-white">{{ $church->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-base">{{ $church->name ?? 'Iglesia sin nombre' }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Suscripción iniciada: {{ $church->created_at->format('d M, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-blue-900 text-blue-300 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $church->users_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-indigo-400 font-bold border border-indigo-400/30 bg-indigo-900/20 px-2 py-1 rounded text-xs">
                                            {{ strtoupper($church->plan ?? 'BÁSICO') }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('superadmin.updateStatus', $church->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs font-bold rounded-full border-none px-3 py-1 cursor-pointer focus:ring-0
                                                @if($church->status == 'active') bg-green-900 text-green-300 
                                                @elseif($church->status == 'trial') bg-yellow-900 text-yellow-300 
                                                @else bg-red-900 text-red-300 @endif">
                                                <option value="active" {{ $church->status == 'active' ? 'selected' : '' }}>🟢 ACTIVA</option>
                                                <option value="trial" {{ $church->status == 'trial' ? 'selected' : '' }}>🟡 PRUEBA</option>
                                                <option value="suspended" {{ $church->status == 'suspended' ? 'selected' : '' }}>🔴 SUSPENDIDA</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            
                                            <a href="{{ route('superadmin.churchUsers', $church->id) }}" class="text-blue-400 hover:text-blue-300 font-bold bg-gray-900 p-2 rounded-lg transition" title="Gestionar Usuarios">
                                                👥 Usuarios
                                            </a>
                                            
                                            <a href="{{ route('superadmin.church.edit', $church->id) }}" class="text-yellow-400 hover:text-yellow-300 font-bold px-3 py-1">
                                                ⚙️ Editar
                                            </a>

                                            <form action="{{ route('superadmin.church.destroy', $church->id) }}" method="POST" class="inline-block relative z-50" x-data @submit.prevent="if(confirm('🚨 PELIGRO: ¿Estás COMPLETAMENTE seguro de borrar esta IGLESIA? Esto borrará también a todos sus usuarios y datos. NO SE PUEDE DESHACER.')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 font-bold px-3 py-1 cursor-pointer">
                                                    🗑️ Borrar
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-lg">
                                        No hay iglesias registradas en el sistema todavía.
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