<?php

namespace App\Http\Controllers;

use App\Models\Instrumento;
use App\Models\Pregunta; // Necesitarás crear este modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumentoController extends Controller
{
    public function index()
{
    // Agregamos withCount para que cuente las preguntas relacionadas
    $instrumentos = Instrumento::withCount('preguntas')
        ->orderBy('id_cuestionario', 'desc')
        ->get();

    return view('tutor_instrumentos', compact('instrumentos'));
}

    public function create() {
        return view('tutor_instrumentos_crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'preguntas' => 'required|array'
        ]);

        \DB::transaction(function() use ($request) {
            // 1. Creamos el cuestionario con los campos de tu DB
            $instrumento = Instrumento::create([
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
                'version'     => '1.0', // Valor inicial
                'activo'      => 1      // 1 para activo
            ]);

            // 2. Guardamos las preguntas
            foreach ($request->preguntas as $index => $datosPregunta) {
                Pregunta::create([
                    'id_cuestionario' => $instrumento->id_cuestionario, 
                    'texto_pregunta'  => $datosPregunta['texto'],
                    'tipo_respuesta'  => $datosPregunta['tipo'],
                    'orden'           => $index + 1
                ]);
            }
        });

        return redirect()->route('tutor.instrumentos')->with('success', '¡Instrumento creado con éxito!');
    }

    // Elimina un instrumento (cuestionario) de la base de datos
   public function destroy($id)
    {
        $instrumento = Instrumento::findOrFail($id);

        \DB::transaction(function() use ($instrumento) {
            // 1. Buscamos los IDs de las preguntas de este cuestionario
            $preguntasIds = \DB::table('preguntas')
                ->where('id_cuestionario', $instrumento->id_cuestionario)
                ->pluck('id_pregunta');

            // 2. Borramos las respuestas de diagnóstico de esas preguntas
            \DB::table('respuestas_diagnostico')->whereIn('id_pregunta', $preguntasIds)->delete();

            // 3. Borramos las sesiones de diagnóstico del cuestionario (EL ERROR DE LA IMAGEN 3)
            \DB::table('sesiones_diagnostico')->where('id_cuestionario', $instrumento->id_cuestionario)->delete();

            // 4. Borramos las preguntas del cuestionario
            \DB::table('preguntas')->where('id_cuestionario', $instrumento->id_cuestionario)->delete();

            // 5. Finalmente, borramos el cuestionario
            $instrumento->delete();
        });

        return redirect()->route('tutor.instrumentos')->with('success', '¡Instrumento y datos relacionados eliminados con éxito!');
    }

    // Muestra el formulario con los datos actuales
public function edit($id)
{
    // Cargamos el instrumento con sus preguntas gracias a la relación que pusimos en el modelo
    $instrumento = Instrumento::with('preguntas')->findOrFail($id);
    return view('tutor_instrumentos_editar', compact('instrumento'));
}

// Procesa los cambios
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required',
        'descripcion' => 'required',
        'preguntas' => 'required|array'
    ]);

    \DB::transaction(function() use ($request, $id) {
        // 1. Actualizamos los datos básicos del cuestionario
        $instrumento = Instrumento::findOrFail($id);
        $instrumento->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        // 2. Limpiamos las preguntas anteriores para evitar duplicados o basura
        \DB::table('preguntas')->where('id_cuestionario', $id)->delete();

        // 3. Insertamos las preguntas actuales (modificadas, nuevas o las mismas)
        foreach ($request->preguntas as $index => $datosPregunta) {
            Pregunta::create([
                'id_cuestionario' => $id,
                'texto_pregunta'  => $datosPregunta['texto'],
                'tipo_respuesta'  => $datosPregunta['tipo'],
                'orden'           => $index + 1
            ]);
        }
    });

    return redirect()->route('tutor.instrumentos')->with('success', '¡Instrumento actualizado con éxito!');
}
}