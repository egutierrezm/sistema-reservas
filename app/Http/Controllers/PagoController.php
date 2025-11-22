<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('DEPORTISTA')) {
            $pagos = Pago::with('reserva.cancha', 'reserva.deportista.user')
                ->whereHas('reserva', function($query) use ($user) {
                    $query->where('deportista_id', $user->deportista->id);
                })
                ->orderBy('fechaPago', 'desc')
                ->get();
        } else {
            $pagos = Pago::with('reserva.cancha', 'reserva.deportista.user')
                ->orderBy('fechaPago', 'desc')
                ->get();
        }

        return view('admin.pago.index', compact('pagos'));
        // return response()->json($pagos);
    }

    public function create(string $id)
    {
        $reserva = Reserva::with('cancha', 'pagos')->find($id);
        return view('admin.pago.create', compact('reserva'));
    }

    public function store(Request $request, string $id)
    {
        $reserva = Reserva::find($id);

        $request->validate([
            'monto' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|max:50',
            'fechaPago' => 'required|date',
        ]);

        Pago::create([
            'reserva_id' => $reserva->id,
            'monto' => $request->monto,
            'metodo' => $request->metodo,
            'fechaPago' => $request->fechaPago,
        ]);

        // ✅ Actualizar estado automáticamente (opcional)
        $totalPagado = $reserva->pagos()->sum('monto') + $request->monto;
        $precioTotal = $reserva->cancha->precioxhora;

        if ($totalPagado >= $precioTotal) {
            $reserva->estado = 'Confirmada'; // ✅ Totalmente pagada
        } elseif ($totalPagado > 0) {
            $reserva->estado = 'Pendiente'; // ✅ Parcialmente pagada, pero seguimos usando Pendiente
        } else {
            $reserva->estado = 'Pendiente'; // ✅ Sin pagos
        }
        $reserva->save();

        return redirect()->route('admin.reserva.show', $reserva->id)
        ->with('mensaje', 'Pago registrado correctamente')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

}
