<?php

namespace App\Http\Controllers;

use App\Models\CodigoQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodigoQrController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('DEPORTISTA')) {
            $codigos = CodigoQr::with([
                'reserva.deportista.user',
                'reserva.cancha',
                'reserva.participantes.user'
            ])->whereHas('reserva', function($query) use ($user) {
                $query->where('deportista_id', $user->deportista->id);
            })->get();
        } else {
            $codigos = CodigoQr::with([
                'reserva.deportista.user',
                'reserva.cancha',
                'reserva.participantes.user'
            ])->get();
        }
        return view('admin.codigoQr.index', compact('codigos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CodigoQr $codigoQr)
    {
        //
    }

    public function edit(CodigoQr $codigoQr)
    {
        //
    }

    public function update(Request $request, CodigoQr $codigoQr)
    {
        //
    }

    public function destroy(CodigoQr $codigoQr)
    {
        //
    }
}
