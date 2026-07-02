<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo; 
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Muestra la vista inicial con el selector de grupos
     */
    public function index()
    {
        $grupos = Grupo::all();
        return view('reporte_index', compact('grupos')); 
    }

    /**
     * Procesa la selección y genera los datos de la gráfica
     */
    public function generar(Request $request)
    {
        // 🛠️ TIP DE DEBUG: Si sigue fallando, quita las // de la línea de abajo y recarga.
        // Verás una pantalla negra con los datos que llegan. Busca "id_grupo".
        // dd($request->all());

        // Validamos que el ID del grupo realmente llegue
        $request->validate([
            'id_grupo' => 'required'
        ], [
            'id_grupo.required' => 'Debes seleccionar un grupo de la lista para continuar.'
        ]);

        $grupos = Grupo::all();
        
        // Buscamos el grupo por su llave primaria (sea id o id_grupo)
        $grupoSeleccionado = Grupo::find($request->id_grupo);

        // --- LÓGICA PARA DATOS REALES (PRÓXIMO PASO) ---
        // Aquí contaremos cuántos alumnos del grupo tienen cada nivel de riesgo.
        // Por ahora mantenemos estos para que la gráfica cargue al pasar la validación.
        $datosGrafica = [
            'bajo' => 15,
            'medio' => 8,
            'alto' => 3
        ];

        return view('reporte_index', compact('grupos', 'grupoSeleccionado', 'datosGrafica'));
    }
}