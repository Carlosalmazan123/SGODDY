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
       Schema::create('factura_detalles', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('factura_id');

   
    $table->decimal('cantidad', 10, 2); // Cambiado a decimal para permitir cantidades fraccionarias
    $table->decimal('precio', 10, 2);
    $table->decimal('subtotal', 10, 2);
    $table->timestamps();

    $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
    $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
    $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_detalles');
    }
};
