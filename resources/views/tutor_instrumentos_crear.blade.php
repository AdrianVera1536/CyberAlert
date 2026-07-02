<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseñar Instrumento | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5);
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B;
            --color-morado-btn: #9b59b6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; right: -10%; bottom: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        /* --- TARJETA DEL CONSTRUCTOR --- */
        .builder-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; color: var(--azul-profundo); margin-bottom: 8px; font-size: 1.1rem; }
        .form-control { width: 100%; padding: 15px; border: 2px solid rgba(64, 104, 130, 0.15); border-radius: 12px; background: rgba(255, 255, 255, 0.9); font-size: 1rem; color: var(--texto-oscuro); transition: all 0.3s ease; outline: none; }
        .form-control:focus { border-color: var(--verde-azulado); }

        /* --- BLOQUE DE PREGUNTAS --- */
        .question-block { background: var(--blanco); padding: 25px; border-radius: 20px; border: 1px solid rgba(64, 104, 130, 0.1); margin-bottom: 25px; position: relative; animation: fadeIn 0.5s ease; transition: all 0.3s ease; }
        .question-block:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.05); transform: translateY(-3px); }
        .question-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .question-number { background: var(--verde-azulado); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }
        .btn-remove-q { color: #ef4444; cursor: pointer; background: none; border: none; transition: 0.3s; }
        .btn-remove-q:hover { transform: scale(1.2); }

        .btn-add-question { width: 100%; padding: 15px; border: 2px dashed var(--verde-azulado); border-radius: 15px; color: var(--verde-azulado); font-weight: 700; cursor: pointer; background: transparent; transition: 0.3s; margin-bottom: 30px; }
        .btn-add-question:hover { background: rgba(64, 104, 130, 0.05); border-style: solid; }

        /* --- BOTONES DE ACCIÓN (ESTILO VISTAS ANTERIORES) --- */
        .actions { display: flex; justify-content: space-between; align-items: center; gap: 30px; margin-top: 30px; }
        
        .btn-regresar { flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; text-decoration: none; text-align: center; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-guardar { flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .btn-guardar svg { transition: transform 0.3s ease; }
        .btn-guardar:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; opacity: 1; }
        .btn-guardar:hover svg { transform: scale(1.2); }

        /* KEYFRAMES */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        @media (max-width: 768px) { .actions { flex-direction: column-reverse; } .btn-regresar, .btn-guardar { width: 100%; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('tutor.dashboard') }}">Inicio</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Diseñar Instrumento</h1>
            <p>Construye tu evaluación personalizando el encabezado y las preguntas.</p>
        </div>

        <form action="{{ route('tutor.instrumentos.store') }}" method="POST" id="instrumentForm">
            @csrf

            <div class="builder-card">
                <h2 style="color: var(--azul-profundo); margin-bottom: 20px; font-size: 1.4rem;">1. Información General</h2>
                <div class="form-group">
                    <label>Título del Instrumento</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Diagnóstico de Ciberbullying 2026" required>
                </div>
                <div class="form-group">
                    <label>Descripción o Instrucciones</label>
                    <textarea name="descripcion" class="form-control" style="height: 100px;" placeholder="Explica a los alumnos de qué trata esta evaluación..." required></textarea>
                </div>
            </div>

            <div id="questionsContainer">
                </div>

            <button type="button" class="btn-add-question" onclick="addQuestion()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 5px;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Añadir otra pregunta
            </button>

            <div class="actions">
                <a href="{{ route('tutor.instrumentos') }}" class="btn-regresar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Cancelar
                </a>

                <button type="submit" class="btn-guardar">
                    Guardar Instrumento
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questionsContainer');
            
            const html = `
                <div class="question-block" id="q-block-${questionCount}">
                    <div class="question-header">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="question-number">${questionCount}</div>
                            <h3 style="color: var(--azul-profundo); font-size: 1.1rem;">Pregunta</h3>
                        </div>
                        <button type="button" class="btn-remove-q" onclick="removeQuestion(${questionCount})">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600; font-size: 0.9rem;">Texto de la pregunta:</label>
                        <input type="text" name="preguntas[${questionCount}][texto]" class="form-control" placeholder="Ej: ¿Has sentido miedo al usar internet?" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="font-weight: 600; font-size: 0.9rem;">Tipo de Respuesta:</label>
                            <select name="preguntas[${questionCount}][tipo]" class="form-control">
                                <option value="likert">Escala (Nunca - Siempre)</option>
                                <option value="boolean">Si / No</option>
                                <option value="text">Abierta (Texto)</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-weight: 600; font-size: 0.9rem;">Temática:</label>
                            <select name="preguntas[${questionCount}][id_tematica]" class="form-control">
                                <option value="1">Riesgo Psicológico</option>
                                <option value="2">Seguridad Digital</option>
                                <option value="3">Convivencia Social</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeQuestion(id) {
            if (document.querySelectorAll('.question-block').length > 1) {
                document.getElementById(`q-block-${id}`).remove();
            } else {
                alert("El instrumento debe tener al menos una pregunta.");
            }
        }

        window.onload = addQuestion;
    </script>
</body>
</html>