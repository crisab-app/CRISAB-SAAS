<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalTransaction;
use App\Models\PersonalDebt;
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
        $mesActual = \Carbon\Carbon::now()->month;
        $anioActual = \Carbon\Carbon::now()->year;

        // Movimientos del mes
        $transactions = PersonalTransaction::where('user_id', $user->id)
            ->whereMonth('date', $mesActual)
            ->whereYear('date', $anioActual)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Lista de Deudas registradas
        $debts = PersonalDebt::where('user_id', $user->id)->orderBy('total_amount', 'asc')->get(); // Método Bola de Nieve (de menor a mayor)

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // ==========================================
        // 🧠 MOTOR DE DIAGNÓSTICO DE DEUDAS Y GASTOS
        // ==========================================
        
        // Sumamos los pagos mínimos obligatorios de las deudas
        $pagosMinimosRequeridos = $debts->sum('minimum_payment');
        
        // Lo que realmente ha pagado este mes en deudas (excluyendo la hipoteca, que es gasto fijo)
        $totalDeudasPagadas = $transactions->where('category', 'Deudas y Tarjetas')->sum('amount');
        
        // Nivel de Endeudamiento (Cuánto de su ingreso se va a pagar deudas)
        $porcentajeDeuda = $totalIncome > 0 ? ($pagosMinimosRequeridos / $totalIncome) * 100 : 0;

        // Diezmos
        $totalDiezmos = $transactions->where('category', 'Diezmos y Ofrendas')->sum('amount');

        // Gastos Esenciales
        $categoriasFijas = ['Vivienda (Renta/Hipoteca)', 'Alimentación / Despensa', 'Servicios (Luz, Agua, Internet)', 'Transporte / Gasolina', 'Salud y Médico'];
        $totalFijos = $transactions->whereIn('category', $categoriasFijas)->sum('amount');

        // Gastos de Estilo de Vida
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

    // Guardar Deuda Nueva
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

    // Eliminar Deuda
    public function destroyDebt(PersonalDebt $debt)
    {
        if ($debt->user_id !== Auth::id()) abort(403);
        $debt->delete();
        return back()->with('success', 'Cuenta eliminada.');
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