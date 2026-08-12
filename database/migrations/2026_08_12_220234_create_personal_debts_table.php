<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Ej: Hipoteca Infonavit, Tarjeta Nu
            $table->decimal('total_amount', 10, 2); // Deuda total a la fecha
            $table->decimal('minimum_payment', 10, 2)->default(0); // Cuota mensual/quincenal
            $table->integer('cutoff_day')->nullable(); // Día del mes (1 al 31)
            $table->integer('payment_day')->nullable(); // Día límite de pago
            $table->boolean('is_mortgage')->default(false); // Para separarlo del termómetro de deuda mala
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_debts');
    }
};