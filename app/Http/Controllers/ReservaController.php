<?php

namespace App\Http\Controllers;

use App\Mail\RegistroReservaMail;
use App\Models\Cancha;
use App\Models\CodigoQr;
use App\Models\Deportista;
use App\Models\EspacioDeportivo;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class ReservaController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('DEPORTISTA')) {
            $reservas = Reserva::with([
                'deportista.user',
                'cancha.disciplinaDeportivas',
                'disciplina'
            ])->where('deportista_id', $user->deportista->id)
              ->orderBy('created_at', 'desc')
              ->get();
        } else {
            $reservas = Reserva::with([
                'deportista.user',
                'cancha',
                'disciplina'
            ])->orderBy('created_at', 'desc')
              ->get();
            // return response()->json($reservas);
        }
        return view('admin.reserva.index', compact('reservas'));
    }

    public function create()
    {
        $deportistas = Deportista::with('user')->get();
        $canchas = Cancha::with('disciplinaDeportivas')->get();
        $espacios = EspacioDeportivo::all();
        return view('admin.reserva.create', compact('deportistas', 'canchas', 'espacios'));
        // return response()->json($canchaDisciplinaDeportivas);
    }

    public function store(Request $request)
    {
        // return response()->json($request);
        $request->validate([
            'deportista_id' => 'required|exists:deportistas,id',
            'cancha_id' => 'required|exists:canchas,id',
            'disciplina_id' => 'required|exists:disciplina_deportivas,id',
            'fechaReserva' => 'required|date',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada',
        ]);
        $reserva = new Reserva();
        $reserva->deportista_id = $request->deportista_id;
        $reserva->cancha_id = $request->cancha_id;
        $reserva->disciplina_deportiva_id = $request->disciplina_id;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaInicio = $request->horaInicio;
        $reserva->horaFin = $request->horaFin;
        $reserva->estado = $request->estado;
        $reserva->save();

        // Generar codigo QR de la reserva
        $urlRegistro = route('register', ['reserva' => $reserva->id]);
        $qr = QrCode::format('svg')->size(250)->generate($urlRegistro);
        $nombreArchivo = 'qrs/QR_' . $reserva->id . '_' . Str::random(6) . '.svg';
        Storage::disk('public')->put($nombreArchivo, $qr);

        $codigoqr = new CodigoQr();
        $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        $codigoqr->qrimage = $nombreArchivo;
        $codigoqr->estado = 'activo';
        $codigoqr->reserva_id = $reserva->id;
        $codigoqr->save();

        // Mail::to($reserva->deportista->user->email)->send(new RegistroReservaMail($reserva));

        return redirect()->route('admin.reserva.index')
        ->with('mensaje', '¡Reserva registrada correctamente! Se ha enviado el código QR de su reserva a su correo electrónico. Por favor, proceda con el pago para confirmar la reserva.')
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
        $espacios = EspacioDeportivo::all(); 
        return view('admin.reserva.edit', compact('reserva', 'deportistas', 'canchas', 'espacios'));
    }

    public function update(Request $request, string $id)
    {
        // return response()->json($request);
        $reserva = Reserva::find($id);

        if ($reserva->estado === 'Cancelada') {
            return redirect()->back()
            ->with('mensaje', 'No se puede modificar una reserva cancelada')
            ->with('icono', 'error');
        }

        $request->validate([
            'deportista_id' => 'required|exists:deportistas,id',
            'cancha_id' => 'required|exists:canchas,id',
            'disciplina_deportiva_id' => 'required|exists:disciplina_deportivas,id',
            'fechaReserva' => 'required|date',
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i|after:horaInicio',
            'estado' => 'required|string|in:Pendiente,Confirmada,Cancelada',
        ]);
        $reserva->deportista_id = $request->deportista_id;
        $reserva->cancha_id = $request->cancha_id;
        $reserva->disciplina_deportiva_id = $request->disciplina_deportiva_id;
        $reserva->fechaReserva = $request->fechaReserva;
        $reserva->horaInicio = $request->horaInicio;
        $reserva->horaFin = $request->horaFin;
        $reserva->estado = $request->estado;
        $reserva->save();

        //Actualizar codigo QR de la reserva
        $codigoqr = CodigoQr::where('reserva_id', $reserva->id)->first();
        if ($codigoqr) {
            Storage::disk('public')->delete($codigoqr->qrimage);
        } else {
            $codigoqr = new CodigoQr();
            $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        }

        $urlRegistro = route('register', ['reserva' => $reserva->id]);
        $qr = QrCode::format('svg')->size(250)->generate($urlRegistro);
        $nombreArchivo = 'qrs/QR_' . $reserva->id . '_' . Str::random(6) . '.svg';
        Storage::disk('public')->put($nombreArchivo, $qr);

        $codigoqr->codigo = 'QR' . $reserva->id . Str::random(6);
        $codigoqr->qrimage = $nombreArchivo;
        $codigoqr->estado = 'activo';
        $codigoqr->reserva_id = $reserva->id;
        $codigoqr->save();

        // Mail::to($reserva->deportista->user->email)->send(new RegistroReservaMail($reserva));

        return redirect()->route('admin.reserva.index')
        ->with('mensaje', '¡Reserva actualizada correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $reserva = Reserva::find($id);

        if ($reserva->estado === 'Cancelada') {
            return redirect()->back()
            ->with('mensaje', 'No se puede eliminar una reserva cancelada')
            ->with('icono', 'error');
        }

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
            ->where('estado', '!=', 'Cancelada') // <--- agregar esta línea
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

    public function cancelarReserva(Request $request, string $id){

        $reserva = Reserva::with('deportista', 'codigoQr')->findOrFail($id);

        if ($reserva->fechaReserva < now()->toDateString()) {
            return redirect()->back()
            ->with('mensaje', 'No se puede cancelar una reserva pasada')
            ->with('icono', 'error');
        }

        if ($reserva->estado === 'Cancelada') {
            return redirect()->back()
            ->with('mensaje', 'La reserva ya fue cancelada')
            ->with('icono', 'warning');
        }

        $reserva->estado = 'Cancelada';
        $reserva->save();
        $reserva->cancelacion()->create([
            'motivo' => $request->motivo ?? 'Cancelacion por parte del deportista',
            'fechaCancelacion' => now(),
            'deportista_id' => $reserva->deportista_id,
        ]);

        if ($reserva->codigoQr) {
            $reserva->codigoQr->estado = 'expirado';
            $reserva->codigoQr->save();
        }

        return redirect()->back()
        ->with('mensaje', 'Reserva cancelada correctamente')
        ->with('icono', 'success');
    }

    public function getCanchasPorEspacio($id)
    {
        $canchas = Cancha::where('espacio_deportivo_id', $id)->get(['id', 'nombre']);
        return response()->json($canchas);
    }

    public function getDisciplinasPorCancha($id)
    {
        $cancha = Cancha::with('disciplinaDeportivas')->find($id);
        return response()->json($cancha->disciplinaDeportivas);
    }

}
