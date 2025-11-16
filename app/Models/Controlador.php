<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Controlador extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function canchas():BelongsToMany
    {
        return $this->belongsToMany(Cancha::class)
                    ->withPivot('fechaAsignacion', 'turnoAsignado')
                    ->withTimestamps();
    }
    
}
