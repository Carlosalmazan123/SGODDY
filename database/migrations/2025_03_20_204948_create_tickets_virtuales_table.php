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
        Schema::create('tickets_virtuales', function (Blueprint $table) {
            $table->id();
           
            $table->string('nombre_mascota');
            $table->string('tipo_mascota');
            $table->date('fecha_cita');
            $table->string('hora_cita');
            $table->string('title');
            $table->date('start');
            $table->date('end');
            $table->string('color');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade'); // Nueva relación
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_virtuales');
    }
};
