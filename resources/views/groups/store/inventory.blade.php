<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('grupos.store.index', $group) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al Menú
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📋 Catálogo e Inventario: {{ $group->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl sticky top-6">
                        <h3 class="text-lg font-black text-purple-600 dark:text-purple-400 mb-4 flex items-center gap-2">📦 Nuevo Producto</h3>
                        
                        <form action="{{ route('grupos.store.inventory.store', $group) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Código de Barras</label>
                                <input type="text" name="barcode" autofocus placeholder="Pasa el escáner aquí..." class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-purple-500 focus:border-purple-500">
                                <p class="text-[10px] text-gray-400 mt-1">Déjalo en blanco si no tiene código.</p>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Nombre del Producto *</label>
                                <input type="text" name="name" required placeholder="Ej: Soda de Cola 600ml" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-purple-500 focus:border-purple-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Costo ($) *</label>
                                    <input type="number" step="0.01" name="cost_price" required placeholder="10.00" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Venta ($) *</label>
                                    <input type="number" step="0.01" name="sale_price" required placeholder="15.00" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Stock Inicial *</label>
                                <input type="number" name="stock" required placeholder="0" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-purple-500 focus:border-purple-500">
                            </div>

                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-bold shadow-md transition transform active:scale-95 mt-2">
                                + Guardar Producto
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden flex flex-col h-full">
                        
                        <div class="flex-grow overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600 dark:text-gray-400">
<thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 uppercase text-[10px] font-black tracking-wider border-b border-gray-200 dark:border-gray-700">
                                    <tr>
                                        <th class="px-6 py-4">Código / Producto</th>
                                        <th class="px-6 py-4 text-center">Costo</th>
                                        <th class="px-6 py-4 text-center">Venta</th>
                                        <th class="px-6 py-4 text-center">Stock</th>
                                        <th class="px-6 py-4 text-right">Acciones</th> </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50">
                                    @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p class="font-bold text-gray-900 dark:text-white text-base">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-400 font-mono mt-1">
                                                {!! $product->barcode ? '🏷️ '.$product->barcode : '<span class="italic">Sin código</span>' !!}
                                            </p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            ${{ number_format($product->cost_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-green-600 dark:text-green-400">
                                            ${{ number_format($product->sale_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="{{ $product->stock <= 5 ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' }} px-3 py-1 rounded-full font-black text-sm">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <form action="{{ route('grupos.store.inventory.destroy', [$group, $product]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto? Se borrará de la lista, pero las ventas pasadas se conservarán en los reportes.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-3 py-1.5 rounded-lg font-bold hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                            Tu inventario está vacío. Usa el formulario de la izquierda para registrar tu primer producto.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @php
                            $inversionTotal = $products->sum(function($p) { return $p->cost_price * $p->stock; });
                            $ventaEsperada = $products->sum(function($p) { return $p->sale_price * $p->stock; });
                        @endphp
                        
                        <div class="bg-gray-900 border-t border-gray-700 p-6 flex justify-between items-center text-white">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Dinero invertido en bodega</p>
                                <p class="text-2xl font-black">${{ number_format($inversionTotal, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Valor total de Venta</p>
                                <p class="text-2xl font-black text-green-400">${{ number_format($ventaEsperada, 2) }}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>