<?php

namespace App\Http\Controllers;

use App\Models\CodigoQr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CodigoQrController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if ($roles->contains('DEPORTISTA')) {
            $codigos = CodigoQr::with([
                'reserva.deportista.user',
                'reserva.cancha',
                'reserva.participantes.user'
            ])->whereHas('reserva', function($query) use ($user) {
                $query->where('deportista_id', $user->deportista->id);
            })->get();
        } else {
            $codigos = CodigoQr::with([
                'reserva.deportista.user',
                'reserva.cancha',
                'reserva.participantes.user'
            ])->get();
        }
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

    public function download($id)
    {
        $codigo = CodigoQr::findOrFail($id);

        if (!Storage::disk('public')->exists($codigo->qrimage)) {
            return redirect()->back()->with('error', 'Archivo QR no encontrado.');
        }

        $svg = Storage::disk('public')->get($codigo->qrimage);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="QR_'.$codigo->reserva_id.'.svg"');
    }

}
