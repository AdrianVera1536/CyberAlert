<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id_pregunta';
    
    // 🔥 ESTA ES LA LÍNEA QUE FALTA:
    public $timestamps = false; 

    protected $fillable = [
        'id_cuestionario',
        'texto_pregunta',
        'tipo_respuesta',
        'orden'
    ];
}