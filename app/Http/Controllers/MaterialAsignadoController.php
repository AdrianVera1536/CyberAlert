<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMaterial;
use App\Models\MaterialApoyo;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MaterialAsignadoController extends Controller
{
    // 1. VISTA PRINCIPAL: Listado de materiales asignados
    public function index()
    {
        // Traemos las asignaciones con sus relaciones para evitar muchas consultas a la BD
        $asignaciones = AsignacionMaterial::with(['material', 'grupo'])->get();
        
        // Usamos el nombre de la vista directo si no usaste carpetas
        return view('material_asignado_index', compact('asignaciones'));
    }

    // 2. VISTA CREAR: Formulario para nueva asignación
    public function create()
    {
        $grupos = Grupo::all(); 
        $materiales = MaterialApoyo::all();
        
        return view('material_asignado_crear', compact('grupos', 'materiales'));
    }

    // 3. GUARDAR: Procesa la nueva asignación
    public function store(Request $request)
{
    $request->validate([
        'id_grupo' => 'required',
        'id_material' => 'required',
        'nivel_riesgo' => 'required',
        'prioridad' => 'required'
    ]);

    // 🔥 MAGIA: Si ya existe el par (grupo/material), actualiza el riesgo y prioridad.
    // Si no existe, crea uno nuevo.
    AsignacionMaterial::updateOrCreate(
        [
            'id_grupo' => $request->id_grupo,
            'id_material' => $request->id_material
        ],
        [
            'nivel_riesgo' => $request->nivel_riesgo,
            'prioridad' => $request->prioridad,
            'fecha_asignacion' => now()
        ]
    );

    return redirect()->route('tutor.material.index')->with('success', '¡Asignación procesada correctamente!');
}

    // 4. VISTA EDITAR: Carga los datos de una asignación existente
    public function edit($id_material, $id_grupo)
    {
        // Buscamos la asignación específica por su llave compuesta
        $asignacion = AsignacionMaterial::where('id_material', $id_material)
            ->where('id_grupo', $id_grupo)
            ->firstOrFail();

        $grupos = Grupo::all();
        $materiales = MaterialApoyo::all();

        return view('material_asignado_editar', compact('asignacion', 'grupos', 'materiales'));
    }

    // 5. ACTUALIZAR: Procesa los cambios en la asignación
    public function update(Request $request, $id_material, $id_grupo)
{
    $request->validate([
        'nivel_riesgo' => 'required',
        'prioridad' => 'required',
    ]);

    // Buscamos la asignación específica para obtener su 'id' único
    $asignacion = AsignacionMaterial::where('id_material', $id_material)
        ->where('id_grupo', $id_grupo)
        ->firstOrFail();

    // Actualizamos solo lo que el tutor puede cambiar
    $asignacion->update([
        'nivel_riesgo' => $request->nivel_riesgo,
        'prioridad' => $request->prioridad,
        'fecha_asignacion' => now()
    ]);

    return redirect()->route('tutor.material.index')->with('success', '¡Asignación actualizada con éxito!');
}

    // 6. ELIMINAR: Quita la asignación
    public function destroy($id_material, $id_grupo)
    {
        AsignacionMaterial::where('id_material', $id_material)
            ->where('id_grupo', $id_grupo)
            ->delete();

        return redirect()->route('tutor.material.index')->with('success', 'La asignación ha sido eliminada.');
    }
}