<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\CodigoQr;
use App\Models\Deportista;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ReservaController extends Controller
{

    public function index()
    {
        $reservas = Reserva::with([
            'deportista.user',
            'cancha.disciplinaDeportivas'
        ])->get();
        return view('admin.reserva.index', compact('reservas'));
        // return response()->json($reservas);
    }

    public function create()
    {
        $deportistas = Deportista::with('user')->get();
        $canchas = Cancha::with('disciplinaDeportivas')->get();
        return view('admin.reserva.create', compact('deportistas', 'canchas'));
        // return response()->json($canchaDisciplinaDeportivas);
    }

    public function store(Request $request)
    {
        // return response()->json($request);
        $request->validate([
            'deportista_id' => 'required|exists:deportistas,id',
            'cancha_id' => 'required|exists:canchas,id',
            'fechaReserva' => 'required|date',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:deportistas,id',
        ]);
        $reserva = new Reserva();
        $reserva->deportista_id = $request->deportista_id;
        $reserva->cancha_id = $request->cancha_id;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaInicio = $request->horaInicio;
        $reserva->horaFin = $request->horaFin;
        $reserva->estado = $request->estado;
        $reserva->save();

        $reserva->participantes()->sync($request->participantes ?? []);

        // Generar codigo QR de la reserva
        $contenido = "Numero de reserva: {$reserva->id}\n".
                     "Cancha: {$reserva->cancha->nombre}\n".
                     "Fecha: {$reserva->fechaReserva}\n".
                     "Hora: {$reserva->horaInicio} - {$reserva->horaFin}\n".
                     "Cliente: {$reserva->deportista->user->nombres} {$reserva->deportista->user->apellidos}";
        
        $qr = QrCode::format('svg')->size(250)->generate($contenido);
        $nombreArchivo = 'qrs/QR_' . $reserva->id . '_' . Str::random(6) . '.svg';
        Storage::disk('public')->put($nombreArchivo, $qr);

        $codigoqr = new CodigoQr();
        $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        $codigoqr->qrimage = $nombreArchivo;
        $codigoqr->estado = 'activo';
        $codigoqr->reserva_id = $reserva->id;
        $codigoqr->save();

        return redirect()->route('admin.reserva.index')
        ->with('mensaje', '¡Reserva registrada correctamente!')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        $reserva = Reserva::with([
            'deportista.user',
            'cancha.disciplinaDeportivas',
            'participantes.user'
        ])->find($id);
        return view('admin.reserva.show', compact('reserva'));
    }

    public function edit(string $id)
    {
        $reserva = Reserva::find($id);
        $deportistas = Deportista::with('user')->get();
        $canchas = Cancha::with('disciplinaDeportivas')->get();
        return view('admin.reserva.edit', compact('reserva', 'deportistas', 'canchas'));
    }

    public function update(Request $request, string $id)
    {
        // return response()->json($request);
        $reserva = Reserva::find($id);
        $request->validate([
            'deportista_id' => 'required|exists:deportistas,id',
            'cancha_id' => 'required|exists:canchas,id',
            'fechaReserva' => 'required|date',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada',
            'participantes' => 'nullable|array',
            'participantes.*' => 'exists:deportistas,id',
        ]);
        $reserva->deportista_id = $request->deportista_id;
        $reserva->cancha_id = $request->cancha_id;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaInicio = $request->horaInicio;
        $reserva->horaFin = $request->horaFin;
        $reserva->estado = $request->estado;
        $reserva->save();

        $reserva->participantes()->sync($request->participantes ?? []);

        //Actualizar codigo QR de la reserva
        $codigoqr = CodigoQr::where('reserva_id', $reserva->id)->first();
        if ($codigoqr) {
            Storage::disk('public')->delete($codigoqr->qrimage);
        } else {
            $codigoqr = new CodigoQr();
            $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        }

        $contenido = "Numero de reserva: {$reserva->id}\n".
                     "Cancha: {$reserva->cancha->nombre}\n".
                     "Fecha: {$reserva->fechaReserva}\n".
                     "Hora: {$reserva->horaInicio} - {$reserva->horaFin}\n".
                     "Cliente: {$reserva->deportista->user->nombres} {$reserva->deportista->user->apellidos}";

        $qr = QrCode::format('svg')->size(250)->generate($contenido);
        $nombreArchivo = 'qrs/QR_' . $reserva->id . '_' . Str::random(6) . '.svg';
        Storage::disk('public')->put($nombreArchivo, $qr);

        $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        $codigoqr->qrimage = $nombreArchivo;
        $codigoqr->estado = 'activo';
        $codigoqr->reserva_id = $reserva->id;
        $codigoqr->save();

        return redirect()->route('admin.reserva.index')
        ->with('mensaje', '¡Reserva actualizada correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $reserva = Reserva::find($id);
        $reserva->participantes()->detach();
        $reserva->delete();
        return redirect()->route('admin.reserva.index')
        ->with('mensaje', '¡Reserva eliminada correctamente!')
        ->with('icono', 'success');
    }

    public function disponibilidad(Request $request)
    {
        $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date',
            'reserva_id' => 'nullable|exists:reservas,id'
        ]);
        
        $reservas = Reserva::where('cancha_id', $request->cancha_id)
            ->where('fechaReserva', $request->fecha)
            ->when($request->filled('reserva_id'), function ($query) use ($request) {
            $query->where('id', '!=', $request->reserva_id);
        })->get(['horaInicio', 'horaFin']);

        $bloques = [];
        for ($h = 8; $h < 20; $h++) {
            $inicio = Carbon::createFromTime($h, 0);
            $fin = Carbon::createFromTime($h + 1, 0);
            $ocupado = $reservas->contains(function ($r) use ($inicio, $fin) {
                $rInicio = Carbon::parse($r->horaInicio);
                $rFin = Carbon::parse($r->horaFin);
                return $rInicio < $fin && $rFin > $inicio;
            });
            $bloques[] = [
                'inicio' => $inicio->format('H:i'),
                'fin' => $fin->format('H:i'),
                'ocupado' => $ocupado
            ];
        }
        return response()->json($bloques);
    }

}
