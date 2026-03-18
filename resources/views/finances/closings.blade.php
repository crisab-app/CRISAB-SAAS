<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
            <a href="{{ route('finances.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">💰 Finanzas</a>
            <span>/</span>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                📑 Cortes por Caja
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">🧮 Generar Nuevo Corte</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Audita los ingresos y gastos de una caja específica.</p>
                        
                        <form action="{{ route('finances.closings.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">¿Qué caja vas a cortar?</label>
                                <select name="fund_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach($funds as $fund)
                                        <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Nombre del Corte</label>
                                <input type="text" name="name" placeholder="Ej. Semana Santa, Marzo 2026..." required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-2 mb-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Desde:</label>
                                    <input type="date" name="start_date" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Hasta:</label>
                                    <input type="date" name="end_date" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-xs">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition flex justify-center items-center gap-2">
                                ⚙️ Calcular Caja
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">📑 Historial de Cortes de Caja</h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 gap-6">
                            @forelse($closings as $c)
                                <div class="border {{ $c->status == 'closed' ? 'border-green-300 dark:border-green-700 bg-green-50/30 dark:bg-green-900/10' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800' }} rounded-xl p-5 shadow-sm relative">
                                    
                                    @if($c->status == 'closed')
                                        <div class="absolute top-0 right-0 mt-3 mr-4 text-green-600 dark:text-green-400 text-xs font-black flex items-center gap-1">
                                            🔒 CERRADO
                                        </div>
                                    @else
                                        <div class="absolute top-0 right-0 mt-3 mr-4 text-orange-500 text-xs font-black flex items-center gap-1">
                                            ✏️ BORRADOR
                                        </div>
                                    @endif

                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 text-xs font-black px-2 py-1 rounded-md uppercase">
                                            🗃️ {{ $c->fund->name ?? 'Caja Eliminada' }}
                                        </span>
                                    </div>
                                    <h4 class="text-xl font-black text-gray-800 dark:text-white uppercase">{{ $c->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 font-medium">
                                        📅 Del {{ \Carbon\Carbon::parse($c->start_date)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($c->end_date)->format('d/m/Y') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm mb-4">
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 font-bold uppercase text-[10px]">Ingresos</p>
                                            <p class="font-bold text-green-600 dark:text-green-400 text-lg">${{ number_format($c->total_income, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 font-bold uppercase text-[10px]">Egresos</p>
                                            <p class="font-bold text-red-600 dark:text-red-400 text-lg">${{ number_format($c->total_expense, 2) }}</p>
                                        </div>
                                        <div class="bg-indigo-50 dark:bg-indigo-900/30 p-2 rounded border border-indigo-100 dark:border-indigo-800">
                                            <p class="text-indigo-600 dark:text-indigo-300 font-bold uppercase text-[10px]">10% a Central</p>
                                            <p class="font-black text-indigo-700 dark:text-indigo-400 text-lg">${{ number_format($c->tithe_to_pay, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400 font-bold uppercase text-[10px]">Utilidad</p>
                                            <p class="font-black text-gray-900 dark:text-white text-lg">${{ number_format($c->final_balance, 2) }}</p>
                                        </div>
                                    </div>

                                    @if($c->status == 'draft')
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                                            <form action="{{ route('finances.closings.lock', $c->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas CERRAR este reporte? Se descontará el 10% automáticamente de esta caja.');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-700 dark:text-green-100 bg-green-100 dark:bg-green-800 hover:bg-green-200 dark:hover:bg-green-700 font-bold py-1 px-4 rounded text-xs transition border border-green-300 dark:border-green-600">
                                                    🔒 Cerrar y Pagar 10%
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                                    Aún no has generado ningún reporte.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>