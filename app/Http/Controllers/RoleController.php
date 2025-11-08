<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name'
        ]);
        $rol = new Role();
        $rol->name = strtoupper($request->name);
        $rol->save();

        return redirect()->route('admin.role.index')
        ->with('mensaje', 'Rol registrado correctamente')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        $role = Role::find($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,'.$id,'id',
        ]);
        $role->name = strtoupper($request->name);
        $role->save();
        return redirect()->route('admin.role.index')
        ->with('mensaje', 'Rol modificado correctamente')
        ->with('icono', 'success');
    }

    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('admin.role.index')
        ->with('mensaje', 'Rol eliminado correctamente')
        ->with('icono', 'success');
    }
}
