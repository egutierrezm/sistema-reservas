<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Deportista;
use App\Models\EspacioDeportivo;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if($roles->contains('DEPORTISTA')){
            $valoraciones = Valoracion::with([
                'deportista.user',
                'cancha'
            ])->orderByDesc('created_at')->where('deportista_id', $user->deportista->id)->get();
        }else{
            $valoraciones = Valoracion::with([
                'deportista.user',
                'cancha'
            ])->orderByDesc('created_at')->get();
        }
        return view('admin.valoracion.index', compact('valoraciones'));
    }

    public function create()
    {
        $espacios = EspacioDeportivo::all();
        $deportistas = Deportista::with('user')->get();
        return view('admin.valoracion.create', compact('espacios', 'deportistas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cancha_id'     => 'required|exists:canchas,id',
            'deportista_id' => 'required|exists:deportistas,id',
            'puntos'        => 'required|integer|min:1|max:5',
            'comentario'    => 'required|string|max:500',
        ]);
        $valoracion = new Valoracion();
        $valoracion->cancha_id = $request->cancha_id;
        $valoracion->deportista_id = $request->deportista_id;
        $valoracion->puntos = $request->puntos;
        $valoracion->comentario = $request->comentario;
        $valoracion->save();
        if ($request->ajax()) {
            return response()->json([
                'mensaje' => '¡Valoración registrada correctamente!',
                'icono' => 'success',
                'valoracion' => $valoracion
            ]);
        }
        return redirect()->route('admin.valoracion.index')
        ->with('mensaje', '¡Valoración registrada correctamente!')
        ->with('icono', 'success');
    }

    public function edit(string $id)
    {
        $valoracion = Valoracion::with(['deportista.user', 'cancha.espacioDeportivo'])->find($id);
        return view('admin.valoracion.edit', compact('valoracion'));
    }

    public function update(Request $request, string $id)
    {
        $valoracion = Valoracion::find($id);
        $request->validate([
            'puntos'     => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
        ]);

        $valoracion->puntos = $request->puntos;
        $valoracion->comentario = $request->comentario;
        $valoracion->save();
        if ($request->ajax()) {
            return response()->json([
                'mensaje' => '¡Valoración actualizada correctamente!',
                'icono' => 'success',
                'valoracion' => $valoracion
            ]);
        }
        return redirect()->route('admin.valoracion.index')
        ->with('mensaje', '¡Valoración actualizada correctamente!')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $valoracion = Valoracion::find($id);
        $valoracion->delete();
        return redirect()->route('admin.valoracion.index')
        ->with('mensaje', '¡Valoración eliminada correctamente!')
        ->with('icono', 'success');
    }

    public function getCanchasPorEspacio($id)
    {
        $canchas = Cancha::where('espacio_deportivo_id', $id)->get(['id', 'nombre']);
        return response()->json($canchas);
    }

    public function getComentariosPorCancha($id)
    {
        $valoraciones = Valoracion::where('cancha_id', $id)
            ->with('deportista.user')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('admin.deportistacomentarios', compact('valoraciones'));
    }

    public function getValoracionPorCancha($canchaId)
    {
        $user = Auth::user();
        $deportistaId = $user->deportista->id;
        $valoracion = Valoracion::where('cancha_id', $canchaId)
                        ->where('deportista_id', $deportistaId)
                        ->first();

        return response()->json([
            'valoracion' => $valoracion
        ]);
    }

}
