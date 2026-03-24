<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Lo hacemos 'nullable' por si los usuarios viejos no lo tienen aún, 
            // pero lo exigiremos en el formulario nuevo.
            $table->string('phone')->nullable()->unique()->after('email');
            
            // Hacemos que el email pueda ser nulo si eligen registrarse solo con teléfono
            $table->string('email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};