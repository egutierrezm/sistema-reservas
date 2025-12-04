<?php

namespace App\Http\Controllers;

use App\Models\Deportista;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DeportistaReservaController extends Controller
{
    public function index(){
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('DEPORTISTA')) {
            $deportistas = Deportista::with([
                'reservaParticipadas.cancha',
                'reservaParticipadas.disciplina'
            ])->where('id', $user->deportista->id)
              ->get();
        } else {
            $deportistas = Deportista::with([
                'reservaParticipadas.cancha',
                'reservaParticipadas.disciplina'
            ])->get();
        }
        // return response()->json($deportistas);
        return view('admin.invitacion.index', compact('deportistas'));

    }

    public function qrAcceso(Request $request)
    {
        $reservaId = $request->query('reserva') ?? $request->query('reserva_id');
        if (!$reservaId) {
            abort(404, 'Reserva no especificada');
        }
        if (Auth::check()) {
            $user = Auth::user();
            $deportista = $user->deportista;
            if (!$deportista) {
                abort(403, 'Usuario no es deportista');
            }
            $reserva = Reserva::findOrFail($reservaId);
            if (!$reserva->participantes->contains($deportista->id)) {
                $this->agregarParticipante($reserva, $deportista);
            }
            return redirect()->route('admin.index')->with('mensaje', 'Acceso a reserva registrado correctamente.');
        }
        $request->session()->put('reserva_id', $reservaId);
        return redirect()->route('login');
    }

    private function agregarParticipante(Reserva $reserva, Deportista $deportista)
    {
        $urlAcceso = route('admin.controlAcceso', [
            'reserva_id' => $reserva->id,
            'deportista_id' => $deportista->id
        ]);
        $qrFileName = 'qrs/ingreso_reserva_'.$reserva->id.'_dep_'.$deportista->id.'.png';
        $qr = QrCode::format('png')->size(300)->generate($urlAcceso);
        Storage::disk('public')->put($qrFileName, $qr);
        $reserva->participantes()->attach($deportista->id, [
            'ingreso' => false,
            'fechaIngreso' => null,
            'qr_image' => $qrFileName
        ]);
    }

}
