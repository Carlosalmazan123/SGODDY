<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Propietario extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido', 'telefono', 'email', 'direccion','correo', 'user_id','opt_in_whatsapp'];

    public function relPaciente()
    {
        return $this->hasMany(Paciente::class, "propietario_id"); // Relación con Mascotas
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
 public function pacientes()
    {
        return $this->hasMany(Paciente::class, "propietario_id"); // Relación con Mascotas
    }
}
