<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Preguntamos: ¿NO existe la columna 'is_baptized'? Entonces créala.
            if (!Schema::hasColumn('users', 'is_baptized')) {
                $table->boolean('is_baptized')->default(false)->after('marital_status');
            }
            
            // Preguntamos: ¿NO existe la columna 'baptism_date'? Entonces créala.
            if (!Schema::hasColumn('users', 'baptism_date')) {
                $table->date('baptism_date')->nullable()->after('is_baptized');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_baptized')) {
                $table->dropColumn('is_baptized');
            }
            if (Schema::hasColumn('users', 'baptism_date')) {
                $table->dropColumn('baptism_date');
            }
        });
    }
};