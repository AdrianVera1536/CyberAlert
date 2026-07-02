<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;     // Asegúrate de agregar esta línea
use Illuminate\Support\Facades\File;   // Asegúrate de agregar esta línea

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Escuchar todas las consultas de MySQL
        DB::listen(function ($query) {
            $fecha = now()->format('Y-m-d H:i:s');
            // Formateamos el log: [Fecha] [Tiempo de respuesta ms] Consulta SQL
            $log = "[$fecha] [{$query->time} ms] {$query->sql} \n";
            
            // Lo guardamos en storage/logs/mysql.log
            File::append(storage_path('logs/mysql.log'), $log);
        });
    }
}