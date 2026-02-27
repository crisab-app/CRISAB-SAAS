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
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            // Conectamos con el grupo
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            // Conectamos con el usuario
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Aquí guardamos su cargo (Presidente, Secretario, Vocal 1, etc.)
            $table->string('role')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
