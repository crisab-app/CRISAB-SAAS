<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            💼 Mi Billetera <span class="text-sm font-normal text-gray-500 ml-2">(Control Personal)</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- 1. Tarjetas de Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase">Ingresos del Mes</p>
                    <h3 class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-2">${{ number_format($totalIncome, 2) }}</h3>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase">Gastos del Mes</p>
                    <h3 class="text-3xl font-extrabold text-red-600 dark:text-red-400 mt-2">${{ number_format($totalExpense, 2) }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 {{ $balance >= 0 ? 'border-indigo-500' : 'border-orange-500' }}">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase">Balance Disponible</p>
                    <h3 class="text-3xl font-extrabold {{ $balance >= 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-orange-600 dark:text-orange-400' }} mt-2">
                        ${{ number_format($balance, 2) }}
                    </h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- 2. Formulario de Registro (Izquierda) -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ type: 'expense' }">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">➕ Registrar Movimiento</h3>
                        
                        <form action="{{ route('personal.finances.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Selector Ingreso / Egreso -->
                            <div class="flex bg-gray-100 dark:bg-gray-900 rounded-lg p-1">
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="type" value="income" x-model="type" class="sr-only">
                                    <div class="py-2 rounded-md text-sm font-bold transition-all" 
                                         :class="type === 'income' ? 'bg-green-500 text-white shadow' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'">
                                        Ingreso
                                    </div>
                                </label>
                                <label class="flex-1 text-center cursor-pointer">
                                    <input type="radio" name="type" value="expense" x-model="type" class="sr-only">
                                    <div class="py-2 rounded-md text-sm font-bold transition-all" 
                                         :class="type === 'expense' ? 'bg-red-500 text-white shadow' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'">
                                        Gasto
                                    </div>
                                </label>
                            </div>

                            <!-- Monto y Fecha -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Monto *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" name="amount" required class="pl-7 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha *</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Categorías Dinámicas con AlpineJS -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Categoría *</label>
                                
                                <!-- Select para Ingresos -->
                                <select name="category" x-show="type === 'income'" :required="type === 'income'" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-green-500 focus:border-green-500">
                                    <option value="" disabled selected>Selecciona un ingreso...</option>
                                    @foreach($incomeCategories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>

                                <!-- Select para Egresos -->
                                <select name="category" x-show="type === 'expense'" :required="type === 'expense'" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-red-500 focus:border-red-500" style="display: none;">
                                    <option value="" disabled selected>Selecciona un gasto...</option>
                                    @foreach($expenseCategories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descripción (Opcional)</label>
                                <input type="text" name="description" placeholder="Ej. Quincena, Despensa Walmart..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition">
                                💾 Guardar Movimiento
                            </button>
                        </form>
                    </div>
                </div>

                <!-- 3. Lista de Movimientos (Derecha) -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">📅 Historial de este Mes</h3>
                        </div>

                        <div class="overflow-x-auto">
                            @if($transactions->isEmpty())
                                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="text-5xl mb-3 opacity-50">🍃</div>
                                    <p>No has registrado movimientos este mes.</p>
                                </div>
                            @else
                                <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                                    <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                                        <tr>
                                            <th class="px-6 py-3">Fecha</th>
                                            <th class="px-6 py-3">Detalle</th>
                                            <th class="px-6 py-3">Categoría</th>
                                            <th class="px-6 py-3 text-right">Monto</th>
                                            <th class="px-6 py-3 text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($transactions as $tx)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $tx->date->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="font-bold text-gray-900 dark:text-white block">{{ $tx->description ?? 'Sin descripción' }}</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-md bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                        {{ $tx->category }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right font-black {{ $tx->type == 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ $tx->type == 'income' ? '+' : '-' }}${{ number_format($tx->amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <form action="{{ route('personal.finances.destroy', $tx) }}" method="POST" onsubmit="return confirm('¿Borrar este movimiento?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-600 transition">🗑️</button>
                                                    </form>
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
    </div>
</x-app-layout>