<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumento extends Model
{
    protected $table = 'cuestionarios'; // Nombre real en tu DB
    protected $primaryKey = 'id_cuestionario'; // Llave primaria real
    public $timestamps = false; // Tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'nombre', 
        'descripcion', // Ahora sí existirá
        'version',
        'activo'
    ];

    // Dentro de la clase Instrumento
public function preguntas()
{
    // Argumentos: Modelo relacionado, llave foránea en preguntas, llave local en cuestionarios
    return $this->hasMany(Pregunta::class, 'id_cuestionario', 'id_cuestionario');
}
}