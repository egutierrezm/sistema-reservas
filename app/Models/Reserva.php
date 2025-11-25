<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reserva extends Model
{
    protected $fillable = [
        'fechaReserva',
        'horaInicio',
        'horaFin',
        'estado',
        'deportista_id',
        'cancha_id',
        'disciplina_deportiva_id'
    ];

    public function deportista():BelongsTo{
        return $this->belongsTo(Deportista::class);
    }

    public function cancha():BelongsTo {
        return $this->belongsTo(Cancha::class);
    }

    public function disciplina():BelongsTo
    {
        return $this->belongsTo(DisciplinaDeportiva::class, 'disciplina_deportiva_id');
    }

    public function pagos():HasMany{
        return $this->hasMany(Pago::class);
    }

    public function participantes():BelongsToMany{
        return $this->belongsToMany(Deportista::class)
                    ->withPivot('ingreso', 'qr_image', 'fechaIngreso');
    }
    
    public function codigoQr():HasOne{
        return $this->hasOne(CodigoQr::class);
    }

    public function cancelacion(): HasOne{
        return $this->hasOne(Cancelacion::class);
    }

    public function estaPagada():bool
    {
        $montoTotal = $this->cancha->precioxhora;
        $totalPagado = $this->pagos()->sum('monto');

        return $totalPagado >= $montoTotal;
    }

}
