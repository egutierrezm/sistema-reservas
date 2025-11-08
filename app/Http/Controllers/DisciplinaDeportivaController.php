<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaDeportiva;
use Illuminate\Http\Request;

class DisciplinaDeportivaController extends Controller
{
    public function index()
    {
        $disciplinaDeportivas = DisciplinaDeportiva::all();
        // return response()->json($disciplinaDeportivas);
        return view('admin.disciplinaDeportiva.index', compact('disciplinaDeportivas'));
    }

    public function create()
    {
        return view('admin.disciplinaDeportiva.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:disciplina_deportivas,nombre',
            'descripcion' => 'required|string|max:255',
        ]);

        $disciplinaDeportiva = new DisciplinaDeportiva();
        $disciplinaDeportiva->nombre = $request->nombre;
        $disciplinaDeportiva->descripcion = $request->descripcion;
        $disciplinaDeportiva->save();
        return redirect()->route('admin.disciplinaDeportiva.index')
        ->with('mensaje', '¡Disciplina deportiva registrado correctamente!')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        $disciplinaDeportiva = DisciplinaDeportiva::find($id);
        // return response()->json($disciplinaDeportiva);
        return view('admin.disciplinaDeportiva.show', compact('disciplinaDeportiva'));
    }

    public function edit(string $id)
    {
        $disciplinaDeportiva = DisciplinaDeportiva::find($id);
        return view('admin.disciplinaDeportiva.edit', compact('disciplinaDeportiva'));
    }

    public function update(Request $request, string $id)
    {
        $disciplinaDeportiva = DisciplinaDeportiva::find($id);
        $request->validate([
            'nombre' => 'required|string|max:100|unique:disciplina_deportivas,nombre',
            'descripcion' => 'required|string|max:255',
        ]);
        $disciplinaDeportiva->nombre = $request->nombre;
        $disciplinaDeportiva->descripcion = $request->descripcion;
        $disciplinaDeportiva->save();
        return redirect()->route('admin.disciplinaDeportiva.index')
        ->with('mensaje', '¡Disciplina deportiva actualizado correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $disciplinaDeportiva = disciplinaDeportiva::find($id);
        // return response()->json($disciplinaDeportiva);
        $disciplinaDeportiva->delete();
        return redirect()->route('admin.disciplinaDeportiva.index')
        ->with('mensaje', '¡Disciplina deportiva eliminado correctamente!')
        ->with('icono', 'success');
    }

}
