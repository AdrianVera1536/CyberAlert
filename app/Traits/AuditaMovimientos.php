<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AuditaMovimientos
{
    public static function bootAuditaMovimientos()
    {
        // Espía cuando se CREA un registro
        static::created(function ($model) {
            self::registrarBitacora($model, 'INSERT');
        });

        // Espía cuando se ACTUALIZA un registro
        static::updated(function ($model) {
            self::registrarBitacora($model, 'UPDATE');
        });

        // Espía cuando se ELIMINA un registro
        static::deleted(function ($model) {
            self::registrarBitacora($model, 'DELETE');
        });
    }

    protected static function registrarBitacora($model, $accion)
    {
        // 1. Le preguntamos a MariaDB/MySQL qué usuario de red está ejecutando la consulta
        $dbUserQuery = DB::select('SELECT CURRENT_USER() as db_user');
        $dbUser = $dbUserQuery[0]->db_user;

        // 2. Buscamos quién es el usuario logueado en el sistema web (Aplicación)
        $appUser = Auth::check() ? Auth::user()->nombre : 'Sistema / Seeder';

        // 3. Combinamos ambos datos para dejar feliz al profe
        $autor_final = $appUser . ' (DB: ' . $dbUser . ')';

        DB::table('bitacora_movimientos')->insert([
            'nombre_tabla' => $model->getTable(),
            'accion' => $accion,
            'usuario' => $autor_final, // <-- Aquí guardamos la combinación
            // Convertimos todos los datos de la fila a JSON automáticamente
            'detalles' => json_encode($model->getAttributes(), JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}