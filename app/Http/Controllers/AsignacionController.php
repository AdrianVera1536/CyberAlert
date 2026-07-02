<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignacionController extends Controller
{
    /**
     * Muestra la pantalla de asignación con la lista de grupos y tutores.
     */
    public function index()
    {
        // 1. Obtenemos todos los grupos para el selector
        $grupos = Grupo::all();

        // 2. Obtenemos solo a las personas que tienen el rol de Tutor (ID 3)
        $tutores = Persona::where('id_rol', 3)->get();

        // 3. Consultamos la lista de grupos con el nombre de su tutor asignado (si tienen)
        // Usamos grupos.id porque así se llama tu llave primaria en la BD
        $gruposConTutor = DB::table('grupos')
            ->leftJoin('personas', 'grupos.id_tutor', '=', 'personas.id')
            ->select(
                'grupos.id', 
                'grupos.nombre', 
                'grupos.id_tutor', // 🔥 IMPORTANTE: Necesario para el @if en la vista
                'personas.nombre as tutor_nombre',
                'personas.apellidos as tutor_apellidos'
            )
            ->get();

        return view('directivo_asignar', compact('grupos', 'tutores', 'gruposConTutor'));
    }

    /**
     * Crea o actualiza la vinculación de un tutor con un grupo.
     */
    public function store(Request $request)
    {
        // Validamos que lleguen ambos IDs
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id',
            'id_tutor' => 'required|exists:personas,id'
        ]);

        // Buscamos el grupo por su ID real
        $grupo = Grupo::find($request->id_grupo);
        
        // Asignamos el ID del tutor
        $grupo->id_tutor = $request->id_tutor;
        $grupo->save();

        return back()->with('success', '¡El tutor ha sido vinculado al grupo exitosamente!');
    }

    /**
     * Elimina la vinculación (pone el id_tutor en NULL).
     */
    public function destroy($id)
    {
        // Buscamos el grupo por el ID que viene de la tabla
        $grupo = Grupo::find($id);

        if ($grupo) {
            // Desvinculamos al tutor sin borrar el registro del grupo ni de la persona
            $grupo->id_tutor = null;
            $grupo->save();
            
            return back()->with('success', 'Se ha quitado el tutor del grupo correctamente.');
        }

        return back()->with('error', 'No se encontró el grupo solicitado.');
    }
}