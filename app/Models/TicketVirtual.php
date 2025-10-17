<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class TicketVirtual extends Model
{
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
     protected $dates = ['deleted_at'];
    protected $table = 'tickets_virtuales';
    protected $fillable = [
    'nombre_mascota',
    'tipo_mascota',
    'servicio_id',
     'fecha_cita', 
     'hora_cita', 
     'title', 
     'start', 
     'end', 
     'color',
     'user_id',
    'modelo',
    'visible'
    ];

     public function user()
     {
         return $this->belongsTo(User::class);
     }
     public function servicio() {
        return $this->belongsTo(Servicio::class);
    }
    public function propietario()
{
    return $this->hasOne(Propietario::class);
}

}
