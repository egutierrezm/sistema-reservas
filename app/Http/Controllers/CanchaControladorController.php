<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\CanchaControlador;
use App\Models\Controlador;
use App\Models\EspacioDeportivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanchaControladorController extends Controller
{
    
    // Mostrar todas las asignaciones
    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('ADMINISTRADOR DE ESPACIOS')) {
            $espaciosIds = $user->administradorEspacio->espaciosDeportivos->pluck('id');
            $asignaciones = CanchaControlador::with([
                'cancha.espacioDeportivo',
                'controlador.user'
            ])
            ->whereHas('cancha', function($query) use ($espaciosIds) {
                $query->whereIn('espacio_deportivo_id', $espaciosIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }else{
            $asignaciones = CanchaControlador::with([
                'cancha.espacioDeportivo',
                'controlador.user'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        }
        // $asignaciones = CanchaControlador::with([
        //     'cancha',
        //     'controlador.user'
        // ])->orderBy('created_at', 'desc')->get();

        return view('admin.asignacion.index', compact('asignaciones'));
    }

    // Mostrar formulario para crear asignación
    public function create()
    {
        $espacios = EspacioDeportivo::all();
        $controladores = Controlador::with('user')->get();
        return view('admin.asignacion.create', compact('espacios', 'controladores'));
    }

    // Guardar nueva asignación
    public function store(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'controlador_id' => 'required|exists:controladors,id',
            'fechaAsignacion' => 'required|date',
            'turnoAsignado' => 'required|in:Mañana,Tarde,Noche',
        ]);

        $asignacion = new CanchaControlador();
        $asignacion->cancha_id = $request->cancha_id;
        $asignacion->controlador_id = $request->controlador_id;
        $asignacion->fechaAsignacion = $request->fechaAsignacion;
        $asignacion->turnoAsignado = $request->turnoAsignado;
        $asignacion->save();

        return redirect()->back()
            ->with('mensaje', '¡Asignación registrada correctamente!')
            ->with('icono', 'success');
    }

    // Mostrar detalle de una asignación
    public function show(string $id)
    {
        $asignacion = CanchaControlador::with([
            'cancha.espacioDeportivo',
            'controlador.user'
        ])->findOrFail($id);
        return view('admin.asignacion.show', compact('asignacion'));
    }

    // Mostrar formulario para editar asignación
    public function edit(string $id)
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');

        $asignacion = CanchaControlador::findOrFail($id);

        // $espacios = EspacioDeportivo::all();
        if ($roles->contains('ADMINISTRADOR DE ESPACIOS')) {
            $espacios = $user->administradorEspacio->espaciosDeportivos;
        } else {
            $espacios = EspacioDeportivo::all();
        }


        $espacioSeleccionadoId = $asignacion->cancha->espacio_deportivo_id;
        $canchas = Cancha::where('espacio_deportivo_id', $espacioSeleccionadoId)->get();
        $controladores = Controlador::with('user')->get();
        return view('admin.asignacion.edit', compact(
            'asignacion',
            'espacios',
            'canchas',
            'controladores',
            'espacioSeleccionadoId'
        ));
    }

    // Actualizar asignación
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'controlador_id' => 'required|exists:controladors,id',
            'fechaAsignacion' => 'required|date',
            'turnoAsignado' => 'required|in:Mañana,Tarde,Noche',
        ]);

        $asignacion = CanchaControlador::findOrFail($id);
        $asignacion->cancha_id = $request->cancha_id;
        $asignacion->controlador_id = $request->controlador_id;
        $asignacion->fechaAsignacion = $request->fechaAsignacion;
        $asignacion->turnoAsignado = $request->turnoAsignado;
        $asignacion->save();

        return redirect()->route('admin.asignacion.index')
            ->with('mensaje', '¡Asignación actualizada correctamente!')
            ->with('icono', 'success');
    }

    // Eliminar asignación
    public function destroy(string $id)
    {
        $asignacion = CanchaControlador::findOrFail($id);
        $asignacion->delete();
        return redirect()->route('admin.asignacion.index')
            ->with('mensaje', '¡Asignación eliminada correctamente!')
            ->with('icono', 'success');
    }

    public function getCanchasPorEspacio($id)
    {
        $canchas = Cancha::where('espacio_deportivo_id', $id)->get(['id', 'nombre']);
        return response()->json($canchas);
    }

}
