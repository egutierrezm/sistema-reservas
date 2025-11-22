<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deportista extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'club',
        'user_id'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function reservas():HasMany{
        return $this->hasMany(Reserva::class);
    }

    public function reservaParticipadas():BelongsToMany{
        return $this->belongsToMany(Reserva::class);
    }

    public function cancelaciones():HasMany{
        return $this->hasMany(Cancelacion::class);
    }

    public function valoraciones():HasMany
    {
        return $this->hasMany(Valoracion::class);
    }

}
