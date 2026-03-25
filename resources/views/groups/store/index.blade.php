<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('grupos.show', $group) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al Grupo
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                <span>🏪</span> Administración de Tienda: {{ $group->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Ventas Totales</p>
                    <p class="text-3xl font-black text-green-600 dark:text-green-400">${{ number_format($ingresos ?? 0, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm">
                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Compras (Inversión)</p>
                    <p class="text-3xl font-black text-red-600 dark:text-red-400">${{ number_format($egresos ?? 0, 2) }}</p>
                </div>
                <div class="bg-indigo-600 dark:bg-indigo-900 border border-indigo-500 rounded-xl p-6 shadow-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <p class="text-sm font-bold text-indigo-100 uppercase tracking-wider mb-1 relative z-10">Balance Neto</p>
                    <p class="text-3xl font-black text-white relative z-10">${{ number_format(($ingresos ?? 0) - ($egresos ?? 0), 2) }}</p>
                </div>
            </div>

            <h3 class="text-lg font-black text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Módulos del Sistema</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                
                <a href="{{ route('grupos.store.pos', $group) }}" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-blue-500 dark:hover:border-blue-500 transition-all text-center flex flex-col items-center justify-center gap-4 relative overflow-hidden">
                    <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                        🛒
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">Punto de Venta (Ventas)</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Cobrar con escáner, armar carrito y registrar salidas de mercancía.</p>
                    </div>
                </a>

                <a href="{{ route('grupos.store.purchases', $group) }}" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-orange-500 dark:hover:border-orange-500 transition-all text-center flex flex-col items-center justify-center gap-4 relative overflow-hidden">
                    <div class="w-20 h-20 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-full flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                        📦
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition">Compras e Insumos</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Registrar tickets de compra para resurtir inventario o gastos.</p>
                    </div>
                </a>

                <a href="{{ route('grupos.store.inventory', $group) }}" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-purple-500 dark:hover:border-purple-500 transition-all text-center flex flex-col items-center justify-center gap-4 relative overflow-hidden">
                    <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-full flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                        📋
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">Catálogo e Inventario</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Dar de alta productos, códigos de barra y ver existencias reales.</p>
                    </div>
                </a>

                <a href="{{ route('grupos.store.reports', $group) }}" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-8 shadow-sm hover:shadow-xl hover:border-green-500 dark:hover:border-green-500 transition-all text-center flex flex-col items-center justify-center gap-4 relative overflow-hidden">
                    <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center text-4xl group-hover:scale-110 transition-transform">
                        📊
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition">Reportes y Cierres</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Historial de tickets, cortes de caja y ganancias detalladas.</p>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>