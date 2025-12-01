<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\CanchaControlador;
use App\Models\Controlador;
use App\Models\Deportista;
use App\Models\EspacioDeportivo;
use App\Models\Pago;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if($roles->contains('ADMINISTRADOR')){
            $totalRoles = Role::count();
            $totalUsers = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'ADMINISTRADOR');
            })->withTrashed()->count();
            $totalEspacios = EspacioDeportivo::count();
            $totalCanchas = Cancha::count();
            $totalReservas = Reserva::doesntHave('cancelacion')->count();
            $totalDeportistas = Deportista::count();
            $ingresoHoy = Pago::whereDate('fechaPago', today())->sum('monto');
            $inicioSemana = now()->startOfWeek();
            $finSemana = now()->endOfWeek();
            $ingresoSemana = Pago::whereBetween('fechaPago', [$inicioSemana, $finSemana])->sum('monto');
            $inicioMes = now()->startOfMonth();
            $finMes = now()->endOfMonth();
            $ingresoMes = Pago::whereBetween('fechaPago', [$inicioMes, $finMes])->sum('monto');

            $ingresosAnuales = Pago::selectRaw('EXTRACT(MONTH FROM "fechaPago")::int as mes, SUM(monto) as total')
                ->whereYear('fechaPago', now()->year)
                ->orderBy('mes', 'asc')
                ->groupBy('mes')
                ->pluck('total', 'mes');
            $datosMensuales = [];
            for ($i = 1; $i <= 12; $i++) {
                $datosMensuales[] = $ingresosAnuales[$i] ?? 0;
            }

            $espacios = EspacioDeportivo::with('canchas.reservas')->get();
            $labels = [];
            $datos = [];
            foreach ($espacios as $espacio) {
                $labels[] = $espacio->nombre;
                $totalReservas = $espacio->canchas->sum(function ($cancha) {
                    return $cancha->reservas->count();
                });
                $datos[] = $totalReservas;
            }

            return view('admin.indexadmin', compact(
                'totalRoles',
                'totalUsers',
                'totalEspacios',
                'totalCanchas',
                'totalReservas',
                'totalDeportistas',
                'ingresoHoy',
                'ingresoSemana',
                'ingresoMes',
                'datosMensuales',
                'labels',
                'datos'
            ));
        }
        if($roles->contains('DEPORTISTA')){
            $espacios = EspacioDeportivo::all();
            return view('admin.deportistaespacios', compact('espacios'));
        }
        if($roles->contains('CONTROLADOR')){
            $controlador = Controlador::where('user_id', Auth::id())->first();
            $asignaciones = CanchaControlador::where('controlador_id', $controlador->id)->get();
            $turnos = [
                'Mañana' => ['08:00:00', '12:00:00'],
                'Tarde'  => ['12:00:00', '18:00:00'],
                'Noche'  => ['18:00:00', '20:00:00'],
            ];
            $reservas = collect();
            foreach ($asignaciones as $asig) {
                $rango = $turnos[$asig->turnoAsignado];
                $reservasTurno = Reserva::with(['cancha', 'disciplina', 'participantes.user'])
                    ->where('cancha_id', $asig->cancha_id)
                    ->whereDate('fechaReserva', $asig->fechaAsignacion)
                    ->whereTime('horaInicio', '>=', $rango[0])
                    ->whereTime('horaFin', '<=', $rango[1])
                    ->whereDoesntHave('cancelacion')
                    ->get();
                $reservas = $reservas->merge($reservasTurno);
            }
            return view('admin.controladorcanchas', compact('reservas'));
        }
        if($roles->contains('ADMINISTRADOR DE ESPACIOS')){
            $adminEspacio = $user->administradorEspacio;

            $fechaSeleccionada = $request->query('fecha', now()->toDateString());

            // $espacios = EspacioDeportivo::where('administrador_espacio_id', $adminEspacio->id)
            //     ->with(['canchas' => function($q) {
            //         $q->with('reservas');
            //         $q->with(['controladores' => function($c) {
            //             $c->wherePivot('fechaAsignacion', '>=', now()->toDateString())
            //             ->orderByPivot('fechaAsignacion', 'asc');
            //         }]);
            //     }])->get();

            $espacios = EspacioDeportivo::where('administrador_espacio_id', $adminEspacio->id)
            ->with(['canchas' => function($q) use ($fechaSeleccionada) {
                $q->with(['reservas' => function($r) use ($fechaSeleccionada) {
                    $r->where('fechaReserva', $fechaSeleccionada)
                      ->whereDoesntHave('cancelacion');
                }]);
                $q->with(['controladores' => function($c) use ($fechaSeleccionada) {
                    $c->wherePivot('fechaAsignacion', $fechaSeleccionada)
                      ->orderByPivot('turnoAsignado', 'asc');
                }]);
            }])->get();

            $canchaIds = $espacios->pluck('canchas')->flatten()->pluck('id');
            $totalEspacios = $espacios->count();
            $totalCanchas = $espacios->pluck('canchas')->flatten()->count();
            $totalReservas = $espacios->sum(function($espacio) {
                return $espacio->canchas->sum('reservas_count');
            });
            $pagosQuery = Pago::whereHas('reserva', function($q) use ($canchaIds) {
                $q->whereIn('cancha_id', $canchaIds);
            });

            $ingresoDia = (clone $pagosQuery)->whereDate('fechaPago', today())->sum('monto');
            $inicioSemana = now()->startOfWeek();
            $finSemana = now()->endOfWeek();
            $ingresoSemana = (clone $pagosQuery)->whereBetween('fechaPago', [$inicioSemana, $finSemana])->sum('monto');
            $controladoresList = Controlador::with('user')->get();

            return view('admin.administradorespacios', compact(
                'espacios',
                'totalEspacios',
                'totalCanchas',
                'totalReservas',
                'ingresoDia',
                'ingresoSemana',
                'controladoresList',
                'fechaSeleccionada'
            ));
        }
    }

    public function verCanchas($id)
    {
        $espacio = EspacioDeportivo::with(['canchas.valoraciones'])->findOrFail($id);
        return view('admin.deportistacanchas', compact('espacio'));
    }

}
