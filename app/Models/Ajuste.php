<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'sucursal',
        'telefono',
        'direccion',
        'correo',
        'logo'
    ];
}
