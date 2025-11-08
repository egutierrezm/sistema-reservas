<?php

namespace App\Http\Controllers;

use App\Models\CodigoQr;
use Illuminate\Http\Request;

class CodigoQrController extends Controller
{

    public function index()
    {
        $codigos = CodigoQr::with('reserva.deportista.user', 'reserva.cancha')->get();
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
