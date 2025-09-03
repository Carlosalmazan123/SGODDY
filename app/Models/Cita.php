<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'paciente_id',
        'fecha_cita',
        'hora_cita',
        'servicio_id',
        'propietario_id',
        'estado'
    ];
    public function relPaciente()
    {
        return $this->belongsTo(Paciente::class,"paciente_id"); // Relación con Mascotas
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class,"servicio_id"); // Relación con Servicios
    }
    public function propietario()
    {
        return $this->belongsTo(Propietario::class,"propietario_id"); // Relación con Servicios
    }
    public function paciente()
    {
        return $this->belongsTo(Paciente::class,"paciente_id"); // Relación con Mascotas
    }
   
}
