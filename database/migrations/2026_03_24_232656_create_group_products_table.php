<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('group_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->string('barcode')->nullable(); // ¡El superpoder del escáner!
            $table->string('name');
            $table->decimal('cost_price', 10, 2)->default(0); 
            $table->decimal('sale_price', 10, 2)->default(0); 
            $table->integer('stock')->default(0); // Inventario real
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_products');
    }
};