<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Datos Personales básicos
            $table->string('paternal_surname')->nullable()->after('name');
            $table->string('maternal_surname')->nullable()->after('paternal_surname');
            $table->date('birthdate')->nullable()->after('maternal_surname');
            $table->string('nationality')->nullable()->after('birthdate');
            
            // Documento de identidad (CURP para México)
            $table->string('curp')->nullable()->unique()->after('nationality');
            
            // Rutas seguras para guardar las imágenes en el servidor
            $table->string('profile_photo_path')->nullable();
            $table->string('id_front_path')->nullable();
            $table->string('id_back_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'paternal_surname', 
                'maternal_surname', 
                'birthdate', 
                'nationality', 
                'curp', 
                'profile_photo_path', 
                'id_front_path', 
                'id_back_path'
            ]);
        });
    }
};