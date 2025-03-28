<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class TicketVirtual extends Model
{
    use HasFactory;
    protected $table = 'tickets_virtuales';
    protected $fillable = [
    'nombre_mascota',
    'servicio_id',
     'fecha_cita', 
     'hora_cita', 
     'title', 
     'start', 
     'end', 
     'color',
     'user_id'];

     public function user()
     {
         return $this->belongsTo(User::class);
     }
     public function servicio() {
        return $this->belongsTo(Servicio::class);
    }

}
