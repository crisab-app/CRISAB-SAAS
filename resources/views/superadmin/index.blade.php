<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-700">
                
                <h2 class="text-2xl font-bold text-gray-100 mb-6">🏢 Panel de Control CRISAB (Módulo CEO)</h2>

                @if(session('success'))
                    <div class="bg-green-800 text-green-100 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-900 rounded-lg">
                        <thead>
                            <tr class="text-left text-gray-400 border-b border-gray-700">
                                <th class="p-4">ID</th>
                                <th class="p-4">Nombre de la Iglesia / Misión</th>
                                <th class="p-4">Jerarquía</th>
                                <th class="p-4">Total Miembros</th>
                                <th class="p-4">Semáforo / Estatus</th>
                                <th class="p-4">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            @foreach($churches as $church)
                            <tr class="border-b border-gray-800">
                                <td class="p-4">{{ $church->id }}</td>
                                <td class="p-4 font-bold">{{ $church->name }}</td>
                                <td class="p-4 text-sm">
                                    {{ $church->parent_id ? 'Dependencia (Hija)' : 'Sede Principal' }}
                                </td>
                                <td class="p-4">{{ $church->users_count ?? 0 }}</td>
                                <td class="p-4">
                                    <form action="{{ route('superadmin.status', $church->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="status" class="bg-gray-800 border-gray-600 text-white text-sm rounded focus:ring-indigo-500">
                                            <option value="active" {{ $church->status == 'active' ? 'selected' : '' }}>🟢 Activa</option>
                                            <option value="trial" {{ $church->status == 'trial' ? 'selected' : '' }}>🟡 En Prueba</option>
                                            <option value="suspended" {{ $church->status == 'suspended' ? 'selected' : '' }}>🔴 Suspendida</option>
                                        </select>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                                            Guardar
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4">
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300 text-sm">Ver Detalles</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>