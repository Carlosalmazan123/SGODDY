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
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->id();
           
            $table->text('anamnesis');
            $table->text('diagnostico');
            $table->text('examen');
            $table->text('fecha',2000); 
            $table->text('tratamiento',2000); // Cambiado a text
            $table->text('observaciones',2000); // Cambiado a text
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_clinico');
    }
};
