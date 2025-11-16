<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\CanchaControlador;
use App\Models\Controlador;
use App\Models\EspacioDeportivo;
use Illuminate\Http\Request;

class CanchaControladorController extends Controller
{
    
    // Mostrar todas las asignaciones
    public function index()
    {
        $asignaciones = CanchaControlador::with([
            'cancha',
            'controlador.user'
        ])->get();

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

        return redirect()->route('admin.asignacion.index')
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
        $asignacion = CanchaControlador::findOrFail($id);
        $espacios = EspacioDeportivo::all();
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
