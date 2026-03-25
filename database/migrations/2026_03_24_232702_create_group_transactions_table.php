<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. La cabecera del Ticket (La compra o la venta general)
        Schema::create('group_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Quién cobró
            $table->enum('type', ['compra', 'venta']); // Compra (aumenta stock) | Venta (disminuye stock)
            $table->decimal('total', 10, 2)->default(0); // El total del ticket
            $table->timestamps();
        });

        // 2. El detalle del Ticket (Los productos exactos que se movieron)
        Schema::create('group_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Cuántos se vendieron o compraron
            $table->decimal('price', 10, 2); // Precio al que se vendió/compró en ese momento exacto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_transaction_items');
        Schema::dropIfExists('group_transactions');
    }
};