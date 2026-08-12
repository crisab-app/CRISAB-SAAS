<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTransaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalFinanceController extends Controller
{
    // Catálogo Estándar Simplificado
    const INCOME_CATEGORIES = [
        'Salario / Sueldo', 
        'Negocio / Ventas', 
        'Honorarios', 
        'Regalos', 
        'Inversiones', 
        'Otros Ingresos'
    ];

    const EXPENSE_CATEGORIES = [
        'Diezmos y Ofrendas', // Ideal por el contexto de la app
        'Vivienda (Renta/Hipoteca)', 
        'Alimentación / Despensa', 
        'Servicios (Luz, Agua, Internet)', 
        'Transporte / Gasolina', 
        'Salud y Médico', 
        'Deudas y Tarjetas', 
        'Educación', 
        'Entretenimiento', 
        'Otros Gastos'
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        // Movimientos del mes
        $transactions = PersonalTransaction::where('user_id', $user->id)
            ->whereMonth('date', $mesActual)
            ->whereYear('date', $anioActual)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Totales del mes
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $incomeCategories = self::INCOME_CATEGORIES;
        $expenseCategories = self::EXPENSE_CATEGORIES;

        return view('personal-finances.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'incomeCategories', 'expenseCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        PersonalTransaction::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Movimiento registrado correctamente.');
    }

    public function destroy(PersonalTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();
        return back()->with('success', 'Movimiento eliminado.');
    }
}