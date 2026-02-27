<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $group->name }} - Directiva
            </h2>
            
            <form action="{{ route('grupos.destroy', $group) }}" method="POST" onsubmit="return confirm('¿Estás COMPLETAMENTE seguro de eliminar este grupo? Se borrará toda su directiva.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm font-bold shadow-sm">
                    Eliminar Grupo
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Asignar Cargo</h3>
                    <form action="{{ route('grupos.assign', $group) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Miembro</label>
                            <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Cargo</label>
                            <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Presidente">Presidente</option>
                                <option value="Vicepresidente">Vicepresidente</option>
                                <option value="Secretario">Secretario</option>
                                <option value="SubSecretario">SubSecretario</option>
                                <option value="Tesorero">Tesorero</option>
                                <option value="Subtesorero">Subtesorero</option>
                                <option value="Vocal 1">Vocal 1</option>
                                <option value="Vocal 2">Vocal 2</option>
                                <option value="Consejero">Consejero</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Asignar
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-bold mb-4">Directiva Actual</h3>
                    
                    @if($group->members->isEmpty())
                        <p class="text-gray-500">Aún no hay miembros asignados a este grupo.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($group->members as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $member->pivot->role }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $member->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('grupos.remove', [$group, $member]) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas quitar a este miembro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Quitar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>