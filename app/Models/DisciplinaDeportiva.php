<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisciplinaDeportiva extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function canchas():BelongsToMany{
        return $this->belongsToMany(Cancha::class);
    }

    public function reservas():HasMany{
        return $this->hasMany(Reserva::class);
    }

}
