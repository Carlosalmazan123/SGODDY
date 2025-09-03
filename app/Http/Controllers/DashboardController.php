<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Factura;
use App\Models\TicketVirtual;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
{
    $hoy = Carbon::today();

    $citasHoy = Cita::whereDate('fecha_cita', $hoy)->count();
$ticketsHoy = TicketVirtual::whereDate('fecha_cita', $hoy)
    ->whereHas('user', function($query) {
        $query->role('cliente'); // Filtra solo usuarios con rol 'cliente'
    })
    ->count();


    // Total ventas del mes actual
    $primerDiaMes = Carbon::now()->startOfMonth();
    $ultimoDiaMes = Carbon::now()->endOfMonth();

    $ventasMes = Factura::whereBetween('fecha', [$primerDiaMes, $ultimoDiaMes])
                      ->sum('total');

    return view('dashboard', compact('citasHoy', 'ticketsHoy', 'ventasMes'));
}
}

