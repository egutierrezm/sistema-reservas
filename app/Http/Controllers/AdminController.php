<?php

namespace App\Http\Controllers;

use App\Models\EspacioDeportivo;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index(){
        $totalRoles = Role::count();
        $totalUsers = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'ADMINISTRADOR');
        })->withTrashed()->count();
        $totalEspacios = EspacioDeportivo::count();
        return view('admin.index', compact('totalRoles', 'totalUsers', 'totalEspacios'));
    }
}
