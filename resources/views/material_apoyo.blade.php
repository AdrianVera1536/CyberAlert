<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material de Apoyo | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* (Se mantiene todo tu CSS original intacto) */
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
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer;}
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        .resources-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-bottom: 50px; }

        .resource-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 24px; padding: 30px; display: flex; flex-direction: column; align-items: center; text-align: center; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); position: relative; overflow: hidden; }
        .resource-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: var(--verde-azulado); transform: scaleX(0); transition: transform 0.4s ease; transform-origin: left; }
        .resource-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }
        .resource-card:hover::before { transform: scaleX(1); }

        .resource-icon { width: 70px; height: 70px; border-radius: 20px; display: flex; justify-content: center; align-items: center; background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); margin-bottom: 20px; transition: all 0.3s ease; }
        .resource-card:hover .resource-icon { transform: scale(1.1) rotate(5deg); background: var(--verde-azulado); color: var(--blanco); }

        .resource-card h3 { font-size: 1.3rem; color: var(--azul-profundo); font-weight: 700; margin-bottom: 10px; }
        .resource-card p { font-size: 0.95rem; color: var(--texto-claro); line-height: 1.5; }

        .actions { display: flex; justify-content: center; align-items: center; gap: 30px; margin-top: 10px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-quiz { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .btn-quiz svg { transition: transform 0.3s ease; }
        .btn-quiz:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; opacity: 1; }
        .btn-quiz:hover svg { transform: translateX(5px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } 100% { border-radius: 30% 70% 70% 30%; } }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }

        @media (max-width: 768px) { .resources-grid { grid-template-columns: 1fr; } .actions { flex-direction: column; width: 100%; } .btn-regresar, .btn-quiz { width: 100%; justify-content: center; } }
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
            <h1>Material de Apoyo</h1>
            <p>Explora nuestros recursos educativos para aprender más sobre cómo prevenir y manejar el ciberbullying.</p>
        </div>

        <div class="resources-grid">
            
            <a href="https://www.unicef.org/es/end-violence/ciberacoso-que-es-y-como-detenerlo" target="_blank" rel="noopener noreferrer" class="resource-card">
                <div class="resource-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <h3>Infografía</h3>
                <p>Guías visuales rápidas sobre cómo identificar y actuar ante el acoso digital.</p>
            </a>

            <a href="https://www.is4k.es/necesitas-saber/ciberacoso" target="_blank" rel="noopener noreferrer" class="resource-card">
                <div class="resource-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                </div>
                <h3>Lectura</h3>
                <p>Artículos y documentos detallados con información profunda y estrategias de prevención.</p>
            </a>

            <a href="https://www.pantallasamigas.net/recursos/" target="_blank" rel="noopener noreferrer" class="resource-card">
                <div class="resource-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                </div>
                <h3>Imagen</h3>
                <p>Galería de recursos gráficos, posters y material para compartir en redes sociales.</p>
            </a>

        </div>

        <div class="actions">
            <a href="{{ route('estudiante.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Regresar
            </a>

            <a href="{{ route('estudiante.quiz') }}" class="btn-quiz">
                Ir a Realizar Quiz
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>

    </div>

</body>
</html>