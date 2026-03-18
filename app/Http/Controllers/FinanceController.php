<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\Transaction;
use App\Models\MonthlyClosing;

class FinanceController extends Controller
{
    // ==========================================
    // 1. DASHBOARD PRINCIPAL
    // ==========================================
    public function index()
    {
        $church_id = auth()->user()->contract_id;
        $funds = Fund::where('contract_id', $church_id)->get();
        return view('finances.index', compact('funds'));
    }

    // ==========================================
    // 2. GESTIÓN DE CAJAS
    // ==========================================
    public function funds()
    {
        $funds = Fund::where('contract_id', auth()->user()->contract_id)->get();
        return view('finances.funds', compact('funds'));
    }

    public function storeFund(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Fund::create([
            'contract_id' => auth()->user()->contract_id,
            'name' => $request->name,
            'balance' => 0, 
            'status' => 'active',
        ]);
        return back()->with('success', 'Caja creada correctamente.');
    }

    // Ver el Estado de Cuenta de UNA caja específica (Con saldo histórico)
    public function showFund(Fund $fund)
    {
        if ($fund->contract_id !== auth()->user()->contract_id) {
            abort(403, 'No tienes permiso para ver esta caja.');
        }

        $transactions = Transaction::where('fund_id', $fund->id)
                                    ->orderBy('date', 'asc')
                                    ->orderBy('id', 'asc')
                                    ->get();

        $running_balance = 0;
        $statement = collect(); 

        foreach ($transactions as $tx) {
            if ($tx->status === 'active') {
                if ($tx->type === 'income') {
                    $running_balance += $tx->amount;
                } else {
                    $running_balance -= $tx->amount;
                }
            }
            $tx->running_balance = $running_balance;
            $statement->push($tx);
        }

        $statement = $statement->reverse();
        return view('finances.fund_statement', compact('fund', 'statement'));
    }

    // ==========================================
    // 3. LIBRO DIARIO (MOVIMIENTOS)
    // ==========================================
    public function transactions()
    {
        $church_id = auth()->user()->contract_id;
        $funds = Fund::where('contract_id', $church_id)->where('status', 'active')->get();
        $transactions = Transaction::where('contract_id', $church_id)->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get();
        return view('finances.transactions', compact('funds', 'transactions'));
    }

    // Guardar un Ingreso o Egreso (Con Candado de Saldo)
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'fund_id' => 'required|exists:funds,id',
            'category' => 'required|string|max:255',
            'person_name' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $fund = Fund::where('contract_id', auth()->user()->contract_id)->findOrFail($request->fund_id);
        $amount = abs($request->amount);

        // Candado anti-deudas
        if ($request->type === 'expense' && $fund->balance < $amount) {
            return back()->with('error', '⚠️ Saldo insuficiente en ' . $fund->name . '. Solo tienes $' . number_format($fund->balance, 2) . ' disponibles.')->withInput();
        }

        Transaction::create([
            'contract_id' => auth()->user()->contract_id,
            'fund_id' => $fund->id,
            'user_id' => auth()->id(), 
            'type' => $request->type,
            'category' => $request->category,
            'person_name' => $request->person_name,
            'amount' => $amount,
            'date' => $request->date,
            'description' => $request->description,
            'status' => 'active',
        ]);

        if ($request->type === 'expense') {
            $fund->decrement('balance', $amount);
        } else {
            $fund->increment('balance', $amount);
        }

        return back()->with('success', 'Movimiento registrado correctamente.');
    }

    // Recibo de impresión
    public function receipt(Transaction $transaction)
    {
        if ($transaction->contract_id !== auth()->user()->contract_id) { abort(403); }
        return view('finances.receipt', compact('transaction'));
    }

    // Anular un movimiento
    public function cancelTransaction(Transaction $transaction)
    {
        if ($transaction->contract_id !== auth()->user()->contract_id) { abort(403); }
        if ($transaction->status === 'cancelled') {
            return back()->with('error', 'Este movimiento ya estaba anulado.');
        }

        $fund = $transaction->fund;

        if ($transaction->type === 'income') {
            $fund->decrement('balance', $transaction->amount); 
        } else {
            $fund->increment('balance', $transaction->amount); 
        }

        $transaction->update(['status' => 'cancelled']);
        return back()->with('success', 'Movimiento anulado correctamente. El saldo de la caja ha sido corregido.');
    } 

    // ==========================================
    // 4. CORTES Y AUDITORÍAS (POR PERIODO)
    // ==========================================
    // ==========================================
    // 4. CORTES Y AUDITORÍAS (POR CAJA Y PERIODO)
    // ==========================================
    public function closings()
    {
        $church_id = auth()->user()->contract_id;
        
        $closings = MonthlyClosing::where('contract_id', $church_id)->orderBy('start_date', 'desc')->get();
        $funds = Fund::where('contract_id', $church_id)->where('status', 'active')->get();
                                  
        return view('finances.closings', compact('closings', 'funds'));
    }

    // Calcular o Actualizar un Corte por Caja y Fechas
    public function storeClosing(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'fund_id' => 'required|exists:funds,id', // Exigimos saber qué caja estamos cortando
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $church_id = auth()->user()->contract_id;

        // Buscamos si ya existe este corte PARA ESTA CAJA en específico
        $existing = MonthlyClosing::where('contract_id', $church_id)->where('fund_id', $request->fund_id)->where('name', $request->name)->first();
        if ($existing && $existing->status === 'closed') {
            return back()->with('error', '⚠️ Este corte ya fue cerrado. Usa un nombre distinto.');
        }

        // Buscamos el dinero SOLO de la caja seleccionada
        $incomes = Transaction::where('fund_id', $request->fund_id)->where('type', 'income')->where('status', 'active')
                              ->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');
                              
        $expenses = Transaction::where('fund_id', $request->fund_id)->where('type', 'expense')->where('status', 'active')
                               ->whereBetween('date', [$request->start_date, $request->end_date])->sum('amount');

        $tithe = $incomes * 0.10; 
        $balance = $incomes - $expenses;

        if ($existing) {
            $existing->update([
                'start_date' => $request->start_date, 'end_date' => $request->end_date,
                'total_income' => $incomes, 'total_expense' => $expenses, 
                'tithe_to_pay' => $tithe, 'final_balance' => $balance
            ]);
        } else {
            MonthlyClosing::create([
                'contract_id' => $church_id, 'fund_id' => $request->fund_id, 'name' => $request->name,
                'start_date' => $request->start_date, 'end_date' => $request->end_date,
                'total_income' => $incomes, 'total_expense' => $expenses, 
                'tithe_to_pay' => $tithe, 'final_balance' => $balance, 'status' => 'draft'
            ]);
        }

        return back()->with('success', 'Corte de la caja calculado con éxito.');
    }

    // Cerrar Periodo y Pagar a Central desde la misma caja
    public function lockClosing(MonthlyClosing $closing)
    {
        if ($closing->contract_id !== auth()->user()->contract_id) { abort(403); }

        $fund = $closing->fund;

        if ($closing->tithe_to_pay > 0 && $fund->balance < $closing->tithe_to_pay) {
            return back()->with('error', '⚠️ La caja "' . $fund->name . '" no tiene saldo suficiente para pagar el 10% a la Central.');
        }

        $closing->update(['status' => 'closed']);

        // Se descuenta automáticamente de la caja dueña de este corte
        if ($closing->tithe_to_pay > 0) {
            Transaction::create([
                'contract_id' => auth()->user()->contract_id,
                'fund_id' => $fund->id,
                'user_id' => auth()->id(),
                'type' => 'expense',
                'category' => 'Aportación 10% a Central',
                'person_name' => 'Sede Central',
                'amount' => $closing->tithe_to_pay,
                'date' => now(), 
                'description' => 'Pago automático del 10% correspondiente al periodo auditado: ' . $closing->name,
                'status' => 'active',
            ]);
            $fund->decrement('balance', $closing->tithe_to_pay);
        }

        return back()->with('success', '✅ Corte cerrado con éxito. El pago del 10% fue descontado de ' . $fund->name);
    }
    // ==========================================
    // 5. AUDITORÍA GLOBAL (Todas las cajas)
    // ==========================================
    public function audit(Request $request)
    {
        $church_id = auth()->user()->contract_id;

        // Por defecto, mostramos el año actual completo
        $startDate = $request->input('start_date', date('Y-01-01'));
        $endDate = $request->input('end_date', date('Y-12-31'));

        // Traemos todos los movimientos activos de ESA iglesia en ese rango de fechas
        $transactions = Transaction::with('fund')
            ->where('contract_id', $church_id)
            ->where('status', 'active') 
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();

        // Matemática Global
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // Magia: Agrupamos por Caja para hacer un sub-reporte
        $fundBreakdown = $transactions->groupBy('fund_id')->map(function ($txs) {
            return [
                'name' => $txs->first()->fund->name ?? 'Caja Eliminada',
                'income' => $txs->where('type', 'income')->sum('amount'),
                'expense' => $txs->where('type', 'expense')->sum('amount'),
                'net' => $txs->where('type', 'income')->sum('amount') - $txs->where('type', 'expense')->sum('amount'),
            ];
        });

        return view('finances.audit', compact('transactions', 'startDate', 'endDate', 'totalIncome', 'totalExpense', 'netBalance', 'fundBreakdown'));
    }
        
}