<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaDiagnostico extends Model
{
    protected $table = 'respuestas_diagnostico';

    // Desactivamos los timestamps si tu tabla NO tiene created_at y updated_at
    // Si tu tabla SÍ los tiene (como se veía en tu foto), borra esta línea:
    // public $timestamps = false; 

    protected $fillable = [
        'id_diagnostico',
        'id_pregunta',
        'id_opcion'
    ];
}