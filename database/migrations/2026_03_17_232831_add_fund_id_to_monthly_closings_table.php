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
            // Relacionamos el corte con una caja en específico
            $table->foreignId('fund_id')->nullable()->after('contract_id')->constrained()->cascadeOnDelete();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_closings', function (Blueprint $table) {
            //
        });
    }
};
