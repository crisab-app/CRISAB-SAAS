<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-gray-500">
            <a href="{{ route('finances.index') }}" class="hover:text-indigo-600 transition">💰 Finanzas</a>
            <span>/</span>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                🗃️ Gestión de Cajas y Fondos
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">➕ Crear Nueva Caja</h3>
                        
                        <form action="{{ route('finances.funds.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre de la Caja / Fondo</label>
                                <input type="text" name="name" id="name" placeholder="Ej. Caja General, Jóvenes..." required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                                Guardar Caja
                            </button>
                        </form>
                    </div>
                    
                    <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-sm text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/30">
                        💡 <strong>Tip Financiero:</strong><br>
                        Puedes tener tantas cajas como necesites. Todo el dinero que ingreses o gastes en el "Libro Diario" deberá asignarse a una de estas cajas.
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tus Cajas Activas</h3>
                        </div>
                        
                        @if($funds->isEmpty())
                            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                📭 No has creado ninguna caja todavía. Usa el formulario de la izquierda para empezar.
                            </div>
                        @else
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Actual</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($funds as $fund)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">
                                                🗃️ {{ $fund->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right font-extrabold text-green-600 dark:text-green-400">
                                                ${{ number_format($fund->balance, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mb-2">
                                                    Activa
                                                </span>
                                                <br>
                                                <a href="{{ route('finances.funds.show', $fund->id) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded shadow-sm border border-indigo-200 transition">
                                                    📊 Ver Estado de Cuenta
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>