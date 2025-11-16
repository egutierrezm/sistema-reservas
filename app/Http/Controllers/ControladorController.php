<?php

namespace App\Http\Controllers;

use App\Models\Controlador;

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

}
