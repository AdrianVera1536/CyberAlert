<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5);
            --naranja-suave: #FF8C00; --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A;
            --texto-claro: #64748B; --color-morado-btn: #9b59b6; --verde-confirmar: #27ae60;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; left: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }

        /* --- CONTENEDOR --- */
        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- TARJETA --- */
        .report-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 30px; padding: 50px; margin-bottom: 30px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); }
        
        .select-wrapper { position: relative; max-width: 500px; margin: 0 auto 30px; }
        .select-wrapper select { width: 100%; padding: 18px 20px; border: 2px solid rgba(64, 104, 130, 0.2); border-radius: 15px; font-size: 1.1rem; outline: none; appearance: none; cursor: pointer; text-align: center; background: white; transition: 0.3s; }
        .select-wrapper select:hover { border-color: var(--verde-azulado); }
        .select-wrapper::after { content: '▼'; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--verde-azulado); pointer-events: none; }

        /* --- BOTONES --- */
        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-action { width: 100%; display: inline-flex; justify-content: center; align-items: center; gap: 12px; padding: 18px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; transition: 0.3s; cursor: pointer; border: none; }
        
        .btn-generar { background: var(--ambar); color: var(--azul-profundo); animation: pulse-btn 2.5s infinite; }
        .btn-generar:hover { transform: translateY(-3px); box-shadow: 0 12px 25px var(--ambar-glow); }

        .btn-imprimir { 
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); 
            color: white; 
            box-shadow: 0 8px 15px rgba(26, 55, 77, 0.2); 
            margin-top: 10px;
        }
        .btn-imprimir:hover { transform: translateY(-3px); box-shadow: 0 12px 20px rgba(26, 55, 77, 0.3); }

        .btn-regresar { background: transparent; border: 2.5px solid var(--color-morado-btn); color: var(--color-morado-btn); text-decoration: none; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: translateY(-3px); }

        /* --- GRID DE RESULTADOS --- */
        .results-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 40px; animation: fadeIn 1s forwards; }
        .stat-box { background: white; padding: 25px; border-radius: 20px; text-align: center; border: 1px solid rgba(0,0,0,0.05); box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
        .stat-number { font-size: 2.5rem; font-weight: 800; color: var(--verde-azulado); }
        .stat-label { color: var(--texto-claro); font-weight: 600; font-size: 0.9rem; }

        /* =========================================
           🔥 CONFIGURACIÓN PROFESIONAL DE IMPRESIÓN 
           ========================================= */
        /* =========================================
   🔥 CONFIGURACIÓN PDF PROFESIONAL 
   ========================================= */
@media print {
    /* 1. Obligar a que salgan los colores y fondos */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }

    /* 2. Ocultar basura (Nav, botones, formas locas) */
    nav, .bg-mesh, .floating-shape, form, .btn-regresar, .dash-header p, .btn-imprimir { 
        display: none !important; 
    }

    /* 3. Limpiar el fondo y los márgenes */
    body { 
        background: white !important; 
        padding: 0 !important; 
        margin: 0 !important;
    }

    .dashboard-wrapper { 
        max-width: 100% !important; 
        width: 100% !important;
        transform: none !important; 
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 4. Estilizar la tarjeta como un documento real */
    .report-card { 
        border: none !important; 
        box-shadow: none !important; 
        background: white !important; 
        padding: 20px !important; 
        width: 100% !important;
    }

    /* 5. Acomodar los resultados uno debajo de otro para que no se corten */
    .results-grid { 
        display: block !important; 
        width: 100% !important;
    }

    .stat-box { 
        border: 1px solid #eee !important; 
        margin-bottom: 30px !important;
        padding: 30px !important;
        page-break-inside: avoid; /* Evita que una caja se corte a la mitad */
        background: #fdfdfd !important;
    }

    /* 6. Título elegante para el reporte */
    .dash-header h1 { 
        color: #1A374D !important; 
        font-size: 28pt !important; 
        margin-bottom: 10px !important;
        border-bottom: 3px solid #1A374D !important;
        padding-bottom: 15px !important;
        text-align: left !important;
    }

    /* 7. Ajustar el tamaño de la gráfica en el PDF */
    canvas { 
        max-height: 300px !important; 
        margin: 20px auto !important; 
    }
}

        /* ANIMACIONES */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        @media (max-width: 768px) { .results-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('tutor.dashboard') }}" style="color: var(--azul-profundo); font-weight: 600;">Inicio</a>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Reporte de Resultados</h1>
            <p style="color: var(--texto-claro);">Análisis de bienestar digital del grupo seleccionado.</p>
        </div>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #ef4444; padding: 15px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #fecaca; width: 100%;">
                <strong>¡Vaya! Algo faltó:</strong>
                <ul style="margin-top: 5px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="report-card">
            <form action="{{ route('tutor.reportes.generar') }}" method="POST" style="width: 100%;">
                @csrf
                <div class="input-group">
                    <label style="display: block; text-align: center; margin-bottom: 15px; font-weight: 600; color: var(--azul-profundo);">Selecciona el grupo a evaluar:</label>
                    <div class="select-wrapper">
                        <select name="id_grupo" required>
                            <option value="" disabled selected>Elige un grupo...</option>
                            @foreach($grupos as $g)
                                <option value="{{ $g->getKey() }}" {{ isset($grupoSeleccionado) && $grupoSeleccionado->getKey() == $g->getKey() ? 'selected' : '' }}>
                                    {{ $g->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="report-actions" style="margin: 0 auto; max-width: 400px;">
                    <button type="submit" class="btn-action btn-generar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        Generar Análisis
                    </button>
                </div>
            </form>

            @if(isset($datosGrafica))
            <div class="results-grid">
                <div class="stat-box">
                    <h3 style="margin-bottom: 20px; color: var(--azul-profundo);">Distribución de Niveles</h3>
                    <div style="width: 100%; max-width: 250px; margin: 0 auto;">
                        <canvas id="graficaRiesgo"></canvas>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="stat-box">
                        <p class="stat-label">Total Estudiantes</p>
                        <div class="stat-number">{{ array_sum($datosGrafica) }}</div>
                    </div>
                    <div class="stat-box" style="border-left: 6px solid #ef4444;">
                        <p class="stat-label">Alumnos en Riesgo Crítico</p>
                        <div class="stat-number" style="color: #ef4444;">{{ $datosGrafica['alto'] }}</div>
                    </div>
                    
                    {{-- Botón Imprimir con Estilo Mejorado --}}
                    <button onclick="window.print()" class="btn-action btn-imprimir">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Exportar a PDF Profesional
                    </button>
                </div>
            </div>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ route('tutor.dashboard') }}" class="btn-action btn-regresar" style="max-width: 300px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Panel
            </a>
        </div>
    </div>

    @if(isset($datosGrafica))
    <script>
        const ctx = document.getElementById('graficaRiesgo').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Bajo', 'Medio', 'Alto'],
                datasets: [{
                    data: [{{ $datosGrafica['bajo'] }}, {{ $datosGrafica['medio'] }}, {{ $datosGrafica['alto'] }}],
                    backgroundColor: ['#22c55e', '#FFB347', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { 
                    legend: { 
                        position: 'bottom', 
                        labels: { padding: 20, font: { family: 'Poppins', size: 12, weight: '600' } } 
                    } 
                },
                cutout: '70%'
            }
        });
    </script>
    @endif
</body>
</html>