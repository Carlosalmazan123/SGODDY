<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Propietario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'telefono', 'email', 'direccion'];

    public function relPaciente()
    {
        return $this->hasMany(Paciente::class); // Relación con Mascotas
    }
}
