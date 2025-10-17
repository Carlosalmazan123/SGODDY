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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('propietario_id')->constrained('propietarios')->references('id')->onDelete('cascade');
            $table->date('fecha_cita');
            $table->string('hora_cita');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade'); // Nueva relación
            
            $table->enum('estado', ['Pendiente', 'Confirmada', 'Cancelada'])->default('Pendiente');
             $table->boolean('visible')->default(true);
                $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
