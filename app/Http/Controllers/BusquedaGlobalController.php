<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Propietario;
use App\Models\User;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Factura;
use App\Models\Inventario;
use App\Models\TicketVirtual;
use App\Models\Proveedor;
use App\Models\HistorialClinico;
use Illuminate\Routing\Controller; // Asegúrate de importar el controlador base correcto
class BusquedaGlobalController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('busqueda');
        $bloques = [];

        $pacientes = Paciente::with(['paciente', 'propietario'])
        ->where('nombre', 'like', "%$query%")
        ->orWhere('especie', 'like', "%$query%")
        ->orWhere('raza', 'like', "%$query%")
        ->orWhere('anio', 'like', "%$query%")
        ->orWhere('edad', 'like', "%$query%")
        ->orWhere('sexo', 'like', "%$query%")
        ->orWhere('color', 'like', "%$query%")
        ->orWhere('peso', 'like', "%$query%")
        ->orWhereHas('propietario', function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%");
        })
        ->limit(5)
        ->get();
    
    if ($pacientes->isNotEmpty()) {
        $bloques[] = ['nombre' => 'Pacientes', 'resultados' => $pacientes];
    }
    

        $propietarios = Propietario::where('nombre', 'like', "%$query%")
            ->orWhere('apellido', 'like', "%$query%")
            ->orWhere('telefono', 'like', "%$query%")
            ->orWhere('direccion', 'like', "%$query%")
            ->limit(5)
            ->get();
        if ($propietarios->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Propietarios', 'resultados' => $propietarios];
        }

        $usuarios = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->limit(5)
            ->get();
        if ($usuarios->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Usuarios', 'resultados' => $usuarios];
        }
        $productos = Producto::where('nombre', 'like', "%$query%")
                                ->orWhere('precio', 'like', "%$query%")
                               
                                ->orWhere('descripcion', 'like', "%$query%")
                                ->orWhere('fecha_vencimiento', 'like', "%$query%")
                                ->orWhere('categoria_id', 'like', "%$query%")   
                                
                                ->limit(5) 
                                ->get();
        if ($productos->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Productos', 'resultados' => $productos];
        }
        $servicios = Servicio::where('nombre', 'like', "%$query%")
                                ->orWhere('precio', 'like', "%$query%")         
                                ->orWhere('descripcion', 'like', "%$query%")
                                ->orWhere('duracion', 'like', "%$query%")
                                ->orWhere('activo', 'like', "%$query%")
                                ->limit(5)
                                ->get();
        if ($servicios->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Servicios', 'resultados' => $servicios];
        }

                $citas = Cita::with(['relPaciente', 'propietario', 'servicio'])
                ->where('fecha_cita', 'like', "%$query%")
                ->orWhere('hora_cita', 'like', "%$query%")
                ->orWhere('estado', 'like', "%$query%")
                ->orWhereHas('relPaciente', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->orWhereHas('propietario', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->orWhereHas('servicio', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->limit(5)
                ->get(); 
        if ($citas->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Citas', 'resultados' => $citas];
        }                           
                $tickets= TicketVirtual::with(['user', 'servicio'])
                ->where('fecha_cita', 'like', "%$query%")
                ->orWhere('hora_cita', 'like', "%$query%")
                ->orWhere('nombre_mascota', 'like', "%$query%")
                ->orWhere('tipo_mascota', 'like', "%$query%")
                ->orWhereHas('user', function ($q) use ($query) {
                    $q->where('name', 'like', "%$query%");
                })
                ->orWhereHas('servicio', function ($q) use ($query) {
                    $q->where('nombre', 'like', "%$query%");
                })
                ->limit(5)
                ->get();
        if ($tickets->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Tickets Virtuales', 'resultados' => $tickets];
        }
        $proveedors = Proveedor::where('nombre', 'like', "%$query%")
                                ->orWhere('telefono', 'like', "%$query%")
                                ->orWhere('direccion', 'like', "%$query%")
                                ->orWhere('email', 'like', "%$query%")
                                ->limit(5)
                                ->get();
        if ($proveedors->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Proveedores', 'resultados' => $proveedors];
        }
        $historial = HistorialClinico::with(['paciente', 'propietario'])
        ->where('fecha', 'like', "%$query%")
        ->orWhere('anamnesis', 'like', "%$query%")
        ->orWhere('diagnostico', 'like', "%$query%")
        ->orWhere('examen', 'like', "%$query%")
        ->orWhere('tratamiento', 'like', "%$query%")
        ->orWhere('observaciones', 'like', "%$query%")
        ->orWhereHas('paciente', function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%");
        })
        ->limit(5)
        ->get();
        if ($historial->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Historial Clinico', 'resultados' => $historial];
        }
        $inventarios = Inventario::with(['producto'])
        ->where('fecha_movimiento', 'like', "%$query%")
        ->orWhere('descripcion', 'like', "%$query%")
        ->orWhere('stock', 'like', "%$query%")
        ->orWhere('tipo_movimiento', 'like', "%$query%")
        ->orWhereHas('producto', function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%");
        })
        
        ->limit(5)
        ->get();
        if ($inventarios->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Inventarios', 'resultados' => $inventarios];
        }
        // Buscamos en la tabla de facturas
        $facturas = Factura::with(['paciente'])
    
        ->Where('total', 'like', "%$query%")

        ->orWhereHas('paciente', function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%");
        })
        ->limit(5)
        ->get();
        if ($facturas->isNotEmpty()) {
            $bloques[] = ['nombre' => 'Facturas', 'resultados' => $facturas];
        }

        $page = $request->input('page', 1);
$perPage = 2;
$total = count($bloques);
$bloquesPaginados = array_slice($bloques, ($page - 1) * $perPage, $perPage);
$paginador = new \Illuminate\Pagination\LengthAwarePaginator(
    $bloquesPaginados,
    $total,
    $perPage,
    $page,
    ['path' => $request->url(), 'query' => $request->query()]
);
return view('resultados-busqueda', compact('paginador', 'query'));
    }
}
