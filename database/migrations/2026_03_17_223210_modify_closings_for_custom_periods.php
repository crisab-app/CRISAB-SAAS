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
        Schema::table('monthly_closings', function (Blueprint $table) {
            // Borramos las columnas rígidas de mes y año
            $table->dropColumn(['month', 'year']);
            
            // Agregamos las columnas flexibles
            $table->string('name')->after('contract_id'); // Ej. "Corte 1ra Quincena"
            $table->date('start_date')->after('name');
            $table->date('end_date')->after('start_date');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
