<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                <a href="{{ route('finances.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">💰 Finanzas</a>
                <span>/</span>
                <a href="{{ route('finances.funds') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">🗃️ Cajas</a>
                <span>/</span>
                <h2 class="font-semibold text-2xl leading-tight text-indigo-700 dark:text-indigo-400">
                    {{ $fund->name }}
                </h2>
            </div>
            
            <a href="{{ route('finances.transactions') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition text-sm">
                ➕ Registrar Movimiento
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-gradient-to-r from-indigo-800 to-indigo-600 rounded-xl p-6 shadow-lg flex items-center justify-between border border-indigo-900">
                <div>
                    <p class="text-indigo-200 text-sm font-bold uppercase tracking-wider mb-1">Saldo Actual Disponible</p>
                    <h3 class="text-4xl font-black text-white">
                        ${{ number_format($fund->balance, 2) }}
                    </h3>
                </div>
                <div class="bg-white/20 p-4 rounded-full">
                    <span class="text-white text-3xl">🏦</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">📊 Estado de Cuenta Histórico</h3>
                    <button onclick="window.print()" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-bold text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 px-3 py-1 rounded shadow-sm">
                        🖨️ Imprimir Reporte
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-400 uppercase">Concepto</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-green-600 dark:text-green-400 uppercase">Ingreso (+)</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-red-600 dark:text-red-400 uppercase">Egreso (-)</th>
                                <th class="px-6 py-3 text-right text-xs font-black text-indigo-700 dark:text-indigo-400 uppercase bg-indigo-50 dark:bg-indigo-900/50 border-l border-indigo-100 dark:border-indigo-800">Saldo Final</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($statement as $tx)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition {{ $tx->status == 'cancelled' ? 'opacity-50 bg-red-50 dark:bg-red-900/20' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 font-medium">
                                        {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold {{ $tx->status == 'cancelled' ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-white' }}">
                                            {{ $tx->category }}
                                            @if($tx->status == 'cancelled') <span class="text-red-500 text-[10px] font-black ml-1 uppercase">(Anulado)</span> @endif
                                        </div>
                                        @if($tx->person_name)
                                            <div class="text-xs font-semibold text-indigo-500 dark:text-indigo-400">👤 {{ $tx->person_name }}</div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-green-600 dark:text-green-400 {{ $tx->status == 'cancelled' ? 'line-through opacity-50' : '' }}">
                                        {{ $tx->type == 'income' ? '$' . number_format($tx->amount, 2) : '' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-red-600 dark:text-red-400 {{ $tx->status == 'cancelled' ? 'line-through opacity-50' : '' }}">
                                        {{ $tx->type == 'expense' ? '$' . number_format($tx->amount, 2) : '' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right font-black text-gray-900 dark:text-white bg-indigo-50/30 dark:bg-indigo-900/20 border-l border-indigo-50 dark:border-indigo-900/50">
                                        ${{ number_format($tx->running_balance, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 font-medium">
                                        Esta caja aún no tiene movimientos.
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