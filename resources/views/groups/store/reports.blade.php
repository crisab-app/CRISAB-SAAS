<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('grupos.store.index', $group) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al Menú
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📊 Reportes y Cierre de Caja: {{ $group->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 border-l-4 border-green-500 rounded-xl p-6 shadow-sm">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Ingresado (Ventas)</p>
                    <p class="text-3xl font-black text-green-600 dark:text-green-400">${{ number_format($totalVentas, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 border-l-4 border-red-500 rounded-xl p-6 shadow-sm">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Gastado (Compras)</p>
                    <p class="text-3xl font-black text-red-600 dark:text-red-400">${{ number_format($totalCompras, 2) }}</p>
                </div>
                <div class="bg-gray-900 border-l-4 {{ $gananciaNeta >= 0 ? 'border-blue-500' : 'border-orange-500' }} rounded-xl p-6 shadow-lg">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Ganancia / Balance Neto</p>
                    <p class="text-3xl font-black text-white">${{ number_format($gananciaNeta, 2) }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Historial de Transacciones</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Todos los movimientos registrados en la tiendita del grupo.</p>
                    </div>
                    <button onclick="window.print()" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center gap-2">
                        🖨️ Imprimir Reporte
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 uppercase text-[10px] font-black tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4">Folio / Fecha</th>
                                <th class="px-6 py-4">Tipo</th>
                                <th class="px-6 py-4">Detalle de Artículos</th>
                                <th class="px-6 py-4">Usuario (Cajero)</th>
                                <th class="px-6 py-4 text-right">Monto Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                            @forelse($transactions as $tx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold text-gray-900 dark:text-white">#TK-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-xs text-gray-500">{{ $tx->created_at->format('d/m/Y - h:i A') }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tx->type == 'venta')
                                        <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">🟢 Venta</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider">🔴 Compra</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <ul class="list-disc list-inside text-xs space-y-1">
                                        @foreach($tx->items as $item)
                                            <li>{{ $item->quantity }}x {{ $item->product->name ?? 'Producto Eliminado' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ $tx->user->name ?? 'Sistema' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right font-black text-lg {{ $tx->type == 'venta' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $tx->type == 'venta' ? '+' : '-' }}${{ number_format($tx->total, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                    No hay transacciones registradas aún. Las ventas y compras aparecerán aquí.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    
    <style>
        @media print {
            body * { visibility: hidden; }
            .max-w-7xl, .max-w-7xl * { visibility: visible; }
            .max-w-7xl { position: absolute; left: 0; top: 0; width: 100%; }
            button { display: none !important; }
            a { display: none !important; }
        }
    </style>
</x-app-layout>