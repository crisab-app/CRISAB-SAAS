<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Borramos las columnas si existen
            if (Schema::hasColumn('events', 'start_time')) {
                $table->dropColumn('start_time');
            }
            if (Schema::hasColumn('events', 'end_time')) {
                $table->dropColumn('end_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // En caso de revertir, las volvemos a crear permitiendo nulos
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }
};