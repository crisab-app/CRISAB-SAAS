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
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_template_id')->constrained()->cascadeOnDelete();
            // Esta línea conecta el bloque con el Privilegio (Ej. Requiere "Ujier")
            $table->foreignId('skill_id')->nullable()->constrained()->nullOnDelete(); 
            $table->string('name'); // Ej: "Bienvenida", "Recolección de Diezmos"
            $table->integer('order_index')->default(0); // Para ordenarlos (1, 2, 3...)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_items');
    }
};
