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
    Schema::table('users', function (Blueprint $table) {
        // Conectamos al usuario con un contrato (puede ser nulo temporalmente para que no marque error con tus usuarios de prueba actuales)
        $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
        // Definimos si es administrador del contrato, secretario o miembro normal
        $table->string('system_role')->default('member'); // admin, secretary, member
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['contract_id']);
        $table->dropColumn(['contract_id', 'system_role']);
    });
}
};
