<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Riesgo | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            --riesgo-bajo: #27ae60;
            --riesgo-medio: #f39c12;
            --riesgo-alto: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        
        /* --- BACKGROUND ANIMADO (ADN del Proyecto) --- */
        .bg-mesh {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%);
            z-index: -1; animation: breathe 12s ease-in-out infinite alternate;
        }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape {
            position: fixed; right: -5%; bottom: -5%; width: 500px; height: 500px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 12s ease-in-out infinite;
            box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.4;
        }

        /* --- NAVBAR --- */
        nav {
            position: fixed; top: 0; width: 100%; padding: 15px 5%;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper {
            width: 100%; max-width: 1100px;
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
        }

        .dash-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- GRID DINÁMICO --- */
        .main-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* --- CARD DE LA GRÁFICA --- */
        .chart-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px);
            border-radius: 30px; padding: 40px;
            box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08);
            display: flex; flex-direction: column; align-items: center;
        }
        .chart-card h3 { color: var(--azul-profundo); margin-bottom: 25px; align-self: flex-start; }

        /* --- STACK DE CARDS DE RIESGO --- */
        .risk-stack { display: flex; flex-direction: column; gap: 20px; }
        
        .risk-card {
            background: white; border-radius: 24px; padding: 25px;
            display: flex; flex-direction: column; align-items: center;
            transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05);
            position: relative; border-left: 10px solid;
        }
        .risk-card:hover { transform: translateX(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }

        .card-bajo { border-left-color: var(--riesgo-bajo); }
        .card-medio { border-left-color: var(--riesgo-medio); }
        .card-alto { border-left-color: var(--riesgo-alto); }

        .risk-card h2 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }
        .risk-card p { font-weight: 700; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }

        /* --- BOTONES --- */
        .btn-action {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 35px; border-radius: 50px; font-weight: 700;
            cursor: pointer; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none; font-family: 'Poppins'; font-size: 1rem;
        }
        
        .btn-pdf { background: var(--riesgo-alto); color: white; box-shadow: 0 10px 20px rgba(231, 76, 60, 0.2); }
        .btn-pdf:hover { background: #c0392b; transform: translateY(-3px); }

        .btn-regresar {
            background: transparent; border: 2.5px solid var(--color-morado-btn);
            color: var(--color-morado-btn); text-decoration: none; margin-top: 20px;
        }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: scale(1.02); }

        /* --- ANIMACIONES --- */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }

        /* --- MODO IMPRESIÓN (PDF) --- */
        @media print {
            nav, .bg-mesh, .floating-shape, .btn-regresar, .btn-pdf { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .dashboard-wrapper { max-width: 100% !important; transform: none !important; padding: 40px !important; }
            .chart-card, .risk-card { box-shadow: none !important; border: 1px solid #ddd !important; page-break-inside: avoid; }
            .main-grid { grid-template-columns: 1fr 1fr !important; }
            h1 { color: #1A374D !important; font-size: 26pt !important; margin-bottom: 10px; }
            .chart-card { padding: 20px !important; }
        }

        @media (max-width: 850px) { .main-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <div>
                <h1>Resumen Institucional</h1>
                <p style="color: var(--texto-claro)">Consolidado de salud mental basado en <b>resultados procesados</b>.</p>
            </div>
            
            {{-- BOTÓN PDF (Basado en window.print) --}}
            <button onclick="window.print()" class="btn-action btn-pdf">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-10 0v5h8v-5M7 14h.01"></path></svg>
                Exportar Reporte PDF
            </button>
        </div>

        <div class="main-grid">
            <div class="chart-card">
                <h3>Distribución Global de Salud</h3>
                <div style="position: relative; height:350px; width:100%">
                    <canvas id="riskChart"></canvas>
                </div>
            </div>

            <div class="risk-stack">
                <div class="risk-card card-bajo">
                    <h2>{{ number_format($counts['bajo']) }}</h2>
                    <p style="color: var(--riesgo-bajo)">Riesgo Bajo</p>
                </div>
                <div class="risk-card card-medio">
                    <h2>{{ number_format($counts['medio']) }}</h2>
                    <p style="color: var(--riesgo-medio)">Riesgo Medio</p>
                </div>
                <div class="risk-card card-alto">
                    <h2>{{ number_format($counts['alto']) }}</h2>
                    <p style="color: var(--riesgo-alto)">Riesgo Alto</p>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <a href="{{ route('directivo.dashboard') }}" class="btn-action btn-regresar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-right: 5px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Panel
            </a>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('riskChart').getContext('2d');
        
        // Creamos la gráfica de dona
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Bajo', 'Medio', 'Alto'],
                datasets: [{
                    // Los datos vienen directamente de tu tabla resultados_procesados
                    data: [{{ $counts['bajo'] }}, {{ $counts['medio'] }}, {{ $counts['alto'] }}],
                    backgroundColor: ['#27ae60', '#f39c12', '#e74c3c'],
                    hoverOffset: 25,
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000 // Animación de entrada de 2 segundos
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { family: 'Poppins', size: 14, weight: '600' },
                            color: '#1A374D'
                        }
                    }
                },
                cutout: '75%' // Diseño de "anillo" moderno
            }
        });
    </script>
</body>
</html>