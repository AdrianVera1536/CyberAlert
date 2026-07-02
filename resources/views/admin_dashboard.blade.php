<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D;
            --verde-azulado: #406882;
            --ambar: #FFB347;
            --ambar-glow: rgba(255, 179, 71, 0.5);
            --blanco: #FFFFFF;
            --gris-fondo: #F8FAFC;
            --texto-oscuro: #0F172A;
            --texto-claro: #64748B;
            --color-morado-btn: #9b59b6;
            
            /* Colores de las tarjetas de acción */
            --color-usuarios: #FFB347;    /* Amarillo/Ámbar */
            --color-instituciones: #27ae60; /* Verde */
            --color-instrumentos: #e67e22;  /* Naranja */
            --color-estadisticas: #2c3e50;  /* Gris oscuro */
            --color-logs: #ef4444; /* Rojo para herramienta técnica/logs */
            --color-bitacora: #8b5cf6; /* Morado para la auditoría de cambios */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%);
            z-index: -1; animation: breathe 12s ease-in-out infinite alternate;
        }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape {
            position: fixed; left: -10%; top: -10%; width: 600px; height: 600px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite;
            box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5;
        }

        /* --- NAVBAR --- */
        nav {
            position: fixed; top: 0; width: 100%; padding: 15px 5%;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); padding-bottom: 2px; }

        .btn-logout {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px;
            color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem;
            background: transparent; cursor: pointer; font-weight: 600;
        }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper {
            width: 100%; max-width: 1100px;
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
        }

        .dash-header { margin-bottom: 40px; text-align: left; }
        .dash-header h1 { font-size: 2.8rem; font-weight: 800; color: var(--azul-profundo); line-height: 1.2; display: flex; align-items: center; gap: 15px; }
        .dash-header h1 span.wave { display: inline-block; animation: wave 2.5s infinite; transform-origin: 70% 70%; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); margin-top: 5px; }

        /* --- MÉTRICAS (STAT CARDS) --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--blanco);
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card h4 { font-size: 0.75rem; color: var(--texto-claro); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px; font-weight: 600; }
        .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- ACCIONES --- */
        .dash-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 24px;
            padding: 30px; display: flex; flex-direction: column; align-items: flex-start;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); position: relative; overflow: hidden;
        }
        
        .card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: var(--card-color); transform: scaleX(0); transition: transform 0.4s ease; transform-origin: left;
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }
        .card:hover::before { transform: scaleX(1); }

        .card-icon {
            width: 60px; height: 60px; border-radius: 16px;
            display: flex; justify-content: center; align-items: center;
            background: rgba(255, 255, 255, 0.9); box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            margin-bottom: 20px; color: var(--card-color); transition: all 0.3s ease;
        }
        .card:hover .card-icon { transform: scale(1.1) rotate(5deg); background: var(--card-color); color: var(--blanco); }

        .card h3 { font-size: 1.3rem; color: var(--azul-profundo); font-weight: 700; margin-bottom: 8px; }
        .card p { font-size: 0.9rem; color: var(--texto-claro); line-height: 1.4; }

        .card-usuarios { --card-color: var(--color-usuarios); }
        .card-instituciones { --card-color: var(--color-instituciones); }
        .card-instrumentos { --card-color: var(--color-instrumentos); }
        .card-estadisticas { --card-color: var(--color-estadisticas); }
        .card-logs { --card-color: var(--color-logs); }
        .card-bitacora { --card-color: var(--color-bitacora); } /* Clase para la nueva tarjeta */

        /* ANIMACIONES */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } 100% { border-radius: 30% 70% 70% 30%; } }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }
        @keyframes wave { 0% { transform: rotate(0deg); } 10% { transform: rotate(14deg); } 20% { transform: rotate(-8deg); } 30% { transform: rotate(14deg); } 100% { transform: rotate(0deg); } }

        @media (max-width: 768px) {
            .dash-header h1 { font-size: 2.2rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-inicio">Inicio</a>
            
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                @csrf
            </form>
            <button onclick="document.getElementById('logout-form').submit();" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Cerrar Sesión
            </button>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            {{-- 🔥 SALUDO DINÁMICO --}}
            <h1>Bienvenido, {{ Auth::user()->nombre }} <span class="wave">👋</span></h1>
            <p>Gestión global del sistema CiberSalud y monitoreo de la plataforma.</p>
        </div>

        {{-- MÉTRICAS DINÁMICAS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Usuarios</h4>
                <div class="stat-number" data-target="{{ $totalUsuarios }}">0</div>
            </div>
            <div class="stat-card">
                <h4>Diagnósticos</h4>
                <div class="stat-number" data-target="{{ $totalDiagnosticos }}">0</div>
            </div>
            <div class="stat-card">
                <h4>Instituciones</h4>
                <div class="stat-number" data-target="{{ $totalInstituciones }}">0</div>
            </div>
            <div class="stat-card">
                <h4>Estudiantes</h4>
                <div class="stat-number" data-target="{{ $totalEstudiantes }}">0</div>
            </div>
            <div class="stat-card">
                <h4>Tutores</h4>
                <div class="stat-number" data-target="{{ $totalTutores }}">0</div>
            </div>
            <div class="stat-card">
                <h4>Directivos</h4>
                <div class="stat-number" data-target="{{ $totalDirectivos }}">0</div>
            </div>
        </div>

        <div class="dash-grid">
            
            <a href="{{ route('admin.usuarios.index') }}" class="card card-usuarios">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3>Administrar Usuarios</h3>
                <p>Gestionar altas, bajas, roles y permisos de todos los usuarios del sistema.</p>
            </a>

            <a href="{{ route('admin.instituciones.index') }}" class="card card-instituciones">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"></path><path d="M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7H3"></path><path d="M19 21V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v14"></path><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"></path></svg>
                </div>
                <h3>Administrar Instituciones</h3>
                <p>Configuración y control de los planteles educativos registrados.</p>
            </a>

            <a href="{{ route('admin.instrumentos.index') }}" class="card card-instrumentos">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <h3>Administrar Instrumentos</h3>
                <p>Gestión de bancos de preguntas y escalas de evaluación diagnóstica.</p>
            </a>

            <a href="{{ route('admin.estadisticas.index') }}" class="card card-estadisticas">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <h3>Estadísticas del Sistema</h3>
                <p>Monitoreo técnico de rendimiento y reportes globales de uso.</p>
            </a>

            {{-- TARJETA DE LOGS (La que ya tenías) --}}
            <a href="{{ route('directivo.logs') }}" class="card card-logs">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="4 17 10 11 4 5"></polyline>
                        <line x1="12" y1="19" x2="20" y2="19"></line>
                    </svg>
                </div>
                <h3>Logs de Base de Datos</h3>
                <p>Auditoría en tiempo real de las consultas MySQL ejecutadas por el sistema.</p>
            </a>

            {{-- NUEVA TARJETA DE BITÁCORA --}}
            <a href="{{ route('directivo.bitacora') }}" class="card card-bitacora">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <h3>Bitácora de Cambios</h3>
                <p>Historial detallado de altas, bajas y modificaciones realizadas por los usuarios.</p>
            </a>

        </div>
    </div>

    <script>
        // Animación de los números de las métricas
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const speed = 100; 
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    </script>
</body>
</html>