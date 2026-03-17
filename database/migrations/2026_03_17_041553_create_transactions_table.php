<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fund_id')->constrained()->cascadeOnDelete(); // A qué caja entró/salió
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Quién lo registró
            
            $table->enum('type', ['income', 'expense']); // Ingreso o Egreso
            $table->string('category'); // Ej: Diezmo, Ofrenda de Culto, Pago de Luz
            $table->decimal('amount', 12, 2);
            $table->date('date'); // Fecha real del movimiento
            $table->text('description')->nullable();
            
            // Regla de oro contable: No se borra, se cancela
            $table->enum('status', ['active', 'cancelled'])->default('active'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
