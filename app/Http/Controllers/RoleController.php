<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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

    public function permiso(string $id){
        $role = Role::find($id);
        $permisos = Permission::all()->groupBy(function($permiso){
            $name = $permiso->name;
            if (stripos($name, 'ajuste') !== false) { return 'Ajustes'; }
            if (stripos($name, 'role') !== false) { return 'Roles'; }
            if (stripos($name, 'user') !== false) { return 'Usuarios'; }
            if (stripos($name, 'espacioDeportivo') !== false) { return 'Espacios Deportivos'; }
            if (stripos($name, 'disciplinaDeportiva') !== false) { return 'Disciplinas Deportivas'; }
            if (stripos($name, 'cancha') !== false) { return 'Canchas'; }
            if (stripos($name, 'administradorEspacio') !== false) { return 'Administrador de Espacios'; }
            if (stripos($name, 'deportista') !== false) { return 'Deportistas'; }
            if (stripos($name, 'reserva') !== false) { return 'Reservas'; }
            if (stripos($name, 'pago') !== false) { return 'Pagos'; }
            if (stripos($name, 'codigoQr') !== false) { return 'Codigos QR'; }
            if (stripos($name, 'cancelacion') !== false) { return 'Cancelaciones'; }
            if (stripos($name, 'controlador') !== false) { return 'Controladores'; }
            if (stripos($name, 'asignacion') !== false) { return 'Asignar canchas'; }
            if (stripos($name, 'valoracion') !== false) { return 'Valorar canchas'; }
            if (stripos($name, 'invitacion') !== false) { return 'Invitacion reservas'; }
        });
        return view('admin.role.permiso',compact('role', 'permisos'));
    }

    public function updatePermiso(Request $request, string $id){
        $role = Role::find($id);
        $role->permissions()->sync($request->permisos);
        return redirect()->route('admin.role.index')
        ->with('mensaje', 'Permisos asignados correctamente')
        ->with('icono', 'success');
    }

}
