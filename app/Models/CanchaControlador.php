<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanchaControlador extends Model
{
    protected $table = 'cancha_controlador';
    protected $fillable = [
        'cancha_id',
        'controlador_id',
        'fechaAsignacion',
        'turnoAsignado',
    ];

    public function cancha():BelongsTo
    {
        return $this->belongsTo(Cancha::class);
    }

    public function controlador():BelongsTo
    {
        return $this->belongsTo(Controlador::class);
    }

}
