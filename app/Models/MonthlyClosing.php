<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyClosing extends Model
{
    // Agregamos fund_id a la lista
    protected $fillable = [
        'contract_id', 'fund_id', 'name', 'start_date', 'end_date', 
        'total_income', 'total_expense', 'tithe_to_pay', 'final_balance', 'status'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // NUEVO: Relación con la caja
    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}