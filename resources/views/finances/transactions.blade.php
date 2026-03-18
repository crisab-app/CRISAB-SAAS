<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-gray-500">
            <a href="{{ route('finances.index') }}" class="hover:text-indigo-600 transition">💰 Finanzas</a>
            <span>/</span>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                📓 Libro Diario
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📝 Nuevo Movimiento</h3>
                        
                        @if($funds->isEmpty())
                            <div class="text-red-500 text-sm font-bold bg-red-100 p-3 rounded">
                                ⚠️ Necesitas crear al menos una caja en la sección de "Cajas y Fondos" antes de registrar dinero.
                            </div>
                        @else
                            <form action="{{ route('finances.transactions.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                                    <div class="mt-2 flex gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="income" class="text-green-600 focus:ring-green-500" {{ old('type', request('type', 'income')) === 'income' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-bold text-green-600">📈 Ingreso</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="type" value="expense" class="text-red-600 focus:ring-red-500" {{ old('type', request('type')) === 'expense' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-bold text-red-500">📉 Gasto</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="fund_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿A qué Caja?</label>
                                    <select name="fund_id" id="fund_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach($funds as $fund)
                                            <option value="{{ $fund->id }}" {{ old('fund_id') == $fund->id ? 'selected' : '' }}>
                                                {{ $fund->name }} (Disponible: ${{ number_format($fund->balance, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto ($)</label>
                                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}" placeholder="0.00" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
                                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                                    <input type="text" list="categories" name="category" id="category" value="{{ old('category') }}" placeholder="Ej. Diezmos..." required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <datalist id="categories">
                                        <option value="Diezmos">
                                        <option value="Ofrenda de Culto">
                                        <option value="Pago de Servicios">
                                        <option value="Mantenimiento">
                                    </datalist>
                                </div>

                                <div class="mb-4">
                                    <label for="person_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Quién entrega/recibe? (Opcional)</label>
                                    <input type="text" name="person_name" id="person_name" value="{{ old('person_name') }}" placeholder="Nombre..." class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div class="mb-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción (Opcional)</label>
                                    <textarea name="description" id="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                                    💾 Guardar Movimiento
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">📖 Libro Mayor (Historial)</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detalle</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Fondo</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-green-600 uppercase">Ingreso (+)</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-red-600 uppercase">Egreso (-)</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($transactions as $tx)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition {{ $tx->status == 'cancelled' ? 'opacity-50 bg-red-50 dark:bg-red-900/10' : '' }}">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-bold {{ $tx->status == 'cancelled' ? 'line-through text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                                    {{ $tx->category }}
                                                    @if($tx->status == 'cancelled') <span class="text-red-500 text-xs font-black ml-1">(ANULADO)</span> @endif
                                                </div>
                                                @if($tx->person_name)
                                                    <div class="text-xs font-semibold text-indigo-500 dark:text-indigo-400">👤 {{ $tx->person_name }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                                <span class="font-bold text-gray-700 dark:text-gray-300">{{ $tx->fund->name }}</span>
                                            </td>
                                            
                                            <td class="px-4 py-4 whitespace-nowrap text-right font-bold text-green-600 {{ $tx->status == 'cancelled' ? 'line-through opacity-50' : '' }}">
                                                {{ $tx->type == 'income' ? '$' . number_format($tx->amount, 2) : '-' }}
                                            </td>
                                            
                                            <td class="px-4 py-4 whitespace-nowrap text-right font-bold text-red-600 {{ $tx->status == 'cancelled' ? 'line-through opacity-50' : '' }}">
                                                {{ $tx->type == 'expense' ? '$' . number_format($tx->amount, 2) : '-' }}
                                            </td>

                                            <td class="px-4 py-4 whitespace-nowrap text-center flex justify-center gap-2">
                                                @if($tx->status == 'active')
                                                    <a href="{{ route('finances.receipt', $tx->id) }}" target="_blank" title="Imprimir Recibo" class="text-indigo-600 hover:text-indigo-900 font-bold bg-indigo-100 p-2 rounded-full inline-block">
                                                        🖨️
                                                    </a>
                                                    
                                                    <form action="{{ route('finances.transactions.cancel', $tx->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de ANULAR este movimiento? El saldo se corregirá automáticamente.');" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" title="Anular Movimiento" class="text-red-600 hover:text-red-900 font-bold bg-red-100 p-2 rounded-full inline-block">
                                                            🚫
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-red-500 font-bold">Anulado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                                No hay movimientos registrados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>