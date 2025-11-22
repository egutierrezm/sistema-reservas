<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cancha extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'precioxhora',
        'imgcancha',
        'espacio_deportivo_id',
    ];

    public function espacioDeportivo():BelongsTo
    {
        return $this->belongsTo(EspacioDeportivo::class);
    }

    public function disciplinaDeportivas():BelongsToMany{
        return $this->belongsToMany(DisciplinaDeportiva::class);
    }

    public function reservas():HasMany {
        return $this->hasMany(Reserva::class);
    }

    public function controladores():BelongsToMany
    {
        return $this->belongsToMany(Controlador::class)
                    ->withPivot('fechaAsignacion', 'turnoAsignado')
                    ->withTimestamps();
    }

    public function valoraciones():HasMany
    {
        return $this->hasMany(Valoracion::class);
    }

}
