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
       Schema::create('inventario', function (Blueprint $table) {
    $table->id();
    $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
    $table->enum('tipo_movimiento', ['entrada', 'salida', 'ajuste']);
    $table->text('descripcion')->nullable();
    $table->timestamp('fecha_movimiento')->useCurrent();
    
    // 👉 Cantidad del movimiento (entrada o salida)
    $table->decimal('stock', 10, 1)->default(0);
    
     if (!Schema::hasColumn('inventario', 'stock_anterior')) {
        $table->decimal('stock_anterior', 10, 1)->nullable();
    }
    if (!Schema::hasColumn('inventario', 'stock_nuevo')) {
        $table->decimal('stock_nuevo', 10, 1)->nullable();
    }

    $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
    $table->softDeletes();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
