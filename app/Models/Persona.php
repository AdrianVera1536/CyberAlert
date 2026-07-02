<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\AuditaMovimientos;

class Persona extends Authenticatable
{
    use AuditaMovimientos;

    protected $table = 'personas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre', 'apellidos', 'email', 'password_hash', 'id_rol', 'id_institucion', 'telefono', 'niveles_riesgo'
    ];

    // ESTO ES LO QUE TE ESTÁ FALLANDO
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}