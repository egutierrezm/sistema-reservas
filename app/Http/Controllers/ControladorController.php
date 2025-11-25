<?php

namespace App\Http\Controllers;

use App\Models\Controlador;
use App\Models\Deportista;
use App\Models\Reserva;

class ControladorController extends Controller
{

    public function index()
    {
        $controladores = Controlador::with('user')->get();
        return view('admin.controlador.index', compact('controladores'));
        // return response()->json($controladores);
    }

    public function show(string $id)
    {
        $controlador = Controlador::with('user')->find($id);
        return view('admin.controlador.show', compact('controlador'));
    }

    public function accesoQr($reserva_id, $deportista_id)
    {
        $reserva = Reserva::findOrFail($reserva_id);
        $deportista = Deportista::findOrFail($deportista_id);

        $participante = $reserva->participantes()->where('deportista_id', $deportista_id)->first();
        if (!$participante) {
            return redirect()->back()
                ->with('mensaje', 'Participante no encontrado en esta reserva')
                ->with('icono', 'error');
        }
        if ($participante->pivot->ingreso) {
            return redirect()->back()
                ->with('mensaje', $deportista->user->nombres . ' ya ha ingresado anteriormente.')
                ->with('icono', 'warning');
        }
        $reserva->participantes()->updateExistingPivot($deportista_id, [
            'ingreso' => true,
            'fechaIngreso' => now()
        ]);
        return redirect()->back()
            ->with('mensaje', $deportista->user->nombres . ' ingresó correctamente.')
            ->with('icono', 'success');
    }

}
