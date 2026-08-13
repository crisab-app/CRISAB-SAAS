<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTransaction extends Model
{
    use HasFactory;

    // Asegúrate de agregar 'personal_debt_id' al arreglo
    protected $fillable = [
        'user_id', 'personal_debt_id', 'type', 'category', 'amount', 'date', 'description'
    ];

    public function debt()
    {
        return $this->belongsTo(PersonalDebt::class, 'personal_debt_id');
    }
    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}