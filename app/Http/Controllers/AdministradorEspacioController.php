<?php

namespace App\Http\Controllers;

use App\Models\AdministradorEspacio;
use Illuminate\Http\Request;

class AdministradorEspacioController extends Controller
{

    public function index()
    {
        $administradores = AdministradorEspacio::with('user')->get();
        // return response()->json($administradores);
        return view('admin.administradorEspacio.index', compact('administradores'));
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
        $administrador = AdministradorEspacio::with('user')->find($id);
        return view('admin.administradorEspacio.show', compact('administrador'));
    }

    public function edit(string $id)
    {
        $administrador = AdministradorEspacio::with('user')->find($id);
        return view('admin.administradorEspacio.edit', compact('administrador'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'turno' => 'required|in:Mañana,Tarde,Noche',
            'descripcion' => 'nullable|string|max:500',
        ]);
        $administrador = AdministradorEspacio::find($id);
        $administrador->turno = $request->turno;
        $administrador->descripcion = $request->descripcion;
        $administrador->save();
        return redirect()->route('admin.administradorEspacio.index')
        ->with('mensaje', '¡Administrador de espacio actualizado correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        //
    }

}
