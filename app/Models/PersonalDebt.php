<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDebt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'total_amount', 'minimum_payment', 'cutoff_day', 'payment_day', 'is_mortgage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}