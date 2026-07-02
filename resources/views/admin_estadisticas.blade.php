<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sistema | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC;
            --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6; --danger: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; left: -5%; bottom: -5%; width: 400px; height: 400px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); padding-bottom: 2px; }

        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(231, 76, 60, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--danger); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; font-weight: 600; }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- TARJETA DE GRÁFICAS --- */
        .stats-container { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 30px; padding: 40px; margin-bottom: 40px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); display: flex; flex-direction: column; align-items: center; }
        .chart-box { width: 100%; max-width: 600px; margin: 20px 0; }

        /* --- BOTONES DE PIE --- */
        .footer-actions { display: flex; justify-content: space-between; align-items: center; width: 100%; gap: 20px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 12px; padding: 16px 45px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2.5px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-generar { display: inline-flex; justify-content: center; align-items: center; gap: 12px; padding: 16px 45px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; animation: pulse-btn 2.5s infinite; transition: all 0.4s ease; }
        .btn-generar:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }

        @media (max-width: 650px) {
            .footer-actions { flex-direction: column-reverse; gap: 20px; }
            .btn-regresar, .btn-generar { width: 100%; justify-content: center; }
        }
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
            <h1>Estadísticas del Sistema</h1>
        </div>

        <div class="stats-container">
            <div class="chart-box">
                <canvas id="barChart"></canvas>
            </div>
            <p style="color: var(--texto-claro); font-size: 0.95rem; margin-top: 15px; font-weight: 500;">Comparativa de usuarios por perfil</p>
        </div>

        <div class="footer-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Regresar
            </a>

            <button class="btn-generar" onclick="alert('La función de descargar reporte en PDF se implementará pronto.')">
                Generar reporte
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
            </button>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Estudiantes', 'Tutores', 'Directivos', 'Administradores'],
                datasets: [{
                    label: 'Usuarios Registrados',
                    // ¡AQUÍ ESTÁ LA MAGIA! Laravel inyecta los números reales aquí:
                    data: [{{ $estudiantes }}, {{ $tutores }}, {{ $directivos }}, {{ $administradores }}],
                    backgroundColor: ['#406882', '#9b59b6', '#FFB347', '#1A374D'],
                    borderRadius: 12,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>