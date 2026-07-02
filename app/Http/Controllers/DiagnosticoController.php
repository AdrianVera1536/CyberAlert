<?php

namespace App\Http\Controllers;

use App\Models\RespuestaDiagnostico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticoController extends Controller
{
    public function guardar(Request $request)
    {
        // 1. Validar dinámicamente que las 22 preguntas hayan sido respondidas
        // Usamos un ciclo para no escribir 'q1' => 'required' 22 veces
        $reglas = [];
        for ($i = 1; $i <= 22; $i++) {
            $reglas['q' . $i] = 'required';
        }

        $request->validate($reglas, [
            'required' => 'Por favor, responde todas las preguntas (1 al 22) antes de enviar.',
        ]);

        // 2. Traductor: Convertir el texto del HTML a los números para tu BD (Escala de 1 a 4)
        $valores = [
            'nunca'        => 1,
            'pocas-veces'  => 2,
            'muchas-veces' => 3,
            'siempre'      => 4
        ];

        // 3. Tomar el ID del estudiante logueado
        $id_estudiante = Auth::id();

        // 4. Ciclo para guardar las 22 respuestas
        for ($i = 1; $i <= 22; $i++) {
            
            // Obtenemos qué contestó en la pregunta actual (q1, q2, q3...)
            $respuesta_texto = $request->input('q' . $i);

            // Guardamos en tu tabla `respuestas_diagnostico`
            RespuestaDiagnostico::create([
                'id_diagnostico' => $id_estudiante,
                'id_pregunta'    => $i,
                'id_opcion'      => $valores[$respuesta_texto] // El número de la opción (1 al 4)
            ]);
        }

        // 5. Redirigir al Dashboard de estudiante con el mensaje de éxito
        return redirect()->route('estudiante.dashboard')->with('success', '¡Diagnóstico completado y guardado correctamente!');
    }

    public function resultados()
    {
        $id_estudiante = Auth::id();

        // 1. Buscar las respuestas del estudiante en la base de datos
        $respuestas = \App\Models\RespuestaDiagnostico::where('id_diagnostico', $id_estudiante)->get();

        // Si no ha hecho el diagnóstico, lo mandamos a hacerlo
        if ($respuestas->isEmpty()) {
            return redirect()->route('estudiante.diagnostico')->withErrors(['msg' => 'Debes realizar el diagnóstico primero para ver tus resultados.']);
        }

        // 2. Calcular el puntaje (Sumar todos los 'id_opcion')
        // Mínimo posible: 22 (todas en "nunca"). Máximo posible: 88 (todas en "siempre").
        $puntajeTotal = $respuestas->sum('id_opcion');

        // 3. Convertir el puntaje a un porcentaje (de 0% a 100%)
        // Fórmula: (Puntaje obtenido - Puntaje Mínimo) / (Puntaje Máximo - Puntaje Mínimo) * 100
        $porcentajeRiesgo = (($puntajeTotal - 22) / (88 - 22)) * 100;

        // 4. Determinar la etiqueta de riesgo y color (Los rangos de porcentaje se mantienen iguales)
        $etiquetaRiesgo = 'Bajo Riesgo';
        $colorRiesgo = 'var(--verde-azulado)'; // Verde

        if ($porcentajeRiesgo >= 40 && $porcentajeRiesgo < 70) {
            $etiquetaRiesgo = 'Riesgo Moderado';
            $colorRiesgo = 'var(--ambar)'; // Naranja
        } elseif ($porcentajeRiesgo >= 70) {
            $etiquetaRiesgo = 'Alto Riesgo';
            $colorRiesgo = '#e74c3c'; // Rojo
        }

        // 5. Buscar la última calificación del Quiz de este estudiante
        $ultimoQuiz = \App\Models\Quiz::where('id_persona', $id_estudiante)->latest()->first();
        $calificacion_quiz = $ultimoQuiz ? $ultimoQuiz->calificacion : null;

        // 6. Mandar los datos calculados a la vista
        return view('resultados', [
            'porcentaje'        => round($porcentajeRiesgo),
            'etiqueta'          => $etiquetaRiesgo,
            'color'             => $colorRiesgo,
            'calificacion_quiz' => $calificacion_quiz
        ]);
    }
}