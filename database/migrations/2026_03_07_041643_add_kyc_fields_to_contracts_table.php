<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        
        Schema::table('contracts', function (Blueprint $table) {
            // ... lo que sea que haya aquí abajo ya no importa
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'unique_church_id', 'denomination', 'address', 
                'maps_coordinates', 'initiator_name', 
                'registration_document_path', 'exterior_photo_path'
            ]);
        });
    }
};