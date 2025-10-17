<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $dates = ['deleted_at'];
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
