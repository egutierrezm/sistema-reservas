<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cancelacion extends Model
{
    protected $fillable = [
        'motivo',
        'fechaCancelacion',
        'reserva_id',
        'deportista_id'
    ];

     public function reserva():BelongsTo{
        return $this->belongsTo(Reserva::class);
    }

    public function deportista():BelongsTo{
        return $this->belongsTo(Deportista::class);
    }

}
