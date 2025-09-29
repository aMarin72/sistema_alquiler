<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    /** @use HasFactory<\Database\Factories\PropiedadFactory> */
    use HasFactory;

    protected $table = 'propiedads';

    protected $fillable = [
        'tipo',
        'direccion',
        'precio',
        'descripcion',
        'estado',
    ];
}
