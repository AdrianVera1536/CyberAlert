<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditoría de Base de Datos | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- ESTILOS UNIFICADOS CIBERSALUD --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC;
            --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6; --danger: #e74c3c;
            /* Variables extra para la terminal */
            --terminal-bg: #0b0f19; --terminal-header: #1e293b; --terminal-text: #4ade80;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; right: -5%; top: 10%; width: 450px; height: 450px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite alternate; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.4; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); padding-bottom: 2px; }

        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(231, 76, 60, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--danger); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; font-weight: 600; }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 1100px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 20px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }
        .dash-header p { color: var(--texto-claro); font-size: 1rem; margin-top: 5px; }

        /* --- TARJETA DE AUDITORÍA (GLASSMORPHISM) --- */
        .audit-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 30px;
            padding: 30px; margin-bottom: 40px;
            box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08);
        }

        /* --- CONSOLA / TERMINAL --- */
        .terminal-window {
            background-color: var(--terminal-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            margin-top: 20px;
        }

        .terminal-header {
            background-color: var(--terminal-header);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mac-dots { display: flex; gap: 8px; }
        .mac-dots span { width: 12px; height: 12px; border-radius: 50%; }
        .dot-red { background-color: #ff5f56; }
        .dot-yellow { background-color: #ffbd2e; }
        .dot-green { background-color: #27c93f; }

        .terminal-title {
            color: #94a3b8; font-size: 0.85rem; font-family: monospace; letter-spacing: 1px;
        }

        .btn-refresh {
            background: rgba(255, 255, 255, 0.1); color: white; border: 1px solid rgba(255,255,255,0.2);
            padding: 6px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: 0.3s;
            display: flex; align-items: center; gap: 6px;
        }
        .btn-refresh:hover { background: var(--ambar); color: var(--azul-profundo); border-color: var(--ambar); }

        .terminal-body {
            padding: 25px;
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #475569 var(--terminal-bg);
        }

        .terminal-body pre {
            color: var(--terminal-text);
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.95rem;
            white-space: pre-wrap;
            line-height: 1.6;
            margin: 0;
        }

        /* Custom Scrollbar para la terminal */
        .terminal-body::-webkit-scrollbar { width: 8px; }
        .terminal-body::-webkit-scrollbar-track { background: var(--terminal-bg); }
        .terminal-body::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }

        /* --- BOTÓN DE REGRESO --- */
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 12px; padding: 16px 45px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2.5px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 100% { border-radius: 70% 30% 30% 70%; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-logo">CiberAlert<span>.</span></a>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-inicio">Inicio</a>
            
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
            <button onclick="document.getElementById('logout-form').submit();" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Cerrar Sesión
            </button>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Auditoría de Base de Datos</h1>
            <p>Registro en tiempo real de las últimas consultas (MySQL) ejecutadas en el sistema.</p>
        </div>

        <div class="audit-card">
            
            <div class="terminal-window">
                <div class="terminal-header">
                    <div class="mac-dots">
                        <span class="dot-red"></span>
                        <span class="dot-yellow"></span>
                        <span class="dot-green"></span>
                    </div>
                    <div class="terminal-title">mysql_query_log.txt</div>
                    <button class="btn-refresh" onclick="location.reload()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        Refrescar
                    </button>
                </div>
                
                <div class="terminal-body">
                    <pre>{{ $logContent }}</pre>
                </div>
            </div>

        </div>

        <div style="display: flex; width: 100%;">
            <a href="{{ route('admin.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Volver al Panel Principal
            </a>
        </div>
    </div>

</body>
</html>