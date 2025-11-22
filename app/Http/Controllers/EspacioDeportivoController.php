<?php

namespace App\Http\Controllers;

use App\Models\AdministradorEspacio;
use App\Models\EspacioDeportivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EspacioDeportivoController extends Controller
{

    public function index()
    {
        // $espacioDeportivos = EspacioDeportivo::all();
        // return response()->json($espacioDeportivos);
        $espacioDeportivos = EspacioDeportivo::with('administradorEspacio.user')->get();
        return view('admin.espacioDeportivo.index', compact('espacioDeportivos'));
    }

    public function create()
    {
        $administradores = AdministradorEspacio::with('user')->get();
        return view('admin.espacioDeportivo.create', compact('administradores'));
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string',
            'descripcion' => 'required|string',
            'horaApertura' => 'required|date_format:H:i',
            'horaCierre' => 'required|date_format:H:i',
            'imgespacio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'administrador_espacio_id' => 'required|exists:administrador_espacios,id'
        ]);

        $espacioDeportivo = new EspacioDeportivo();
        $espacioDeportivo->nombre = $request->nombre;
        $espacioDeportivo->direccion = $request->direccion;
        $espacioDeportivo->descripcion = $request->descripcion;
        $espacioDeportivo->horaApertura = $request->horaApertura;
        $espacioDeportivo->horaCierre = $request->horaCierre;
        if ($request->hasFile('imgespacio')) {
            $path = $request->file('imgespacio')->store('espacios', 'public');
            $espacioDeportivo->imgespacio = $path;
        }
        $espacioDeportivo->administrador_espacio_id = $request->administrador_espacio_id;
        $espacioDeportivo->save();
        return redirect()->route('admin.espacioDeportivo.index')
        ->with('mensaje', '¡Espacio deportivo registrado correctamente!')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        // echo $id;
        // $espacioDeportivo = EspacioDeportivo::find($id);
        // return response()->json($espacioDeportivo);
        $espacioDeportivo = EspacioDeportivo::with('administradorEspacio.user')->find($id);
        return view('admin.espacioDeportivo.show', compact('espacioDeportivo'));
    }

    public function edit(string $id)
    {
        // echo $id;
        // $espacioDeportivo = EspacioDeportivo::find($id);
        // return response()->json($espacioDeportivo);
        $espacioDeportivo = EspacioDeportivo::find($id);
        $administradores = AdministradorEspacio::with('user')->get();
        return view('admin.espacioDeportivo.edit', compact('espacioDeportivo', 'administradores'));
    }

    public function update(Request $request, string $id)
    {
        // return response()->json($request->all());
        $espacioDeportivo = EspacioDeportivo::find($id);
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string',
            'descripcion' => 'required|string',
            'horaApertura' => 'required|date_format:H:i',
            'horaCierre' => 'required|date_format:H:i',
            'imgespacio' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'administrador_espacio_id' => 'required|exists:administrador_espacios,id'
        ]);

        $espacioDeportivo->nombre = $request->nombre;
        $espacioDeportivo->direccion = $request->direccion;
        $espacioDeportivo->descripcion = $request->descripcion;
        $espacioDeportivo->horaApertura = $request->horaApertura;
        $espacioDeportivo->horaCierre = $request->horaCierre;
        if ($request->hasFile('imgespacio')) {
            if ($espacioDeportivo->imgespacio && Storage::disk('public')->exists($espacioDeportivo->imgespacio)) {
                Storage::disk('public')->delete($espacioDeportivo->imgespacio);
            }
            $path = $request->file('imgespacio')->store('espacios', 'public');
            $espacioDeportivo->imgespacio = $path;
        }
        $espacioDeportivo->administrador_espacio_id = $request->administrador_espacio_id;
        $espacioDeportivo->save();
        return redirect()->route('admin.espacioDeportivo.index')
        ->with('mensaje', '¡Espacio deportivo actualizado correctamente!')
        ->with('icono', 'success');

    }

    public function destroy(string $id)
    {
        $espacioDeportivo = EspacioDeportivo::find($id);
        // return response()->json($espacioDeportivo);
        if (!empty($espacioDeportivo->imgespacio) && Storage::disk('public')->exists($espacioDeportivo->imgespacio)) {
            Storage::disk('public')->delete($espacioDeportivo->imgespacio);
        }
        $espacioDeportivo->delete();
        return redirect()->route('admin.espacioDeportivo.index')
        ->with('mensaje', '¡Espacio deportivo eliminado correctamente!')
        ->with('icono', 'success');
    }

}
