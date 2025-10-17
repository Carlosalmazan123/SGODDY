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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
         
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio', 10, 2);
       
            $table->string('unidad');
            $table->date('fecha_vencimiento')->nullable();
            $table->boolean('check')->default(false);
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedors')->onDelete('set null');
            if (!Schema::hasColumn('productos', 'stock_actual')) {
        $table->decimal('stock_actual', 10, 1)->default(0);
    }
            $table->string('imagen', 255)->nullable();
             $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
