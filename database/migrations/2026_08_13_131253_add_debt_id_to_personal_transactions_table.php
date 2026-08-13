<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_transactions', function (Blueprint $table) {
            // Relacionamos la transacción con la deuda (puede ser nulo si pagó en efectivo)
            $table->foreignId('personal_debt_id')->nullable()->constrained('personal_debts')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('personal_transactions', function (Blueprint $table) {
            $table->dropForeign(['personal_debt_id']);
            $table->dropColumn('personal_debt_id');
        });
    }
};