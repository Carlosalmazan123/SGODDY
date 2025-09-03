<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TicketVirtual;
use Carbon\Carbon;

class EliminarTicketsExpirados extends Command
{
    protected $signature = 'tickets:eliminar'; // Nombre del comando para ejecutarlo
    protected $description = 'Elimina todos los tickets una vez pasada la hora límite';

    public function handle()
    {
        // Definir la hora límite (Ejemplo: 23:59 del día actual)
        $horaLimite = Carbon::now()->setTime(23, 59, 59);

        // Eliminar todos los tickets generados antes de la hora límite
        TicketVirtual::where('hora_generacion', '<', $horaLimite)->delete();

        $this->info('Se han eliminado todos los tickets del día.');
    }
}
