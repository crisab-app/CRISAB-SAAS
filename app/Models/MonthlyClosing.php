<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyClosing extends Model
{
    protected $fillable = [
        'contract_id', 'month', 'year', 'total_income', 
        'total_expense', 'tithe_to_pay', 'final_balance', 'status'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}