<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\RegistroUserMail;
use App\Models\AdministradorEspacio;
use App\Models\Controlador;
use App\Models\Deportista;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'ADMINISTRADOR');
        })->withTrashed()->get();
        // return response()->json($usuarios);
        return view('admin.user.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // return response()->json($request->all());
        $request->validate([
            'rol' => 'required|exists:roles,name',
            'email' => 'required|email|max:255|unique:users,email',
            'tipoDocumento' => 'required|in:CI,CIE,Pasaporte',
            'nroDocumento' => 'required|string|max:20|unique:users,nroDocumento',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fechaNaci' => 'required|date|before:today',
            'celular' => 'required|string|max:20',
            'genero' => 'required|in:Masculino,Femenino',
        ]);
        $numerosAleatorios = substr(str_shuffle("0123456789"), 0, 4);
        $passwordTemporal = $request->nombres . $numerosAleatorios;
        $apellidosArray = explode(' ', $request->apellidos);
        $iniciales = '';
        foreach ($apellidosArray as $apellido) {
            $iniciales = $iniciales . Str::lower(substr($apellido, 0, 1));
        }
        $nombre = Str::lower($request->nombres);
        $nick = $iniciales . $nombre;

        $usuario = new User();
        $usuario->name = $nick;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($passwordTemporal);
        $usuario->tipoDocumento = $request->tipoDocumento;
        $usuario->nroDocumento = $request->nroDocumento;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->fechaNaci = $request->fechaNaci;
        $usuario->celular = $request->celular;
        $usuario->genero = $request->genero;
        $usuario->save();
        Mail::to($usuario->email)->send(new RegistroUserMail($usuario, $passwordTemporal));
        $usuario->assignRole($request->rol);

        //Administrador de Espacios
        if ($request->rol === 'ADMINISTRADOR DE ESPACIOS') {
            AdministradorEspacio::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        }

        //Deportista
        if ($request->rol === 'DEPORTISTA') {
            Deportista::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        }

        //Controlador
        if ($request->rol === 'CONTROLADOR') {
            Controlador::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        }

        return redirect()->route('admin.user.index')
        ->with('mensaje', '¡Usuario registrado correctamente! Hemos enviado una contraseña al correo del usuario')
        ->with('icono', 'success');
    }

    public function show(string $id)
    {
        // echo $id;
        $usuario = User::find($id);
        // return response()->json($usuario);
        return view('admin.user.show', compact('usuario'));
    }

    public function edit(string $id)
    {
        // echo $id;
        $usuario = User::find($id);
        $roles = Role::all();
        return view('admin.user.edit', compact('usuario', 'roles'));
        
    }

    public function update(Request $request, string $id)
    {
        // return response()->json($request->all());
        $usuario = User::find($id);
        $request->validate([
            'rol' => 'required|exists:roles,name',
            'email' => 'required|email|max:255|unique:users,email,'.$id.',id',
            'tipoDocumento' => 'required|in:CI,CIE,Pasaporte',
            'nroDocumento' => 'required|string|max:20|unique:users,nroDocumento,'.$id.',id',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fechaNaci' => 'required|date|before:today',
            'celular' => 'required|string|max:20',
            'genero' => 'required|in:Masculino,Femenino',
        ]);
        $apellidosArray = explode(' ', $request->apellidos);
        $iniciales = '';
        foreach ($apellidosArray as $apellido) {
            $iniciales = $iniciales . Str::lower(substr($apellido, 0, 1));
        }
        $nombre = Str::lower($request->nombres);
        $nick = $iniciales . $nombre;

        $usuario->name = $nick;
        $usuario->email = $request->email;
        $usuario->tipoDocumento = $request->tipoDocumento;
        $usuario->nroDocumento = $request->nroDocumento;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->fechaNaci = $request->fechaNaci;
        $usuario->celular = $request->celular;
        $usuario->genero = $request->genero;
        $usuario->save();

        $usuario->syncRoles($request->rol);

        // Administrador de Espacios
        if ($request->rol === 'ADMINISTRADOR DE ESPACIOS') {
            AdministradorEspacio::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        } else {
            $usuario->administradorEspacio?->delete();
        }

        // Deportista
        if ($request->rol === 'DEPORTISTA') {
            Deportista::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        } else {
            $usuario->deportista?->delete();
        }

        // Controlador
        if ($request->rol === 'CONTROLADOR') {
            Controlador::firstOrCreate([
                'user_id' => $usuario->id,
            ]);
        } else {
            $usuario->controlador?->delete();
        }

        return redirect()->route('admin.user.index')
        ->with('mensaje', '¡Usuario actualizado correctamente!')
        ->with('icono', 'success');

    }

    public function destroy(string $id)
    {
        // echo $id;
        // echo Auth::user()->id;
        $usuario = User::find($id);
        if($usuario->id == Auth::user()->id){
            return redirect()->back()
            ->with('mensaje', 'No puedes eliminar tu propia cuenta')
            ->with('icono', 'error');
        }else{
            $usuario->estado = false;
            $usuario->save();
            $usuario->delete();
            return redirect()->route('admin.user.index')
            ->with('mensaje', '¡Usuario eliminado correctamente!')
            ->with('icono', 'success');
        }
    }

    public function restore(string $id){
        // echo $id;
        $usuario = User::withTrashed()->findOrFail($id);
        $usuario->estado = true;
        $usuario->save();
        $usuario->restore();

        return redirect()->route('admin.user.index')
            ->with('mensaje', '¡Usuario restaurado correctamente!')
            ->with('icono', 'success');
    }

    public function perfil(){
        $roles = Role::all();
        $usuario = User::find(Auth::user()->id);
        return view('admin.user.perfil', compact('roles', 'usuario'));
    }

    public function actualizarPerfil(Request $request){
        // return response()->json($request->all());
        $usuario = User::find($request->id);
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,'.$request->id.',id',
            'tipoDocumento' => 'required|in:CI,CIE,Pasaporte',
            'nroDocumento' => 'required|string|max:20|unique:users,nroDocumento,'.$request->id.',id',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fechaNaci' => 'required|date|before:today',
            'celular' => 'required|string|max:20',
            'genero' => 'required|in:Masculino,Femenino',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'passwordActual' => 'nullable|string',
            'passwordNuevo' => 'nullable|string|min:8|required_with:passwordActual',
            'passwordConfirmacion' => 'nullable|string|same:passwordNuevo|required_with:passwordNuevo',
        ]);
        $apellidosArray = explode(' ', $request->apellidos);
        $iniciales = '';
        foreach ($apellidosArray as $apellido) {
            $iniciales = $iniciales . Str::lower(substr($apellido, 0, 1));
        }
        $nombre = Str::lower($request->nombres);
        $nick = $iniciales . $nombre;

        // Guardamos los datos del request
        $usuario->name = $nick;
        $usuario->email = $request->email;
        $usuario->tipoDocumento = $request->tipoDocumento;
        $usuario->nroDocumento = $request->nroDocumento;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->fechaNaci = $request->fechaNaci;
        $usuario->celular = $request->celular;
        $usuario->genero = $request->genero;
        if($request->hasFile('foto')){
            if ($usuario->foto && Storage::disk('public')->exists('fotos/' . $usuario->foto)) {
                Storage::disk('public')->delete('fotos/' . $usuario->foto);
            }
            $fotoPath = $request->file('foto')->store('fotos','public');
            $usuario->foto = basename($fotoPath);
        }
        if($request->filled('passwordActual')){
            if(!password_verify($request->passwordActual, $usuario->password)){
                return redirect()->back()
                ->with('mensaje', 'La contraseña actual es incorrecta')
                ->with('icono', 'error');
            }else{
                $usuario->password = $request->passwordNuevo;
            }
        }
        $usuario->save();


        return redirect()->back()
        ->with('mensaje', '¡Perfil actualizado correctamente!')
        ->with('icono', 'success');

    }

}
