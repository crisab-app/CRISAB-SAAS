<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Cambiamos ambas columnas a longText (capacidad casi infinita)
            $table->longText('bible_reading')->nullable()->change();
            $table->longText('sermon_notes')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Por si algún día queremos regresar atrás (no recomendado)
            $table->string('bible_reading')->nullable()->change();
            $table->text('sermon_notes')->nullable()->change();
        });
    }
};