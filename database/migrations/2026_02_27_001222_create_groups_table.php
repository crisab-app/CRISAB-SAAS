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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            // ¡Importante! El grupo pertenece a una iglesia específica
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            
            $table->string('name'); // Ej: Sociedad Femenil, Consejo Local
            $table->string('description')->nullable(); // Detalles opcionales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
