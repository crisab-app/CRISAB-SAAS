<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = ['contract_id', 'name', 'balance', 'status'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}