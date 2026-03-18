<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
            <a href="{{ route('finances.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition no-print">💰 Finanzas</a>
            <span class="no-print">/</span>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                🔍 Auditoría Global
            </h2>
        </div>
    </x-slot>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; color: black !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #ddd !important; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700 no-print">
                <form action="{{ route('finances.audit') }}" method="POST" class="flex flex-col md:flex-row items-end gap-4">
                    @csrf
                    <div class="w-full md:w-1/3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Desde la fecha:</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500">
                    </div>
                    <div class="w-full md:w-1/3">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Hasta la fecha:</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:ring-indigo-500">
                    </div>
                    <div class="w-full md:w-1/3 flex gap-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            🔎 Filtrar
                        </button>
                        <button type="button" onclick="window.print()" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow transition flex justify-center items-center gap-2">
                            🖨️ Imprimir
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center hidden print:block mb-8">
                <h1 class="text-3xl font-black uppercase">Reporte de Auditoría Financiera</h1>
                <p class="text-lg text-gray-600">Periodo: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 print-shadow-none text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">Ingresos Totales</p>
                    <h3 class="text-3xl font-black text-green-600 dark:text-green-400 mt-1">${{ number_format($totalIncome, 2) }}</h3>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 print-shadow-none text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">Egresos Totales</p>
                    <h3 class="text-3xl font-black text-red-600 dark:text-red-400 mt-1">${{ number_format($totalExpense, 2) }}</h3>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-6 shadow-sm border border-indigo-200 dark:border-indigo-800 print-shadow-none text-center">
                    <p class="text-indigo-600 dark:text-indigo-400 text-sm font-bold uppercase tracking-wider">Balance Neto (Utilidad)</p>
                    <h3 class="text-3xl font-black text-indigo-700 dark:text-indigo-300 mt-1">${{ number_format($netBalance, 2) }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 print-shadow-none">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase">🗃️ Resumen por Cajas</h3>
                        </div>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($fundBreakdown as $fund)
                                <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="font-bold text-gray-900 dark:text-white mb-2">{{ $fund['name'] }}</div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Ingresos:</span>
                                        <span class="text-green-600 font-bold">${{ number_format($fund['income'], 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Egresos:</span>
                                        <span class="text-red-600 font-bold">${{ number_format($fund['expense'], 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs mt-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                        <span class="font-bold text-gray-700 dark:text-gray-300">Neto:</span>
                                        <span class="font-black {{ $fund['net'] >= 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-red-600 dark:text-red-400' }}">
                                            ${{ number_format($fund['net'], 2) }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="p-4 text-xs text-center text-gray-500">No hay datos en este periodo.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 print-shadow-none">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase">📖 Libro Mayor Consolidado</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-bold text-gray-600 dark:text-gray-400">Fecha</th>
                                        <th class="px-4 py-2 text-left font-bold text-gray-600 dark:text-gray-400">Caja / Detalle</th>
                                        <th class="px-4 py-2 text-right font-bold text-green-600">Ingreso</th>
                                        <th class="px-4 py-2 text-right font-bold text-red-600">Egreso</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($transactions as $tx)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($tx->date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-[10px] font-black uppercase text-indigo-500">{{ $tx->fund->name ?? 'Caja N/A' }}</div>
                                                <div class="font-bold text-gray-900 dark:text-white">{{ $tx->category }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-right font-bold text-green-600 dark:text-green-400">
                                                {{ $tx->type == 'income' ? '$' . number_format($tx->amount, 2) : '' }}
                                            </td>
                                            <td class="px-4 py-3 text-right font-bold text-red-600 dark:text-red-400">
                                                {{ $tx->type == 'expense' ? '$' . number_format($tx->amount, 2) : '' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                                No hay movimientos registrados en estas fechas.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="hidden print:flex justify-around mt-20 pt-10">
                <div class="text-center w-64 border-t border-black pt-2">
                    <p class="font-bold">Revisado por (Auditor)</p>
                    <p class="text-xs text-gray-500 mt-1">Nombre y Firma</p>
                </div>
                <div class="text-center w-64 border-t border-black pt-2">
                    <p class="font-bold">Visto Bueno (Pastor/Tesorero)</p>
                    <p class="text-xs text-gray-500 mt-1">Nombre y Firma</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>