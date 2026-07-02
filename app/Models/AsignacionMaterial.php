<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionMaterial extends Model
{
    protected $table = 'asignaciones_material';

    // 🔥 Agregamos que la llave primaria ahora es el 'id' único que creamos
    protected $primaryKey = 'id';

    // Definimos los campos que se pueden llenar masivamente
    protected $fillable = [
        'id_material', 
        'id_grupo', 
        'fecha_asignacion',
        'nivel_riesgo', 
        'prioridad'
    ];

    // Desactivamos timestamps si no usas created_at/updated_at
    public $timestamps = false; 

    /**
     * Relación con el Material de Apoyo
     * Argumentos: Modelo, llave foránea en esta tabla, llave primaria en la tabla material
     */
    // app/Models/AsignacionMaterial.php

public function material() {
    // El 2do parámetro es la columna en ESTA tabla (id_material)
    // El 3er parámetro es la columna en la tabla MATERIALES (id)
    return $this->belongsTo(MaterialApoyo::class, 'id_material', 'id'); 
}

public function grupo() {
    // Haz lo mismo para el grupo si tu tabla grupos también usa 'id'
    return $this->belongsTo(Grupo::class, 'id_grupo', 'id');
}
}