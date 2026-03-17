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
        Schema::create('funds', function (Blueprint $table) {
            $table->id();
            // Multi-tenant: A qué iglesia pertenece esta caja
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete(); 
            $table->string('name'); // Ej. Caja General, Pro-Construcción
            $table->decimal('balance', 12, 2)->default(0); // Hasta 9 mil millones con 2 decimales
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};
