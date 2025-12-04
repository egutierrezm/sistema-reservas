<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Deportista;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeportistaController extends Controller
{

    public function index()
    {
        // $deportistas = Deportista::with('user')->orderBy('id', 'desc')->get();
        // return response()->json($deportistas);
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('ADMINISTRADOR DE ESPACIOS')) {
            $espaciosIds = $user->administradorEspacio->espaciosDeportivos->pluck('id');
            $canchasIds = Cancha::whereIn('espacio_deportivo_id', $espaciosIds)->pluck('id');
            $deportistasIds = Reserva::whereIn('cancha_id', $canchasIds)->pluck('deportista_id')->unique();
            $deportistas = Deportista::with('user')
                                    ->whereIn('id', $deportistasIds)
                                    ->orderBy('id', 'desc')
                                    ->get();

        } else {
            $deportistas = Deportista::with('user')
                                    ->orderBy('id', 'desc')
                                    ->get();
        }
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
