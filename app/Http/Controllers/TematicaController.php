<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tematica; // Asegúrate de tener este modelo
use Illuminate\Support\Facades\DB;

class TematicaController extends Controller
{
    // Muestra la lista y el formulario
    public function index()
    {
        $tematicas = Tematica::all(); 
        return view('directivo_tematicas', compact('tematicas'));
    }

    // Guarda una nueva temática
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|unique:tematicas,nombre',
        'descripcion' => 'nullable|string'
    ]);
    
    Tematica::create($request->all());

    return back()->with('success', '¡Temática guardada!');
}

public function update(Request $request)
{
    // 🔥 CAMBIO AQUÍ: Validamos 'nuevo_nombre' porque así se llama en el HTML
    $request->validate([
        'id' => 'required|exists:tematicas,id',
        'nuevo_nombre' => 'required|string|max:255' 
    ]);

    // Buscamos la temática por el ID que viene del select
    $tematica = Tematica::find($request->id);
    
    // Actualizamos usando el valor de 'nuevo_nombre'
    $tematica->update([
        'nombre' => $request->nuevo_nombre
    ]);

    return back()->with('success', '¡Nombre actualizado correctamente!');
}

public function destroy(Request $request)
{
    $request->validate([
        'id_tematica' => 'required|exists:tematicas,id'
    ]);

    // 1. Buscamos el registro
    $tematica = Tematica::find($request->id_tematica);

    // 2. 🔥 ESTE ES EL TRUCO: forceDelete() lo borra físicamente de la tabla
    $tematica->forceDelete(); 

    return back()->with('success', '¡Temática eliminada permanentemente de la base de datos!');
}
}