<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends ConsoleKernel
{
     protected $commands = [
    \App\Console\Commands\EnviarRecordatoriosWhatsApp::class,
];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        $schedule->command('tickets:eliminar')->dailyAt('23:59'); // Se ejecuta a las 23:59 todos los días
        $schedule->command('enviar:recordatorios-whatsapp')->everyMinute();
           $schedule->command('citas:recordatorios')->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected $middlewareGroups = [
        'api' => [
            EnsureFrontendRequestsAreStateful::class, // ← Asegura autenticación con sesiones
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
    protected function unauthenticated($request, array $guards)
    {
        return response()->json(['error' => '⚠️ No autenticado'], 401);
    }
   
}
