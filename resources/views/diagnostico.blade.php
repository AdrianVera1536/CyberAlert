<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Diagnóstico | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC;
            --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; right: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; background: transparent; cursor: pointer; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; font-weight: 600;}
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 800px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        .progress-container { width: 100%; height: 8px; background: rgba(64, 104, 130, 0.1); border-radius: 10px; margin-bottom: 40px; overflow: hidden; }
        .progress-bar { height: 100%; width: 4.5%; background: linear-gradient(90deg, var(--ambar), var(--verde-azulado)); border-radius: 10px; transition: width 0.5s ease; }

        .question-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); transition: all 0.3s ease; }
        .question-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }

        .question-title { font-size: 1.2rem; font-weight: 600; color: var(--azul-profundo); margin-bottom: 25px; display: flex; gap: 15px; }
        .q-number { width: 35px; height: 35px; background: var(--verde-azulado); color: var(--blanco); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0; }

        /* MODIFICADO A 4 COLUMNAS PARA LAS NUEVAS OPCIONES */
        .options-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; text-align: center; }
        .option-item { position: relative; }
        .option-item input[type="radio"] { display: none; }
        .option-item label { display: flex; flex-direction: column; align-items: center; gap: 10px; cursor: pointer; padding: 10px; border-radius: 15px; transition: all 0.3s ease; }
        .radio-circle { width: 24px; height: 24px; border: 2px solid var(--verde-azulado); border-radius: 50%; position: relative; transition: all 0.3s ease; }
        .radio-circle::after { content: ''; position: absolute; top: 50%; left: 50%; width: 12px; height: 12px; background: var(--ambar); border-radius: 50%; transform: translate(-50%, -50%) scale(0); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .option-label-text { font-size: 0.9rem; color: var(--texto-claro); font-weight: 500; }

        .option-item input[type="radio"]:checked + label .radio-circle { border-color: var(--ambar); }
        .option-item input[type="radio"]:checked + label .radio-circle::after { transform: translate(-50%, -50%) scale(1); }
        .option-item input[type="radio"]:checked + label .option-label-text { color: var(--azul-profundo); font-weight: 700; }
        .option-item:hover label { background: rgba(64, 104, 130, 0.05); }

        .actions { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-top: 40px; margin-bottom: 30px; }
        .btn-regresar { flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 15px 20px; border-radius: 50px; font-weight: 700; font-size: 1.05rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; text-align: center; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-enviar { flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 15px 20px; border-radius: 50px; font-weight: 800; font-size: 1.05rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-align: center; }
        .btn-enviar svg { transition: transform 0.3s ease; }
        .btn-enviar:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; opacity: 1; }
        .btn-enviar:hover svg { transform: translateX(5px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        @media (max-width: 768px) { .options-grid { grid-template-columns: 1fr; text-align: left; gap: 15px; } .option-item label { flex-direction: row; } .actions { flex-direction: column-reverse; } .btn-regresar, .btn-enviar { width: 100%; } }
        
        .error-container { background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; font-weight: 600; border: 1px solid rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('estudiante.dashboard') }}">Inicio</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Realizar Diagnóstico</h1>
            <p>Responde las siguientes 22 preguntas con sinceridad. No hay respuestas correctas o incorrectas.</p>
        </div>

        <div class="progress-container">
            <div class="progress-bar" id="progressBar"></div>
        </div>

        @if ($errors->any())
            <div class="error-container">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('diagnostico.guardar') }}" method="POST">
            @csrf

            @php
                $preguntas = [
                    "He percibido mensajes o llamadas que me han generado una sensación de burla o agresión.",
                    "He experimentado situaciones de presión digital mediante amenazas para obligarme a actuar contra mi voluntad.",
                    "He recibido contenido o mensajes intimidatorios que afectan mi sensación de seguridad o confianza personal.",
                    "He tenido conocimiento de que se difunde información no verificada o rumores sobre mi persona mediante mensajes o llamadas.",
                    "He percibido que mi privacidad ha sido comprometida al divulgarse secretos o información personal sin mi consentimiento.",
                    "Se ha realizado la difusión de contenido multimedia (fotos o videos) personales en red sin mi autorización previa.",
                    "He recibido llamadas de origen desconocido o silenciosas que perturban mi tranquilidad.",
                    "He sido expuesto a contenido digital explícito u obsceno que me ha generado incomodidad.",
                    "He percibido insultos o comentarios en redes sociales o foros que buscan ridiculizarme públicamente.",
                    "He identificado indicios de acceso no autorizado a mis cuentas o intentos de uso indebido de mi identidad digital.",
                    "Se han hecho pasar por mí en internet para realizar acciones que dañan mi reputación (suplantación de identidad).",
                    "He percibido una exclusión intencional de grupos o comunidades digitales que son importantes para mi vida académica y social.",
                    "Mis interacciones en plataformas digitales influyen frecuentemente de manera negativa en mi estado de ánimo.",
                    "He experimentado una sensación de aislamiento social vinculada a mis experiencias en el entorno digital.",
                    "Considero que mi participación en redes sociales suele ser una fuente constante de estrés o tensión emocional.",
                    "Siento inquietud o temor al revisar mis notificaciones digitales por miedo a encontrar contenido emocionalmente adverso.",
                    "Mi descanso nocturno se ha visto alterado por preocupaciones relacionadas con situaciones ocurridas en línea.",
                    "Mi capacidad de concentración en las tareas universitarias se ve afectada por pensamientos sobre conflictos en mis redes sociales.",
                    "Considero que mi desempeño académico (calificaciones) se ha visto comprometido a causa del estrés derivado del acoso digital.",
                    "En momentos de tensión digital, he sentido que mi motivación por los estudios o mi deseo de permanecer en la carrera se ven disminuidos.",
                    "He optado por limitar mi participación en foros o clases virtuales para evitar posibles interacciones desagradables o burlas.",
                    "He notado que las tensiones en redes sociales dificultan mi colaboración efectiva en trabajos grupales."
                ];
            @endphp

            @foreach ($preguntas as $index => $pregunta)
                @php $num = $index + 1; @endphp
                <div class="question-card">
                    <div class="question-title"><div class="q-number">{{ $num }}</div><p>{{ $pregunta }}</p></div>
                    <div class="options-grid">
                        <div class="option-item">
                            <input type="radio" id="q{{ $num }}-1" name="q{{ $num }}" value="nunca" required>
                            <label for="q{{ $num }}-1"><div class="radio-circle"></div><span class="option-label-text">Nunca</span></label>
                        </div>
                        <div class="option-item">
                            <input type="radio" id="q{{ $num }}-2" name="q{{ $num }}" value="pocas-veces">
                            <label for="q{{ $num }}-2"><div class="radio-circle"></div><span class="option-label-text">Pocas Veces</span></label>
                        </div>
                        <div class="option-item">
                            <input type="radio" id="q{{ $num }}-3" name="q{{ $num }}" value="muchas-veces">
                            <label for="q{{ $num }}-3"><div class="radio-circle"></div><span class="option-label-text">Muchas Veces</span></label>
                        </div>
                        <div class="option-item">
                            <input type="radio" id="q{{ $num }}-4" name="q{{ $num }}" value="siempre">
                            <label for="q{{ $num }}-4"><div class="radio-circle"></div><span class="option-label-text">Siempre</span></label>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="actions">
                <a href="{{ route('estudiante.dashboard') }}" class="btn-regresar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Regresar
                </a>

                <button type="submit" class="btn-enviar">
                    Enviar respuestas
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </button>
            </div>
        </form>
    </div>
    
    <script>
        const form = document.querySelector('form');
        const progressBar = document.getElementById('progressBar');
        const totalQuestions = 22;

        form.addEventListener('change', () => {
            const answered = document.querySelectorAll('input[type="radio"]:checked').length;
            const percentage = (answered / totalQuestions) * 100;
            progressBar.style.width = percentage + '%';
        });
    </script>
</body>
</html>