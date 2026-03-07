<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📅 {{ $event->title }}
            </h2>
            
            <div class="flex gap-4 items-center">
                <a href="{{ route('calendario') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                    &larr; Volver
                </a>
                <a href="{{ route('calendario.edit', $event->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-150">
                    ✏️ Editar
                </a>
                @if($event->status !== 'closed')
                    <form action="{{ route('calendario.close', $event->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres cerrar este evento? Ya no podrás hacer cambios en las asignaciones.');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-150">
                            🔒 Cerrar Evento
                        </button>
                    </form>
                @else
                    <span class="bg-gray-500 text-white font-bold py-1 px-3 rounded text-sm cursor-not-allowed">
                        🔒 Evento Cerrado
                    </span>
                @endif
                <button onclick="window.print()" class="no-print bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-150">
                    🖨️ Exportar PDF
                </button>
                <form action="{{ route('calendario.destroy', $event->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento y toda su liturgia? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-150">
                        🗑️ Eliminar Evento
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-2">Detalles del Evento</h3>
                    <p><strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->start)->format('d/m/Y h:i A') }}</p>
                    <p><strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->end)->format('d/m/Y h:i A') }}</p>
                    @if($event->description)
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $event->description }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">📋 Orden de Servicio (Liturgia)</h3>
                    </div>

                    @if($event->items->isEmpty())
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg text-center text-gray-500 dark:text-gray-400">
                            Este evento no tiene una liturgia asignada. 
                            <br>
                            <span class="text-xs">(Recuerda que debes seleccionar una plantilla al crear el evento).</span>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orden</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actividad</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Requisito</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asignado A</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($event->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500 dark:text-gray-400">
                                                {{ $item->order_index }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ $item->skill->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form action="{{ route('calendario.assign', $item->id) }}" method="POST" class="flex flex-col gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    
                                                    <div class="flex gap-2">
                                                        <select name="user_id" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-1 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300" {{ $event->status === 'closed' ? 'disabled' : '' }}>
                                                            <option value="">-- Sin Asignar --</option>
                                                            @foreach($users as $user)
                                                                @if($user->skills->contains('id', $item->skill_id))
                                                                    <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                                                        {{ $user->name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        
                                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-sm transition duration-150" {{ $event->status === 'closed' ? 'disabled' : '' }}>
                                                            💾
                                                        </button>
                                                    </div>

                                                    <textarea name="details" rows="2" placeholder="Escribe pasajes, cantos o notas..." class="block w-full py-1 px-3 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300" {{ $event->status === 'closed' ? 'disabled' : '' }}>{{ $item->details }}</textarea>
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
    <style>
    @media print {
        /* Ocultar el menú superior, botones y formularios de edición */
        nav, header, form, select, textarea, .no-print { 
            display: none !important; 
        }
        /* Limpiar fondos y sombras para que el PDF se vea profesional y blanco */
        body, .bg-white, .dark\:bg-gray-800, .dark\:bg-gray-900 { 
            background-color: white !important; 
            color: black !important;
            box-shadow: none !important;
        }
        /* Asegurar que la tabla y los textos se vean bien */
        table, th, td { border: 1px solid #ccc !important; color: black !important; }
        .text-gray-500, .dark\:text-gray-400, .dark\:text-white { color: black !important; }
    }
</style>
</x-app-layout>