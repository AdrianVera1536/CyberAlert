<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 🔥 Importante para deleted_at
use App\Traits\AuditaMovimientos;

class Tematica extends Model
{
    use AuditaMovimientos;

    use SoftDeletes; // 🔥 Activamos el borrado lógico

    protected $table = 'tematicas';

    // Tu captura muestra que la llave es 'id', así que Laravel lo entiende por defecto.
    // No hace falta declarar $primaryKey si se llama 'id'.

    protected $fillable = [
        'nombre', 
        'descripcion' // 🔥 Agregamos descripción que sale en tu captura
    ];
}