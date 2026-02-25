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
        Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: Salón Principal, Salón Infantil
        $table->integer('capacity')->nullable(); // Cuánta gente cabe
        $table->string('color')->default('#3b82f6'); // Un color para que se vea bonito en el calendario
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
