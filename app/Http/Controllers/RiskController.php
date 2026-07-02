<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 🔥 Usaremos DB para esta tabla

class RiskController extends Controller
{
   public function resumen()
{
    // Calculamos el total de alumnos por categoría sumando todas las carreras
    $datos = DB::table('resultados_procesados')->selectRaw('
        SUM(total_estudiantes * (pct_riesgo_bajo / 100)) as bajo,
        SUM(total_estudiantes * (pct_riesgo_medio / 100)) as medio,
        SUM(total_estudiantes * (pct_riesgo_alto / 100)) as alto
    ')->first();

    $counts = [
        'bajo'  => $datos->bajo ?? 0,
        'medio' => $datos->medio ?? 0,
        'alto'  => $datos->alto ?? 0,
    ];

    return view('directivo_resumen', compact('counts'));
}
}