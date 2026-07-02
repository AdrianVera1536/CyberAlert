<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialApoyo extends Model
{
    // 🔥 Cambia 'material_apoyo' por 'materiales_apoyo'
    protected $table = 'materiales_apoyo'; 
    
    // Asegúrate de que este ID también coincida con tu tabla
    protected $primaryKey = 'id'; 

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'url_recurso'
    ];
}