<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Resultados | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root { --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; left: -10%; bottom: -10%; width: 500px; height: 500px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; background: transparent; cursor: pointer; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; font-weight: 600;}
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        /* --- TARJETA DIAGNÓSTICO --- */
        .chart-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); position: relative; overflow: hidden; }
        .summary-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid rgba(64, 104, 130, 0.1); }
        .summary-box h2 { font-size: 1.5rem; color: var(--azul-profundo); }
        .badge-risk { padding: 8px 16px; border-radius: 20px; font-weight: 700; font-size: 0.95rem; border: 1px solid; }

        /* --- NUEVO GRÁFICO CIRCULAR --- */
        .circular-chart-container { display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; padding: 20px 0; }
        .circular-chart { display: block; margin: 0 auto; max-width: 250px; max-height: 250px; animation: scaleIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        .circle-bg { fill: none; stroke: rgba(64, 104, 130, 0.1); stroke-width: 3.8; }
        .circle { fill: none; stroke-width: 3.8; stroke-linecap: round; stroke-dasharray: 0, 100; transition: stroke-dasharray 1.5s ease-out; }
        .percentage-text { position: absolute; font-size: 3rem; font-weight: 800; color: var(--azul-profundo); display: flex; flex-direction: column; align-items: center; }
        .percentage-label { font-size: 0.9rem; font-weight: 600; color: var(--texto-claro); text-transform: uppercase; letter-spacing: 1px; margin-top: -5px; }

        /* --- NUEVA TARJETA QUIZ --- */
        .quiz-summary-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 30px 40px; margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); transition: transform 0.3s ease; }
        .quiz-summary-card:hover { transform: translateY(-5px); }
        .quiz-info h2 { font-size: 1.5rem; color: var(--azul-profundo); margin-bottom: 5px; }
        .quiz-info p { color: var(--texto-claro); font-size: 1rem; }
        .quiz-score-circle { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--ambar), #FF8C00); color: var(--azul-profundo); display: flex; justify-content: center; align-items: center; font-size: 1.8rem; font-weight: 800; border: 4px solid var(--blanco); box-shadow: 0 10px 20px var(--ambar-glow); }

        .actions { display: flex; justify-content: center; align-items: center; gap: 30px; margin-top: 10px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-apoyo { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); transition: all 0.4s ease; }
        .btn-apoyo:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        @keyframes scaleIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        @media (max-width: 768px) { .circular-chart { max-width: 200px; max-height: 200px; } .percentage-text { font-size: 2.5rem; } .actions { flex-direction: column; width: 100%; } .btn-regresar, .btn-apoyo { width: 100%; justify-content: center; } .quiz-summary-card { flex-direction: column; text-align: center; gap: 20px; } }
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
            <h1>Ver Resultados</h1>
            <p>Aquí tienes el resumen de todas tus evaluaciones.</p>
        </div>

        @if(session('success_quiz'))
            <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px; border-radius: 12px; border: 1px solid rgba(16, 185, 129, 0.2); margin-bottom: 20px; font-weight: 600; text-align: center;">
                {{ session('success_quiz') }}
            </div>
        @endif

        <div class="chart-card">
            <div class="summary-box">
                <h2>Nivel de Riesgo (Diagnóstico)</h2>
                <div class="badge-risk" style="background: {{ $color }}20; color: {{ $color }}; border-color: {{ $color }}40;">
                    {{ $etiqueta }}
                </div>
            </div>

            <div class="circular-chart-container">
                <svg viewBox="0 0 36 36" class="circular-chart">
                    <path class="circle-bg"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831"
                    />
                    <path class="circle" id="dynamicCircle"
                        stroke="{{ $color }}"
                        d="M18 2.0845
                        a 15.9155 15.9155 0 0 1 0 31.831
                        a 15.9155 15.9155 0 0 1 0 -31.831"
                    />
                </svg>
                <div class="percentage-text">
                    {{ $porcentaje }}%
                    <span class="percentage-label">Nivel de Riesgo</span>
                </div>
            </div>
        </div>

        @if(isset($calificacion_quiz))
        <div class="quiz-summary-card">
            <div class="quiz-info">
                <h2>Conocimiento (Quiz)</h2>
                <p>Esta es la calificación que obtuviste en tu última evaluación sobre Ciberseguridad y Prevención.</p>
            </div>
            <div class="quiz-score-circle">
                {{ $calificacion_quiz }}
            </div>
        </div>
        @endif

        <div class="actions">
            <a href="{{ route('estudiante.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Regresar
            </a>

            <a href="{{ route('estudiante.material') }}" class="btn-apoyo">
                Ir a material de apoyo
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <script>
        // Pequeño script para animar el gráfico circular al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            const circle = document.getElementById('dynamicCircle');
            const percentage = {{ $porcentaje }};
            // Retraso ligero para que se note la animación al entrar a la página
            setTimeout(() => {
                circle.style.strokeDasharray = `${percentage}, 100`;
            }, 100);
        });
    </script>
</body>
</html>