<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cita;
use App\Notifications\RecordatorioCitasDiarias;
use Carbon\Carbon;
use CitaPendienteNotification;

class EnviarRecordatoriosCitas extends Command
{
    protected $signature = 'citas:recordatorios';
    protected $description = 'Enviar recordatorio diario de citas pendientes a los veterinarios';

    public function handle()
    {
        $hoy = Carbon::today();

        // Buscar veterinarios
        $veterinarios = User::role('admin')->get();

        foreach ($veterinarios as $veterinario) {
            // Contar citas del día de este veterinario
            $citasPendientes = Cita::whereDate('fecha', $hoy)
                ->where('user_id', $veterinario->id)
                ->count();

            if ($citasPendientes > 0) {
                $veterinario->notify(new CitaPendienteNotification($citasPendientes));
                $this->info("Notificación enviada a {$veterinario->name} con {$citasPendientes} citas.");
            }
        }
    }
}
