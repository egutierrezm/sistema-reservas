<?php

namespace App\Http\Controllers;

use App\Models\Cancelacion;
use Illuminate\Http\Request;

class CancelacionController extends Controller
{

    public function index()
    {
        $cancelaciones = Cancelacion::with([
            'reserva.cancha',
            'deportista.user'
        ])->orderBy('fechaCancelacion', 'desc')->get();
        return view('admin.cancelacion.index', compact('cancelaciones'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
