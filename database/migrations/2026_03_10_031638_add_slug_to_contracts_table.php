<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void 
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Validamos cada columna individualmente antes de crearla
            if (!Schema::hasColumn('contracts', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('contracts', 'unique_church_id')) {
                $table->string('unique_church_id')->nullable();
            }

            if (!Schema::hasColumn('contracts', 'address')) {
                $table->text('address')->nullable();
            }
            
            // Si tienes más columnas en este archivo que estén dando error, 
            // agrégalas aquí siguiendo el mismo patrón de "if (!Schema::hasColumn...)"
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $columnas = ['slug', 'unique_church_id', 'address'];
            
            foreach ($columnas as $columna) {
                if (Schema::hasColumn('contracts', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};