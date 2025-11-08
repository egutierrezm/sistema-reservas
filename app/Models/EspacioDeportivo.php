<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EspacioDeportivo extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nombre',
        'direccion',
        'descripcion',
        'horaApertura',
        'horaCierre',
        'administrador_espacio_id',
    ];
    
    public function canchas():HasMany
    {
        return $this->hasMany(Cancha::class);
    }

    public function administradorEspacio():BelongsTo
    {
        return $this->belongsTo(AdministradorEspacio::class);
    }

}
