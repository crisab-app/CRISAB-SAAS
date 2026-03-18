<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Si la columna NO existe, la agregamos
            if (!Schema::hasColumn('events', 'contract_id')) {
                $table->foreignId('contract_id')->nullable()->constrained('contracts')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
    }
};