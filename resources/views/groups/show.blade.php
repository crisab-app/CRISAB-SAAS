<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4">
            
            <div class="flex items-center gap-3">
                <a href="{{ route('grupos.index') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                    &larr; Volver
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2 m-0">
                    {{ $group->name }} 
                    @if($group->has_sales) 
                        <span class="bg-green-600 text-white text-[10px] px-2 py-1 rounded-full uppercase tracking-widest font-bold ml-2 shadow-sm">🏪 Tiendita Activa</span> 
                    @endif
                </h2>
            </div>
            
            <form action="{{ route('grupos.destroy', $group) }}" method="POST" class="m-0" onsubmit="return confirm('¿Estás COMPLETAMENTE seguro de eliminar este grupo? Se borrará toda su directiva y ventas.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-500/50 rounded-md font-semibold text-xs text-red-600 dark:text-red-500 uppercase tracking-widest hover:bg-red-600 hover:text-white transition shadow-sm">
                    Eliminar Grupo
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if($group->has_sales)
            <div class="bg-white dark:bg-gray-800 border border-blue-500/30 rounded-xl p-6 shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
                    <div class="text-center md:text-left">
                        <h3 class="text-xl font-black text-blue-600 dark:text-blue-400 flex items-center justify-center md:justify-start gap-2">
                            <span>🏪</span> Panel de Ventas del Grupo
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Administra el inventario, registra compras y ventas de los proyectos de este grupo.</p>
                    </div>
                    <div>
                        <a href="{{ route('grupos.store.index', $group) }}" class="inline-block bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-md font-bold shadow-lg transition transform active:scale-95">
                                Abrir Punto de Venta
                            </a>                  </div>
                    </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-xl">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Asignar Cargo</h3>
                        <form action="{{ route('grupos.assign', $group) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Miembro</label>
                                <select name="user_id" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cargo</label>
                                <select name="role" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
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
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
                                Asignar a la Directiva
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-xl">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Directiva Actual</h3>
                        
                        @if($group->members->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 py-4 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">Aún no hay miembros asignados a la directiva de este grupo.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                                    <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 uppercase text-xs font-black tracking-wider border-b border-gray-200 dark:border-gray-700">
                                        <tr>
                                            <th class="px-6 py-4">Cargo</th>
                                            <th class="px-6 py-4">Nombre</th>
                                            <th class="px-6 py-4 text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                                        @foreach($group->members as $member)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-indigo-600 dark:text-indigo-400">
                                                {{ $member->pivot->role }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                                {{ $member->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('grupos.remove', [$group, $member]) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas quitar a este miembro de la directiva?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-3 py-1 rounded font-bold hover:bg-red-200 dark:hover:bg-red-900/50 transition">Quitar</button>
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
    </div>
</x-app-layout>