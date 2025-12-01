<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\DisciplinaDeportiva;
use App\Models\EspacioDeportivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CanchaController extends Controller
{

    public function index()
    {
        // $canchas = Cancha::all();
        // return response()->json($canchas);
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('ADMINISTRADOR DE ESPACIOS')) {
            $espaciosIds = $user->administradorEspacio->espaciosDeportivos->pluck('id');
            $canchas = Cancha::with(['espacioDeportivo', 'disciplinaDeportivas'])
                             ->whereIn('espacio_deportivo_id', $espaciosIds)
                             ->get();
        } else {
            $canchas = Cancha::with(['espacioDeportivo', 'disciplinaDeportivas'])->get();
        }
        return view('admin.cancha.index', compact('canchas'));
    }

    public function create()
    {
        $espacioDeportivos = EspacioDeportivo::all();
        $disciplinaDeportivas = DisciplinaDeportiva::all();
        return view('admin.cancha.create',compact('espacioDeportivos', 'disciplinaDeportivas'));
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'capacidad' => 'required|integer|min:1',
            'precioxhora' => 'required|numeric|min:0',
            'imgcancha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'espacio_deportivo_id' => 'required|exists:espacio_deportivos,id',
            'disciplinaDeportivas' => 'required|array',
            'disciplinaDeportivas.*' => 'exists:disciplina_deportivas,id'
        ]);

        $cancha = new Cancha();
        $cancha->nombre = $request->nombre;
        $cancha->descripcion = $request->descripcion;
        $cancha->capacidad = $request->capacidad;
        $cancha->precioxhora = $request->precioxhora;
        $cancha->espacio_deportivo_id = $request->espacio_deportivo_id;
        if ($request->hasFile('imgcancha')) {
            $path = $request->file('imgcancha')->store('canchas', 'public');
            $cancha->imgcancha = $path;
        }
        $cancha->save();
        $cancha->disciplinaDeportivas()->sync($request->disciplinaDeportivas);
        return redirect()->route('admin.cancha.index')
        ->with('mensaje', '¡Cancha registrada correctamente!')
        ->with('icono', 'success');
        
    }

    public function show(string $id)
    {
        $cancha = Cancha::with(['espacioDeportivo', 'disciplinaDeportivas'])->find($id);
        return view('admin.cancha.show', compact('cancha'));
    }

    public function edit(string $id)
    {
        $cancha = Cancha::find($id);
        $espacioDeportivos = EspacioDeportivo::all();
        $disciplinaDeportivas = DisciplinaDeportiva::all();
        return view('admin.cancha.edit', compact('cancha', 'espacioDeportivos', 'disciplinaDeportivas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'capacidad' => 'required|integer|min:1',
            'precioxhora' => 'required|numeric|min:0',
            'imgcancha' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'espacio_deportivo_id' => 'required|exists:espacio_deportivos,id',
            'disciplinaDeportivas' => 'required|array',
            'disciplinaDeportivas.*' => 'exists:disciplina_deportivas,id'
        ]);

        $cancha = Cancha::find($id);
        $cancha->nombre = $request->nombre;
        $cancha->descripcion = $request->descripcion;
        $cancha->capacidad = $request->capacidad;
        $cancha->precioxhora = $request->precioxhora;
        $cancha->espacio_deportivo_id = $request->espacio_deportivo_id;

        if ($request->hasFile('imgcancha')) {
            if ($cancha->imgcancha && Storage::disk('public')->exists($cancha->imgcancha)) {
                Storage::disk('public')->delete($cancha->imgcancha);
            }
            $path = $request->file('imgcancha')->store('canchas', 'public');
            $cancha->imgcancha = $path;
        }
        $cancha->save();
        $cancha->disciplinaDeportivas()->sync($request->disciplinaDeportivas);
        return redirect()->route('admin.cancha.index')
        ->with('mensaje', '¡Cancha actualizada correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $cancha = Cancha::find($id);
        if (!empty($cancha->imgcancha) && Storage::disk('public')->exists($cancha->imgcancha)) {
            Storage::disk('public')->delete($cancha->imgcancha);
        }
        $cancha->disciplinaDeportivas()->detach();
        $cancha->delete();
        return redirect()->route('admin.cancha.index')
        ->with('mensaje', '¡Cancha eliminada correctamente!')
        ->with('icono', 'success');
    }
    
}
