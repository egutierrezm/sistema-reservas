<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Valoracion extends Model
{
    protected $fillable = [
        'cancha_id',
        'deportista_id',
        'puntos',
        'comentario',
    ];

    public function deportista():BelongsTo
    {
        return $this->belongsTo(Deportista::class);
    }

    public function cancha():BelongsTo
    {
        return $this->belongsTo(Cancha::class);
    }

}
