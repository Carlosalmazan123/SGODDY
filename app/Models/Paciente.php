<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'especie','anio', 'raza', 'edad', 'sexo', 'color', 'peso','propietario_id', 'imagen'];
    public function relPropietario()
    {
        return $this->belongsTo(Propietario::class, 'propietario_id');// Relación con Mascotas
    }
    public function relCita()
    {
        return $this->belongsTo(Cita::class); // Relación con Mascotas
    }
    public function historial()
    {
        return $this->hasMany(HistorialClinico::class);
    }
    public function propietario()
{
    return $this->belongsTo(Propietario::class);
}

    
}
