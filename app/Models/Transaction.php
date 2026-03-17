<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'contract_id', 'fund_id', 'user_id', 'type', 
        'category', 'amount', 'date', 'description', 'status'
    ];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    public function user() // El tesorero que lo registró
    {
        return $this->belongsTo(User::class);
    }
}