<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('grupos.store.index', $group) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al Menú
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📦 Registro de Compras e Insumos
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl sticky top-6">
                        <h3 class="text-lg font-black text-orange-600 dark:text-orange-400 mb-4 flex items-center gap-2">🛒 Registrar Gasto</h3>
                        
                        <form action="{{ route('grupos.store.purchases.store', $group) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">¿Qué producto compraste? *</label>
                                <select name="group_product_id" required class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                    <option value="" disabled selected>Selecciona del catálogo...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (En stock: {{ $product->stock }})</option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-400 mt-1">Si no está en la lista, ve a Inventario para crearlo.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Cantidad *</label>
                                    <input type="number" name="quantity" required placeholder="Ej: 24" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Total Pagado ($) *</label>
                                    <input type="number" step="0.01" name="total_cost" required placeholder="Ej: 250.00" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Nota / Folio del Ticket (Opcional)</label>
                                <input type="text" name="ticket_note" placeholder="Ej: Ticket Walmart #12345" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                            </div>

                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg font-bold shadow-md transition transform active:scale-95 mt-2 flex items-center justify-center gap-2">
                                ➕ Ingresar al Almacén
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 sm:rounded-2xl overflow-hidden flex flex-col h-full">
                        
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Historial de Inversiones</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Últimos gastos registrados para surtir la tiendita.</p>
                        </div>

                        <div class="flex-grow overflow-x-auto p-6 pt-0">
                            @if($purchases->isEmpty())
                                <div class="text-center py-10">
                                    <p class="text-gray-500 text-lg">Aún no hay compras registradas.</p>
                                </div>
                            @else
                                <div class="space-y-4 mt-4">
                                    @foreach($purchases as $purchase)
                                        <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex justify-between items-center hover:border-orange-500/50 transition">
                                            <div>
                                                <p class="text-xs text-gray-400 font-bold mb-1">{{ $purchase->created_at->format('d M Y - h:i A') }}</p>
                                                @foreach($purchase->items as $item)
                                                    <p class="font-black text-gray-800 dark:text-white text-lg">
                                                        +{{ $item->quantity }} <span class="text-gray-500 text-sm font-medium">{{ $item->product->name ?? 'Producto Eliminado' }}</span>
                                                    </p>
                                                @endforeach
                                                <p class="text-xs text-gray-500 mt-1">Registrado por: {{ $purchase->user->name ?? 'Sistema' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-red-500 font-bold uppercase tracking-wider mb-1">Costo Total</p>
                                                <p class="text-2xl font-black text-red-600 dark:text-red-400">-${{ number_format($purchase->total, 2) }}</p>
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
    </div>
</x-app-layout>