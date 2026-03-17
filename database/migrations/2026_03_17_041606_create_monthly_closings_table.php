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
        Schema::create('monthly_closings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            
            $table->integer('month');
            $table->integer('year');
            
            $table->decimal('total_income', 12, 2)->default(0);
            $table->decimal('total_expense', 12, 2)->default(0);
            $table->decimal('tithe_to_pay', 12, 2)->default(0); // El famoso 10% para la central
            $table->decimal('final_balance', 12, 2)->default(0);
            
            $table->enum('status', ['draft', 'closed'])->default('draft'); // Borrador o Cerrado Definitivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_closings');
    }
};
