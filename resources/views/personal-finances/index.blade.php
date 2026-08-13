<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            💼 Mi Billetera <span class="text-sm font-normal text-gray-500 ml-2 border-l border-gray-400 pl-2">Control Financiero Personal</span>
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'resumen' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg shadow-sm font-bold flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- 1. Tarjetas de Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 border-green-500 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-16 h-16 bg-green-500/10 rounded-bl-full"></div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ingresos del Mes</p>
                    <h3 class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-2">${{ number_format($totalIncome, 2) }}</h3>
                </div>
                
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 border-red-500 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-16 h-16 bg-red-500/10 rounded-bl-full"></div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gastos del Mes</p>
                    <h3 class="text-3xl font-extrabold text-red-600 dark:text-red-400 mt-2">${{ number_format($totalExpense, 2) }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border-l-4 {{ $balance >= 0 ? 'border-indigo-500' : 'border-orange-500' }} relative overflow-hidden ring-1 {{ $balance >= 0 ? 'ring-indigo-500/30' : 'ring-red-500/30' }}">
                    <div class="absolute right-0 top-0 w-16 h-16 {{ $balance >= 0 ? 'bg-indigo-500/10' : 'bg-red-500/10' }} rounded-bl-full"></div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Balance Disponible</p>
                    <h3 class="text-3xl font-extrabold {{ $balance >= 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-orange-600 dark:text-orange-400' }} mt-2">
                        ${{ number_format($balance, 2) }}
                    </h3>
                </div>
            </div>

            <!-- Navegación de Pestañas -->
            <div class="flex gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-px overflow-x-auto">
                <button @click="tab = 'resumen'" :class="tab === 'resumen' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="border-b-2 py-2 px-4 whitespace-nowrap transition-colors">
                    📊 Resumen y Movimientos
                </button>
                <button @click="tab = 'deudas'" :class="tab === 'deudas' ? 'border-red-500 text-red-600 dark:text-red-400 font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="border-b-2 py-2 px-4 whitespace-nowrap transition-colors">
                    💳 Control de Deudas
                </button>
            </div>

            <!-- ============================================== -->
            <!-- PESTAÑA 1: RESUMEN Y MOVIMIENTOS -->
            <!-- ============================================== -->
            <div x-show="tab === 'resumen'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                
                <!-- 🏥 TERMÓMETRO FINANCIERO Y PLAN DE RESCATE -->
                @if($totalIncome > 0)
                    <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-700 p-6 md:p-8 mb-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            
                            <!-- Columna Izquierda: Diagnóstico -->
                            <div>
                                <h3 class="text-xl font-black text-white flex items-center gap-2 mb-4">
                                    🌡️ Salud Financiera (Termómetro)
                                </h3>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between items-end mb-2">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Compromiso en Deudas Mensuales</span>
                                        <span class="text-2xl font-black {{ $porcentajeDeuda >= 30 ? 'text-red-400' : ($porcentajeDeuda >= 15 ? 'text-yellow-400' : 'text-green-400') }}">
                                            {{ number_format($porcentajeDeuda, 1) }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-800 rounded-full h-2 border border-gray-700 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 {{ $porcentajeDeuda >= 30 ? 'bg-gradient-to-r from-red-600 to-red-400' : ($porcentajeDeuda >= 15 ? 'bg-gradient-to-r from-yellow-600 to-yellow-400' : 'bg-gradient-to-r from-green-600 to-green-400') }}" style="width: {{ min($porcentajeDeuda, 100) }}%"></div>
                                    </div>
                                </div>

                                @if($porcentajeDeuda >= 30)
                                    <div class="bg-red-900/20 border border-red-500/30 p-4 rounded-xl mt-4">
                                        <p class="text-red-400 font-bold text-sm flex items-center gap-2">⚠️ Alerta Roja</p>
                                        <p class="text-gray-300 text-xs mt-2 leading-relaxed">Peligro financiero. Tus deudas consumen más del 30% de tu sueldo. <strong class="text-white">Plan de Rescate:</strong> Cancela las tarjetas que no uses, recorta a $0 los gastos de "Estilo de vida" este mes y abona todo el extra a la deuda más pequeña.</p>
                                    </div>
                                @elseif($porcentajeDeuda >= 15)
                                    <div class="bg-yellow-900/20 border border-yellow-500/30 p-4 rounded-xl mt-4">
                                        <p class="text-yellow-400 font-bold text-sm flex items-center gap-2">⚡ Precaución</p>
                                        <p class="text-gray-300 text-xs mt-2 leading-relaxed">Estás al límite. No aceptes nuevos créditos y mantén un presupuesto estricto hasta bajar este número al 10%.</p>
                                    </div>
                                @else
                                    <div class="bg-green-900/20 border border-green-500/30 p-4 rounded-xl mt-4">
                                        <p class="text-green-400 font-bold text-sm flex items-center gap-2">✅ Finanzas Controladas</p>
                                        <p class="text-gray-300 text-xs mt-2 leading-relaxed">Excelente trabajo. Tus compromisos mensuales son saludables. Enfócate en tu fondo de emergencia.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Columna Derecha: Balance Ideal -->
                            <div>
                                <h3 class="text-xl font-black text-white flex items-center gap-2 mb-4">
                                    ⚖️ Distribución (Actual vs Ideal)
                                </h3>
                                
                                <div class="space-y-3">
                                    <!-- Gastos Fijos -->
                                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-blue-500/20 flex items-center justify-center text-blue-400">🏠</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-200">Fijos (Casa, Comida, etc)</p>
                                                <p class="text-[10px] text-gray-500">Ideal: Hasta 70%</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-white">${{ number_format($totalFijos, 2) }}</p>
                                            <p class="text-[10px] font-bold {{ ($totalFijos / $totalIncome * 100) > 70 ? 'text-red-400' : 'text-green-400' }}">{{ number_format(($totalFijos / $totalIncome) * 100, 1) }}%</p>
                                        </div>
                                    </div>

                                    <!-- Estilo de vida -->
                                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-purple-500/20 flex items-center justify-center text-purple-400">☕</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-200">Estilo de Vida</p>
                                                <p class="text-[10px] text-gray-500">Ideal: 10% - 20%</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-white">${{ number_format($totalVariables, 2) }}</p>
                                            <p class="text-[10px] font-bold text-gray-400">{{ number_format(($totalVariables / $totalIncome) * 100, 1) }}%</p>
                                        </div>
                                    </div>

                                    <!-- Diezmos y Ofrendas -->
                                    <div class="flex items-center justify-between p-3 bg-gray-800 rounded-lg border border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded bg-amber-500/20 flex items-center justify-center text-amber-400">🕊️</div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-200">Diezmos y Ofrendas</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-white">${{ number_format($totalDiezmos, 2) }}</p>
                                            <p class="text-[10px] font-bold text-gray-400">{{ number_format(($totalDiezmos / $totalIncome) * 100, 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Registro (Izquierda) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ type: 'expense' }">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">➕ Registrar Movimiento</h3>
                            
                            <form action="{{ route('personal.finances.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Selector -->
                                <div class="flex bg-gray-100 dark:bg-gray-900 rounded-xl p-1">
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="type" value="income" x-model="type" class="sr-only">
                                        <div class="py-2.5 rounded-lg text-sm font-bold transition-all" :class="type === 'income' ? 'bg-green-500 text-white shadow-md' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'">Ingreso</div>
                                    </label>
                                    <label class="flex-1 text-center cursor-pointer">
                                        <input type="radio" name="type" value="expense" x-model="type" class="sr-only">
                                        <div class="py-2.5 rounded-lg text-sm font-bold transition-all" :class="type === 'expense' ? 'bg-red-500 text-white shadow-md' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'">Gasto</div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Monto *</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-gray-500">$</span></div>
                                            <input type="number" step="0.01" name="amount" required class="pl-7 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fecha *</label>
                                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Categoría *</label>
                                    <select name="category" x-show="type === 'income'" :required="type === 'income'" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-green-500">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($incomeCategories as $cat) <option value="{{ $cat }}">{{ $cat }}</option> @endforeach
                                    </select>
                                    <select name="category" x-show="type === 'expense'" :required="type === 'expense'" style="display:none;" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-red-500">
                                        <option value="" disabled selected>Selecciona...</option>
                                        @foreach($expenseCategories as $cat) <option value="{{ $cat }}">{{ $cat }}</option> @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Concepto</label>
                                    <input type="text" name="description" placeholder="Opcional..." class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                </div>

                                <!-- Selector de Cuenta / Método de Pago -->
                                <div class="pt-2 border-t border-gray-100 dark:border-gray-700 mt-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Método de Pago / Cuenta *</label>
                                    <select name="personal_debt_id" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                        <option value="">💵 Efectivo / Débito (Mi Billetera)</option>
                                        @if(isset($debts) && $debts->count() > 0)
                                            <optgroup label="Mis Tarjetas y Créditos">
                                                @foreach($debts as $debt)
                                                    <option value="{{ $debt->id }}">💳 {{ $debt->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                                    <p class="text-[10px] text-gray-400 mt-1">Si pagas con tarjeta de crédito, tu efectivo no disminuirá pero tu deuda aumentará.</p>
                                </div>

                                <button type="submit" class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl shadow-lg transition transform active:scale-95 mt-4">
                                    💾 Guardar Movimiento
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Movimientos (Derecha) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">📅 Movimientos de este Mes</h3>
                            </div>
                            <div class="overflow-x-auto max-h-[450px] overflow-y-auto">
                                @if($transactions->isEmpty())
                                    <div class="p-10 text-center text-gray-500 dark:text-gray-400">
                                        <div class="text-5xl mb-3 opacity-30">🍃</div>
                                        <p>Lista en blanco.</p>
                                    </div>
                                @else
                                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                                        <thead class="bg-gray-50 dark:bg-gray-900/80 sticky top-0 backdrop-blur-sm shadow-sm z-10">
                                            <tr>
                                                <th class="px-6 py-3 font-black text-xs uppercase tracking-wider">Fecha</th>
                                                <th class="px-6 py-3 font-black text-xs uppercase tracking-wider">Categoría / Detalle</th>
                                                <th class="px-6 py-3 font-black text-xs uppercase tracking-wider text-right">Monto</th>
                                                <th class="px-6 py-3"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                            @foreach($transactions as $tx)
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-xs">{{ $tx->date->format('d/M') }}</td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 mb-1 inline-block">{{ $tx->category }}</span>
                                                        <span class="font-bold text-gray-900 dark:text-white block mb-1">{{ $tx->description ?? '--' }}</span>
                                                        @if($tx->debt)
                                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300">
                                                                💳 {{ $tx->debt->name }}
                                                            </span>
                                                        @else
                                                            <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                                                💵 Efectivo
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right font-black {{ $tx->type == 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                        {{ $tx->type == 'income' ? '+' : '-' }}${{ number_format($tx->amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <form action="{{ route('personal.finances.destroy', $tx) }}" method="POST" onsubmit="return confirm('¿Borrar?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">🗑️</button>
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

            <!-- ============================================== -->
            <!-- PESTAÑA 2: CONTROL DE DEUDAS Y CRÉDITOS -->
            <!-- ============================================== -->
            <div x-show="tab === 'deudas'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Registrar Deuda (Izquierda) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">💳 Añadir Cuenta / Crédito</h3>
                            
                            <form action="{{ route('personal.debts.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre de la Cuenta *</label>
                                    <input type="text" name="name" required placeholder="Ej. Tarjeta Nu, Préstamo Banco" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Deuda Total *</label>
                                        <input type="number" step="0.01" name="total_amount" required placeholder="$" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pago Mensual *</label>
                                        <input type="number" step="0.01" name="minimum_payment" required placeholder="$" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1" title="Día en que cierra el estado de cuenta">Día de Corte</label>
                                        <input type="number" name="cutoff_day" min="1" max="31" placeholder="Ej. 15" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1" title="Día límite para pagar sin intereses">Día Límite Pago *</label>
                                        <input type="number" name="payment_day" required min="1" max="31" placeholder="Ej. 5" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_mortgage" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-bold">Es Crédito Hipotecario / Auto</span>
                                    </label>
                                    <p class="text-[10px] text-gray-500 ml-6 mt-1">Márcalo si es deuda "buena/fija". Las tarjetas déjalas sin marcar.</p>
                                </div>

                                <button type="submit" class="w-full py-3.5 px-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-black rounded-xl shadow-lg transition transform active:scale-95 mt-4">
                                    Guardar Crédito
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lista de Deudas (Derecha) -->
                    <div class="lg:col-span-2 space-y-4">
                        @if(isset($debts) && $debts->isEmpty())
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-10 text-center text-gray-500">
                                <div class="text-5xl mb-3 opacity-30">🙌</div>
                                <p class="text-lg font-bold text-gray-700 dark:text-gray-300">¡Libre de Deudas!</p>
                                <p class="text-sm mt-1">No tienes tarjetas ni créditos registrados.</p>
                            </div>
                        @else
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl p-4 mb-4">
                                <p class="text-sm text-indigo-800 dark:text-indigo-300 font-medium">💡 <strong>Consejo (Bola de Nieve):</strong> Las deudas están ordenadas de menor a mayor. Paga el mínimo de todas, pero ataca la primera de la lista con todo el dinero extra que te sobre en el mes. ¡Es la más fácil de liquidar y te dará motivación!</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($debts as $debt)
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border shadow-sm relative overflow-hidden {{ $debt->is_payment_near ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-gray-700' }}">
                                        @if($debt->is_payment_near)
                                            <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-black uppercase px-2 py-1 rounded-bl-lg">¡Pago en {{ $debt->days_until_payment }} días!</div>
                                        @endif
                                        
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h4 class="font-bold text-gray-900 dark:text-white">{{ $debt->name }}</h4>
                                                @if($debt->is_mortgage)
                                                    <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">Hipotecario / Fijo</span>
                                                @endif
                                            </div>
                                            <form action="{{ route('personal.debts.destroy', $debt) }}" method="POST" onsubmit="return confirm('¿Eliminar cuenta?');">
                                                @csrf @method('DELETE')
                                                <button class="text-gray-400 hover:text-red-500">🗑️</button>
                                            </form>
                                        </div>

                                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3 grid grid-cols-2 gap-2 mb-3">
                                            <div>
                                                <p class="text-[10px] text-gray-500 uppercase font-bold">Deuda Total</p>
                                                <p class="text-lg font-black text-gray-800 dark:text-gray-200">${{ number_format($debt->total_amount, 2) }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] text-gray-500 uppercase font-bold">Pago Mensual</p>
                                                <p class="text-lg font-black text-indigo-600 dark:text-indigo-400">${{ number_format($debt->minimum_payment, 2) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex justify-between text-xs font-medium text-gray-500">
                                            <div>✂️ Corte: Día {{ $debt->cutoff_day ?? '--' }}</div>
                                            <div class="{{ $debt->is_payment_near ? 'text-red-500 font-bold' : '' }}">⚠️ Pago: Día {{ $debt->payment_day }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>