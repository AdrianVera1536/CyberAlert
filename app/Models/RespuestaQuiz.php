<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaQuiz extends Model
{
    protected $table = 'respuestas_quiz';
    protected $fillable = ['id_quiz', 'id_pregunta', 'respuesta'];
}