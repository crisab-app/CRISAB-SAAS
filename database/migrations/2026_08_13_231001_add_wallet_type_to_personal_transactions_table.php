<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_transactions', function (Blueprint $table) {
            // cash = Efectivo, debit = Tarjeta de Débito/Banco. 
            // Si usa tarjeta de crédito, este campo quedará nulo y se usará personal_debt_id.
            $table->string('wallet_type')->default('cash')->after('personal_debt_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('personal_transactions', function (Blueprint $table) {
            $table->dropColumn('wallet_type');
        });
    }
};