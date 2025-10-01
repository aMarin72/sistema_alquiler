<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table = 'contratos';

    protected $fillable = [
        'propiedad_id',
        'inquilino_id',
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'estado',
    ];

    // Relaciones, un contrato pertenece a una propiedad
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }

    // Relaciones, un contrato pertenece a un inquilino
    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class);
    }
}
