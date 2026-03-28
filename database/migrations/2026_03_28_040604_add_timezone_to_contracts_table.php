<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Agregamos la columna y ponemos el horario de Cancún por defecto
            if (!Schema::hasColumn('contracts', 'timezone')) {
                $table->string('timezone')->default('America/Cancun')->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            if (Schema::hasColumn('contracts', 'timezone')) {
                $table->dropColumn('timezone');
            }
        });
    }
};