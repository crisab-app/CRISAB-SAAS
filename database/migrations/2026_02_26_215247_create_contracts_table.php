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
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: Iglesia Ebenezer
        $table->string('address')->nullable(); // Dirección física
        $table->string('coordinates')->nullable(); // Para el mapa (Latitud, Longitud)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
