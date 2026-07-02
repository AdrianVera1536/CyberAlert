<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Directivo | CiberAlert</title>
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
            
            --riesgo-alto: #e74c3c;
            --riesgo-medio: #f39c12;
            --riesgo-bajo: #27ae60;

            --color-tematica: #9b59b6;
            --color-asig-tutor: #00b894;
            --color-resumen: #2c3e50;
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
        
        .nav-link-inicio { 
            color: var(--azul-profundo); 
            border-bottom: 2.5px solid var(--ambar); 
            padding-bottom: 2px; 
            transition: all 0.3s ease;
        }
        .nav-link-inicio:hover { color: var(--verde-azulado); }

        .btn-logout {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px;
            color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem;
            background: transparent; cursor: pointer; font-family: 'Poppins', sans-serif; font-weight: 600;
        }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- DASHBOARD WRAPPER --- */
        .dashboard-wrapper {
            width: 100%; max-width: 1100px;
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
        }

        .dash-header { margin-bottom: 40px; text-align: left; }
        .dash-header h1 { font-size: 3rem; font-weight: 800; color: var(--azul-profundo); line-height: 1.2; display: flex; align-items: center; gap: 15px; flex-wrap: wrap;}
        .dash-header h1 span.wave { display: inline-block; animation: wave 2.5s infinite; transform-origin: 70% 70%; }
        .dash-header p { font-size: 1.2rem; color: var(--texto-claro); margin-top: 5px; font-weight: 400; }

        /* --- MÉTRICAS --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
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
        .stat-number { font-size: 2rem; font-weight: 800; color: var(--azul-profundo); }
        
        .risk-high { color: var(--riesgo-alto); }
        .risk-med { color: var(--riesgo-medio); }
        .risk-low { color: var(--riesgo-bajo); }

        /* --- ACCIONES --- */
        .dash-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
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

        .card-tematica { --card-color: var(--color-tematica); }
        .card-asig-tutor { --card-color: var(--color-asig-tutor); }
        .card-resumen { --card-color: var(--color-resumen); }

        /* KEYFRAMES */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } 100% { border-radius: 30% 70% 70% 30%; } }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }
        @keyframes wave { 0% { transform: rotate(0deg); } 10% { transform: rotate(14deg); } 20% { transform: rotate(-8deg); } 30% { transform: rotate(14deg); } 40% { transform: rotate(-4deg); } 50% { transform: rotate(10deg); } 60% { transform: rotate(0deg); } 100% { transform: rotate(0deg); } }

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
            <a href="{{ route('directivo.dashboard') }}" class="nav-link-inicio">Inicio</a>
            
            {{-- 🔥 Formulario de Logout de Laravel --}}
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
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
            {{-- 🔥 Aquí mostramos dinámicamente el nombre del usuario logueado --}}
            <h1>Bienvenido, {{ Auth::user()->nombre }} <span class="wave">👋</span></h1>
            <p>Supervisa las estadísticas generales y el bienestar de la institución.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Estudiantes</h4>
                <div class="stat-number" data-target="1250">0</div>
            </div>
            <div class="stat-card">
                <h4>Por Semestre</h4>
                <div class="stat-number" data-target="8">0</div>
            </div>
            <div class="stat-card">
                <h4>Por Carrera</h4>
                <div class="stat-number" data-target="5">0</div>
            </div>
            <div class="stat-card">
                <h4>Riesgo Alto</h4>
                <div class="stat-number risk-high" data-target="12">0</div>
            </div>
            <div class="stat-card">
                <h4>Riesgo Medio</h4>
                <div class="stat-number risk-med" data-target="45">0</div>
            </div>
            <div class="stat-card">
                <h4>Riesgo Bajo</h4>
                <div class="stat-number risk-low" data-target="1193">0</div>
            </div>
        </div>

        <div class="dash-grid">
            
            <a href="{{ route('directivo.tematicas') }}" class="card card-tematica">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </div>
                <h3>Administrar temática de preguntas</h3>
                <p>Gestiona los bancos de preguntas, categorías y criterios de evaluación del sistema.</p>
            </a>

            <a href="{{ route('directivo.asignar.index') }}" class="card card-asig-tutor">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3>Asignar tutor a grupo</h3>
                <p>Vincular a los docentes responsables con sus grupos académicos correspondientes.</p>
            </a>

            <a href="{{ route('directivo.resumen') }}" class="card card-resumen">
                <div class="card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <h3>Generar resumen riesgo</h3>
                <p>Obtén el informe consolidado del estatus emocional y de riesgo de toda la institución.</p>
            </a>

        </div>
    </div>

    <script>
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const speed = 200; 
                const inc = target / speed;
                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    </script>
</body>
</html>