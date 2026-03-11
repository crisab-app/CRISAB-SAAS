<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void 
    {
        // Procesamos cada columna por separado para que el error de una no detenga a las demás
        
        // 1. SLUG
        try {
            if (!Schema::hasColumn('contracts', 'slug')) {
                Schema::table('contracts', function (Blueprint $table) {
                    $table->string('slug')->unique()->nullable()->after('name');
                });
            }
        } catch (\Exception $e) { /* Ignorar si ya existe */ }

        // 2. UNIQUE CHURCH ID
        try {
            if (!Schema::hasColumn('contracts', 'unique_church_id')) {
                Schema::table('contracts', function (Blueprint $table) {
                    $table->string('unique_church_id')->nullable();
                });
            }
        } catch (\Exception $e) { /* Ignorar si ya existe */ }

        // 3. ADDRESS
        try {
            if (!Schema::hasColumn('contracts', 'address')) {
                Schema::table('contracts', function (Blueprint $table) {
                    $table->text('address')->nullable();
                });
            }
        } catch (\Exception $e) { /* Ignorar si ya existe */ }
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $columnas = ['slug', 'unique_church_id', 'address'];
            foreach ($columnas as $columna) {
                try {
                    if (Schema::hasColumn('contracts', $columna)) {
                        $table->dropColumn($columna);
                    }
                } catch (\Exception $e) { }
            }
        });
    }
};