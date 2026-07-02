<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    // 🔥 Asegúrate de que este sea el nombre real de tu tabla en phpMyAdmin
    protected $table = 'grupos'; 
    
    // 🔥 Y que esta sea su llave primaria
    protected $primaryKey = 'id'; 

    public $timestamps = false;

    protected $fillable = ['nombre', 'id_tutor'];
}