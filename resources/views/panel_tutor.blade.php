<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tutor | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B;
            --color-grupos: #9b59b6; --color-resultados: #FF8C00; --color-instrumentos: #6E85B7;
            --color-material: #00b894; --color-reporte: #c0392b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; left: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2px solid var(--ambar); padding-bottom: 2px; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: left; }
        .dash-header h1 { font-size: 3rem; font-weight: 800; color: var(--azul-profundo); line-height: 1.2; display: flex; align-items: center; gap: 15px; }
        .dash-header h1 span.wave { display: inline-block; animation: wave 2.5s infinite; transform-origin: 70% 70%; }
        .dash-header p { font-size: 1.2rem; color: var(--texto-claro); margin-top: 5px; font-weight: 400; }

        .dash-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; }
        .card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 24px; padding: 30px; display: flex; flex-direction: column; align-items: flex-start; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); position: relative; overflow: hidden; }
        .card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--card-color); transform: scaleX(0); transition: transform 0.4s ease; transform-origin: left; }
        .card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }
        .card:hover::before { transform: scaleX(1); }

        .card-icon { width: 60px; height: 60px; border-radius: 16px; display: flex; justify-content: center; align-items: center; background: rgba(255, 255, 255, 0.9); box-shadow: 0 8px 16px rgba(0,0,0,0.05); margin-bottom: 20px; color: var(--card-color); transition: all 0.3s ease; }
        .card:hover .card-icon { transform: scale(1.1) rotate(5deg); background: var(--card-color); color: var(--blanco); }

        .card h3 { font-size: 1.4rem; color: var(--azul-profundo); font-weight: 700; margin-bottom: 8px; }
        .card p { font-size: 0.95rem; color: var(--texto-claro); line-height: 1.4; }

        .card-grupos { --card-color: var(--color-grupos); }
        .card-resultados { --card-color: var(--color-resultados); }
        .card-instrumentos { --card-color: var(--color-instrumentos); }
        .card-material { --card-color: var(--color-material); }
        .card-reporte { --card-color: var(--color-reporte); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        @keyframes wave { 0%, 60%, 100% { transform: rotate(0deg); } 10%, 30% { transform: rotate(14deg); } 20% { transform: rotate(-8deg); } 40% { transform: rotate(-4deg); } 50% { transform: rotate(10deg); } }

        @media (min-width: 992px) { .card-reporte { grid-column: span 2; flex-direction: row; align-items: center; gap: 20px; } .card-reporte .card-icon { margin-bottom: 0; } }
        @media (max-width: 768px) { .dash-header h1 { font-size: 2.2rem; } .dash-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('tutor.dashboard') }}" class="nav-link-inicio">Inicio</a>
            
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
            <h1>Bienvenido, {{ Auth::user()->nombre ?? 'Tutor' }} <span class="wave">👋</span></h1>
            <p>Gestiona a tus grupos y analiza el progreso de tus tutorados.</p>
        </div>

        <div class="dash-grid">
            <a href="{{ route('tutor.grupos') }}" class="card card-grupos" style="animation-delay: 0.1s;">
                <div class="card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
                <h3>Mis grupos asignados</h3>
                <p>Visualiza el listado de tus estudiantes y su estatus general.</p>
            </a>

            <a href="{{ route('tutor.resultados') }}" class="card card-resultados" style="animation-delay: 0.2s;">
                <div class="card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></div>
                <h3>Resultados tutorados</h3>
                <p>Analiza las métricas y el nivel de riesgo de diagnóstico de tus grupos.</p>
            </a>

            <a href="{{ route('tutor.instrumentos') }}" class="card card-instrumentos" style="animation-delay: 0.3s;">
                <div class="card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></div>
                <h3>Diseñar Instrumentos</h3>
                <p>Crea, edita o gestiona las preguntas de los cuestionarios interactivos.</p>
            </a>

            <a href="{{ route('tutor.material.index') }}" class="card card-material" style="animation-delay: 0.4s;">
                <div class="card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></div>
                <h3>Asignar material apoyo</h3>
                <p>Envía infografías, lecturas y recursos específicos a los alumnos que lo requieran.</p>
            </a>

            <a href="{{ route('tutor.reportes.index') }}" class="card card-reporte" style="animation-delay: 0.5s;">
                <div class="card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></div>
                <div>
                    <h3>Generar Reporte</h3>
                    <p>Descarga informes en formato PDF o Excel sobre el progreso y estatus de toda la plantilla asignada para entrega institucional.</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>