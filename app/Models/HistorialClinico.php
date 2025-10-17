<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialClinico extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $dates = ['deleted_at'];
    protected $table = 'historial_clinico';
    protected $primaryKey = "id";
    protected $guarded = ["id"];

    protected $casts = [
        "fecha" => "array",
        "tratamiento" => "array",
        "observaciones" => "array",
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
    
    public function servicio()
    {
        return $this->belongsTo(servicio::class);
    }
    public function Propietario()
    {
        return $this->belongsTo(Propietario::class);
    }
}
