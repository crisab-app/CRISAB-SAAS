<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTransaction;
use App\Models\PersonalDebt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalFinanceController extends Controller
{
    const INCOME_CATEGORIES = [
        'Salario / Sueldo', 'Negocio / Ventas', 'Honorarios', 
        'Regalos', 'Inversiones', 'Otros Ingresos'
    ];

    const EXPENSE_CATEGORIES = [
        'Diezmos y Ofrendas', 'Vivienda (Renta/Hipoteca)', 'Alimentación / Despensa', 
        'Servicios (Luz, Agua, Internet)', 'Transporte / Gasolina', 'Salud y Médico', 
        'Deudas y Tarjetas', 'Educación', 'Entretenimiento', 'Otros Gastos'
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        $transactions = PersonalTransaction::where('user_id', $user->id)
            ->whereMonth('date', $mesActual)
            ->whereYear('date', $anioActual)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $debts = PersonalDebt::where('user_id', $user->id)->orderBy('total_amount', 'asc')->get();

        // 🧠 CÁLCULO INTELIGENTE DEL BALANCE (EFECTIVO)
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        
        // El efectivo solo baja si pagó con efectivo, O si usó efectivo para abonarle a la tarjeta
        $totalExpense = $transactions->where('type', 'expense')->filter(function ($tx) {
            return is_null($tx->personal_debt_id) || $tx->category === 'Deudas y Tarjetas';
        })->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $pagosMinimosRequeridos = $debts->sum('minimum_payment');
        $totalDeudasPagadas = $transactions->where('category', 'Deudas y Tarjetas')->sum('amount');
        $porcentajeDeuda = $totalIncome > 0 ? ($pagosMinimosRequeridos / $totalIncome) * 100 : 0;

        $totalDiezmos = $transactions->where('category', 'Diezmos y Ofrendas')->sum('amount');
        $categoriasFijas = ['Vivienda (Renta/Hipoteca)', 'Alimentación / Despensa', 'Servicios (Luz, Agua, Internet)', 'Transporte / Gasolina', 'Salud y Médico'];
        $totalFijos = $transactions->whereIn('category', $categoriasFijas)->sum('amount');

        $categoriasVariables = ['Entretenimiento', 'Otros Gastos', 'Educación'];
        $totalVariables = $transactions->whereIn('category', $categoriasVariables)->sum('amount');

        $incomeCategories = self::INCOME_CATEGORIES;
        $expenseCategories = self::EXPENSE_CATEGORIES;

        return view('personal-finances.index', compact(
            'transactions', 'debts', 'totalIncome', 'totalExpense', 'balance', 
            'incomeCategories', 'expenseCategories', 
            'pagosMinimosRequeridos', 'totalDeudasPagadas', 'porcentajeDeuda', 'totalDiezmos', 'totalFijos', 'totalVariables'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'personal_debt_id' => 'nullable|exists:personal_debts,id' // Validar la cuenta seleccionada
        ]);

        $transaction = PersonalTransaction::create([
            'user_id' => Auth::id(),
            'personal_debt_id' => $request->personal_debt_id,
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // 🪄 LÓGICA DE ACTUALIZACIÓN DE SALDOS DE DEUDAS
        if ($request->personal_debt_id) {
            $debt = PersonalDebt::find($request->personal_debt_id);
            if ($debt) {
                if ($request->type === 'income') {
                    // Si registra ingreso a una tarjeta (Ej. Disposición de efectivo), sube su deuda
                    $debt->increment('total_amount', $request->amount);
                } elseif ($request->category === 'Deudas y Tarjetas') {
                    // Si registra un gasto en categoría "Deudas" hacia una tarjeta, ES UN PAGO. (Baja su deuda)
                    $debt->decrement('total_amount', $request->amount);
                } else {
                    // Si registra gasto en "Comida" hacia una tarjeta, es UNA COMPRA. (Sube su deuda)
                    $debt->increment('total_amount', $request->amount);
                }
            }
        }

        return back()->with('success', 'Movimiento registrado correctamente.');
    }

    public function destroy(PersonalTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) abort(403);

        // Si borramos un movimiento, tenemos que revertir el saldo en la tarjeta
        if ($transaction->personal_debt_id) {
            $debt = $transaction->debt;
            if ($debt) {
                if ($transaction->type === 'income') {
                    $debt->decrement('total_amount', $transaction->amount);
                } elseif ($transaction->category === 'Deudas y Tarjetas') {
                    $debt->increment('total_amount', $transaction->amount);
                } else {
                    $debt->decrement('total_amount', $transaction->amount);
                }
            }
        }

        $transaction->delete();
        return back()->with('success', 'Movimiento eliminado y saldo ajustado.');
    }

    public function storeDebt(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:1',
            'minimum_payment' => 'required|numeric|min:1',
            'payment_day' => 'required|integer|min:1|max:31',
            'cutoff_day' => 'nullable|integer|min:1|max:31',
        ]);

        PersonalDebt::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'total_amount' => $request->total_amount,
            'minimum_payment' => $request->minimum_payment,
            'payment_day' => $request->payment_day,
            'cutoff_day' => $request->cutoff_day,
            'is_mortgage' => $request->has('is_mortgage'),
        ]);

        return back()->with('success', 'Cuenta de crédito registrada.');
    }

    public function destroyDebt(PersonalDebt $debt)
    {
        if ($debt->user_id !== Auth::id()) abort(403);
        $debt->delete();
        return back()->with('success', 'Cuenta eliminada.');
    }
}