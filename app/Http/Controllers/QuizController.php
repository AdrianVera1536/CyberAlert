<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\RespuestaQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function guardar(Request $request)
    {
        // 1. Validar que las 10 preguntas estén contestadas
        $request->validate([
            'q1' => 'required', 'q2' => 'required', 'q3' => 'required',
            'q4' => 'required', 'q5' => 'required', 'q6' => 'required',
            'q7' => 'required', 'q8' => 'required', 'q9' => 'required',
            'q10' => 'required',
        ], [
            'required' => 'Por favor, responde todas las preguntas antes de enviar.',
        ]);

        // 2. Diccionario de respuestas correctas
        $correctas = [
            1 => 'c', 2 => 'b', 3 => 'a', 4 => 'c', 5 => 'b',
            6 => 'a', 7 => 'b', 8 => 'a', 9 => 'a', 10 => 'b'
        ];

        // 3. Calificar el Quiz
        $aciertos = 0;
        for ($i = 1; $i <= 10; $i++) {
            if ($request->input('q' . $i) == $correctas[$i]) {
                $aciertos++;
            }
        }

        // Calcular la calificación final (cada acierto vale 10 puntos)
        $calificacion_final = $aciertos * 10;

        // 4. Guardar en la tabla principal de Quizzes
        $nuevoQuiz = Quiz::create([
            'id_persona' => Auth::id(),
            'calificacion' => $calificacion_final
        ]);

        // 5. Guardar cada respuesta individual en la tabla respuestas_quiz
        for ($i = 1; $i <= 10; $i++) {
            RespuestaQuiz::create([
                'id_quiz' => $nuevoQuiz->id,
                'id_pregunta' => $i,
                'respuesta' => $request->input('q' . $i)
            ]);
        }

        // 6. Redirigir a "Ver Resultados" enviando la calificación
        return redirect()->route('estudiante.resultados')->with('success_quiz', '¡Quiz completado! Tu calificación es: ' . $calificacion_final . '/100');
    }
}