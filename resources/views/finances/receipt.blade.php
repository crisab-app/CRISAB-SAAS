<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10" onload="window.print()">

    <div class="bg-white w-full max-w-md p-8 rounded-lg shadow-2xl border border-gray-200 relative overflow-hidden">
        
        <div class="absolute top-0 right-0 p-4 opacity-10 font-black text-6xl transform rotate-12 select-none">
            {{ $transaction->type == 'income' ? 'INGRESO' : 'EGRESO' }}
        </div>

        <div class="text-center border-b-2 border-dashed border-gray-300 pb-6 mb-6 relative z-10">
            <h1 class="text-2xl font-extrabold text-gray-800 uppercase">{{ $transaction->contract->name ?? 'Nuestra Iglesia' }}</h1>
            <p class="text-sm text-gray-500 mt-1">Comprobante Oficial de Movimiento</p>
            <div class="mt-4 font-mono text-gray-600 bg-gray-100 py-1 px-3 rounded-md inline-block font-bold tracking-widest">
                FOLIO: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <div class="space-y-4 text-gray-700 relative z-10">
            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                <span class="font-bold text-gray-500 text-sm uppercase">Fecha:</span>
                <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</span>
            </div>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                <span class="font-bold text-gray-500 text-sm uppercase">Caja/Fondo:</span>
                <span class="font-medium text-gray-900">{{ $transaction->fund->name }}</span>
            </div>
            
            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                <span class="font-bold text-gray-500 text-sm uppercase">Categoría:</span>
                <span class="font-medium text-gray-900">{{ $transaction->category }}</span>
            </div>

            @if($transaction->person_name)
            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-200 mt-4">
                <span class="font-bold text-gray-600 text-sm">
                    {{ $transaction->type == 'income' ? '📥 Recibido de:' : '📤 Pagado a:' }}
                </span>
                <span class="font-extrabold text-gray-900">{{ $transaction->person_name }}</span>
            </div>
            @endif
            
            @if($transaction->description)
            <div class="pt-2">
                <span class="font-bold block text-sm text-gray-500 uppercase">Concepto / Descripción:</span>
                <p class="text-sm italic text-gray-800 bg-gray-50 p-3 rounded mt-1 border">{{ $transaction->description }}</p>
            </div>
            @endif
        </div>

        <div class="mt-8 border-t-2 border-dashed border-gray-300 pt-6 text-center bg-gray-50 rounded-lg pb-4 relative z-10">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Monto Total</p>
            <h2 class="text-4xl font-black mt-1 {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                ${{ number_format($transaction->amount, 2) }}
            </h2>
        </div>

        <div class="mt-16 grid grid-cols-2 gap-6 text-center relative z-10">
            <div>
                <div class="border-t border-gray-800 w-full mx-auto"></div>
                <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase">Autoriza / Registra</p>
                <p class="text-sm font-bold text-gray-900 mt-1">{{ $transaction->user->name ?? 'Usuario del sistema' }}</p>
                <p class="text-[10px] text-gray-400">Tesorería</p>
            </div>
            
            <div>
                <div class="border-t border-gray-800 w-full mx-auto"></div>
                <p class="text-[10px] text-gray-500 mt-2 font-bold uppercase">
                    Firma de quien {{ $transaction->type == 'income' ? 'Entrega' : 'Recibe' }}
                </p>
                <p class="text-sm font-bold text-gray-900 mt-1">{{ $transaction->person_name ?? '____________________' }}</p>
            </div>
        </div>

        <div class="mt-12 text-center no-print">
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition mr-2 flex items-center justify-center mx-auto w-full mb-3">
                🖨️ Imprimir Recibo Oficial
            </button>
            <button onclick="window.close()" class="text-gray-500 hover:text-gray-800 font-bold text-sm underline transition">
                Cerrar Ventana
            </button>
        </div>
    </div>

</body>
</html>