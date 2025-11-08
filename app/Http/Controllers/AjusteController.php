<?php

namespace App\Http\Controllers;

use App\Models\Ajuste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AjusteController extends Controller
{
    public function index()
    {
        $ajuste = Ajuste::first();
        return view('admin.ajuste.index',compact('ajuste'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());

        $ajuste = Ajuste::first();
        $rules = [
            'nombre'=>'required',
            'descripcion'=>'required',
            'sucursal'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'correo'=>'required|email',
        ];
        if(!$ajuste || !$ajuste->logo)
            $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg';
        else
            $rules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg';
        $request->validate($rules);

        if(!$ajuste)
            $ajuste = new Ajuste();
        $ajuste->nombre = $request->nombre;
        $ajuste->descripcion = $request->descripcion;
        $ajuste->sucursal = $request->sucursal;
        $ajuste->direccion = $request->direccion;
        $ajuste->telefono = $request->telefono;
        $ajuste->correo = $request->correo;
        if($request->hasFile('logo')){
            if ($ajuste->logo && Storage::disk('public')->exists('logos/' . $ajuste->logo)) {
                Storage::disk('public')->delete('logos/' . $ajuste->logo);
            }
            $logoPath = $request->file('logo')->store('logos','public');
            $ajuste->logo = basename($logoPath);
        }
        $ajuste->save();
        return redirect()->back()->with('mensaje', 'Ajuste guardado correctamente')->with('icono', 'success');

    }

    public function show(Ajuste $ajuste)
    {
        //
    }

    public function edit(Ajuste $ajuste)
    {
        //
    }

    public function update(Request $request, Ajuste $ajuste)
    {
        //
    }

    public function destroy(Ajuste $ajuste)
    {
        //
    }
}
