<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
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
    public function index(){
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
    }

    public function verCanchas($id)
    {
        $espacio = EspacioDeportivo::with(['canchas.valoraciones'])->findOrFail($id);
        return view('admin.deportistacanchas', compact('espacio'));
    }

}
