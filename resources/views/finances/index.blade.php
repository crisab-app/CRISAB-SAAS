<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
                💰 Panel Financiero
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('finances.transactions', ['type' => 'income']) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition text-sm">
                    ➕ Registrar Ingreso
                </a>
                <a href="{{ route('finances.transactions', ['type' => 'expense']) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow transition text-sm">
                    ➖ Registrar Gasto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <a href="{{ route('finances.index') }}" class="border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('finances.transactions') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            📓 Libro Diario
                        </a>
                        <a href="{{ route('finances.funds') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            🗃️ Cajas y Fondos
                        </a>
                        <a href="{{ route('finances.closings') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            📑 Cortes Mensuales
                        </a>
                        <a href="{{ route('finances.audit') }}" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition group flex flex-col items-center text-center">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-4 rounded-full mb-4 group-hover:scale-110 transition">
                                <span class="text-3xl">🔍</span>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Auditoría Global</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Reporte consolidado de todas las cajas por fechas.</p>
                        </a>
                    </nav>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Saldo Total Disponible</p>
                        <h3 class="text-3xl font-extrabold text-white mt-1">
                            ${{ number_format($funds->sum('balance'), 2) }}
                        </h3>
                    </div>
                    <div class="bg-indigo-600/20 p-4 rounded-full">
                        <span class="text-indigo-400 text-2xl">🏦</span>
                    </div>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Ingresos (Este Mes)</p>
                        <h3 class="text-3xl font-extrabold text-green-400 mt-1">$0.00</h3>
                    </div>
                    <div class="bg-green-500/20 p-4 rounded-full">
                        <span class="text-green-400 text-2xl">📈</span>
                    </div>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-wider">Egresos (Este Mes)</p>
                        <h3 class="text-3xl font-extrabold text-red-400 mt-1">$0.00</h3>
                    </div>
                    <div class="bg-red-500/20 p-4 rounded-full">
                        <span class="text-red-400 text-2xl">📉</span>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tus Cajas Activas</h3>
                    <a href="{{ route('finances.funds') }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-bold hover:underline">Gestionar Cajas →</a>
                </div>

                @if($funds->isEmpty())
                    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-10 text-center border-2 border-dashed border-gray-300 dark:border-gray-700">
                        <div class="text-6xl mb-4">🗃️</div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Aún no tienes cajas registradas</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
                            Para empezar a registrar ofrendas, diezmos o gastos, primero necesitas crear al menos una caja (por ejemplo: "Caja General" o "Fondo Pro-Templo").
                        </p>
                        <a href="{{ route('finances.funds') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            Crear mi primera Caja
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($funds as $fund)
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 border-l-4 border-indigo-500">
                                <h4 class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase">{{ $fund->name }}</h4>
                                <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-2">
                                    ${{ number_format($fund->balance, 2) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>