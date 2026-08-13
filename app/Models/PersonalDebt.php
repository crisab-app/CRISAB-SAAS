<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonalDebt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name', 
        'total_amount', 
        'minimum_payment', 
        'cutoff_day', 
        'payment_day', 
        'is_mortgage'
    ];

    /**
     * Asegura que los datos salgan de la base de datos con el formato correcto
     */
    protected function casts(): array
    {
        return [
            'is_mortgage' => 'boolean',
            'total_amount' => 'decimal:2',
            'minimum_payment' => 'decimal:2',
            'cutoff_day' => 'integer',
            'payment_day' => 'integer',
        ];
    }

    // --- RELACIONES ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // =======================================================
    // 🧠 ATRIBUTOS VIRTUALES (Inteligencia del Modelo)
    // =======================================================

    /**
     * Calcula dinámicamente cuántos días exactos faltan para el pago
     */
    public function getDaysUntilPaymentAttribute()
    {
        if (!$this->payment_day) return null;

        $hoy = Carbon::now()->day;
        $diferencia = $this->payment_day - $hoy;

        // Si ya pasó el día de pago de este mes, calculamos los días hasta el pago del SIGUIENTE mes
        if ($diferencia < 0) {
            $diasEsteMes = Carbon::now()->daysInMonth; // Saber si el mes trae 28, 30 o 31
            $diferencia = ($diasEsteMes - $hoy) + $this->payment_day;
        }

        return $diferencia;
    }

    /**
     * Devuelve 'true' si faltan 5 días o menos para pagar (Alerta Roja)
     */
    public function getIsPaymentNearAttribute()
    {
        $days = $this->days_until_payment;
        return $days !== null && $days >= 0 && $days <= 5;
    }
}