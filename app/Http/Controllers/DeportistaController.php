<?php

namespace App\Http\Controllers;

use App\Models\Deportista;
use Illuminate\Http\Request;

class DeportistaController extends Controller
{

    public function index()
    {
        $deportistas = Deportista::with('user')->get();
        // return response()->json($deportistas);
        return view('admin.deportista.index', compact('deportistas'));
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
        $deportista = Deportista::with('user')->find($id);
        return view('admin.deportista.show', compact('deportista'));
    }

    public function edit(string $id)
    {
        $deportista = Deportista::with('user')->find($id);
        return view('admin.deportista.edit', compact('deportista'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'club' => 'nullable|string|max:50',
        ]);
        $deportista = Deportista::find($id);
        $deportista->club = $request->club;
        $deportista->save();
        return redirect()->route('admin.deportista.index')
        ->with('mensaje', '¡Club actualizado correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        //
    }

}
