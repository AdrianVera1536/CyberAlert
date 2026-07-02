<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Tutorados | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5);
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B;
            --color-morado-btn: #9b59b6; --riesgo-alto: #ef4444; --riesgo-medio: #FFB347; --riesgo-bajo: #00b894;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; right: -10%; bottom: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        /* --- TABLA --- */
        .table-container { margin-bottom: 40px; }
        .table-header { display: grid; grid-template-columns: 2.5fr 1fr 1.5fr 1fr; padding: 15px 30px; font-weight: 700; color: var(--azul-profundo); background: rgba(255, 255, 255, 0.5); border-radius: 15px; margin-bottom: 15px; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }

        /* Contenedor de la fila y el detalle */
        .student-wrapper { margin-bottom: 15px; }

        .student-row { display: grid; grid-template-columns: 2.5fr 1fr 1.5fr 1fr; align-items: center; background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 20px; padding: 20px 30px; box-shadow: 0 5px 15px rgba(26, 55, 77, 0.03); transition: all 0.3s ease; position: relative; overflow: hidden; z-index: 2; }
        .student-row:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(26, 55, 77, 0.08); background: var(--blanco); }
        .student-row::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--risk-color, var(--verde-azulado)); transform: scaleY(0); transition: transform 0.3s ease; }
        .student-row:hover::before { transform: scaleY(1); }

        /* Celdas */
        .cell-name { font-weight: 600; color: var(--azul-profundo); display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 35px; height: 35px; background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800; flex-shrink: 0; }
        .cell-group { color: var(--texto-claro); font-weight: 500; }
        
        /* Badges de Riesgo */
        .badge-risk { padding: 6px 15px; border-radius: 30px; font-size: 0.85rem; font-weight: 700; display: inline-block; color: var(--blanco); background: var(--risk-color); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .risk-alto { --risk-color: var(--riesgo-alto); }
        .risk-medio { --risk-color: var(--riesgo-medio); color: var(--azul-profundo); }
        .risk-bajo { --risk-color: var(--riesgo-bajo); }

        /* Botón Detalle */
        .btn-detalle { padding: 8px 16px; border: 1px solid var(--verde-azulado); border-radius: 12px; color: var(--verde-azulado); font-size: 0.85rem; font-weight: 600; text-align: center; transition: all 0.3s ease; background: transparent; cursor: pointer; }
        .btn-detalle:hover, .btn-detalle.active { background: var(--verde-azulado); color: var(--blanco); }

        /* --- DETALLE DESPLEGABLE --- */
        .student-detail { max-height: 0; overflow: hidden; transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: rgba(255, 255, 255, 0.5); border-radius: 0 0 20px 20px; margin: -10px 10px 0; padding: 0 20px; opacity: 0; }
        .student-detail.show { max-height: 300px; padding: 30px 20px 20px; opacity: 1; border: 1px solid rgba(255, 255, 255, 0.8); border-top: none; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; color: var(--texto-oscuro); font-size: 0.9rem; }
        .detail-box h4 { color: var(--azul-profundo); font-size: 1rem; margin-bottom: 5px; }
        .detail-box p { color: var(--texto-claro); }

        /* --- BOTONES INFERIORES --- */
        .actions { display: flex; justify-content: space-between; align-items: center; gap: 30px; margin-top: 40px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        
        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-amber-action { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s ease; text-decoration: none;}
        .btn-amber-action:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; opacity: 1; }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        @media (max-width: 768px) { .table-header { display: none; } .student-row { grid-template-columns: 1fr; gap: 15px; text-align: center; padding: 25px; } .cell-name { justify-content: center; flex-direction: column; } .actions { flex-direction: column; width: 100%; gap: 20px; } .btn-regresar, .btn-amber-action { width: 100%; justify-content: center; } .detail-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('tutor.dashboard') }}">Inicio</a>
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout">Cerrar Sesión</button></form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Resultados Tutorados</h1>
            <p>Monitorea el nivel de riesgo y el progreso de tus estudiantes asignados.</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div>Nombre estudiante</div><div>Grupo</div><div>Nivel de riesgo</div><div>Acciones</div>
            </div>

            <div class="students-list">
                
                <div class="student-wrapper">
                    <div class="student-row risk-alto" style="animation-delay: 0.1s;">
                        <div class="cell-name"><div class="user-avatar">AV</div>Adrian Rodrigo Vera Velazquez</div>
                        <div class="cell-group">601</div>
                        <div><span class="badge-risk risk-alto">Alto Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-1', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-1">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 42/50 (Ciberacoso recurrente).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 40/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-medio" style="animation-delay: 0.15s;">
                        <div class="cell-name"><div class="user-avatar">LR</div>Luis Rebollar Vela</div>
                        <div class="cell-group">601</div>
                        <div><span class="badge-risk risk-medio">Riesgo Moderado</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-2', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-2">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 28/50 (Ansiedad leve en redes).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 70/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-bajo" style="animation-delay: 0.2s;">
                        <div class="cell-name"><div class="user-avatar">SO</div>Silbana Osorio Osorio</div>
                        <div class="cell-group">601</div>
                        <div><span class="badge-risk risk-bajo">Bajo Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-3', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-3">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 12/50 (Sin señales de acoso).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 100/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-alto" style="animation-delay: 0.25s;">
                        <div class="cell-name"><div class="user-avatar">MA</div>Miguel Ángel Garcia Reyes</div>
                        <div class="cell-group">602</div>
                        <div><span class="badge-risk risk-alto">Alto Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-4', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-4">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 45/50 (Exclusión y amenazas en línea).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 50/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-medio" style="animation-delay: 0.3s;">
                        <div class="cell-name"><div class="user-avatar">JS</div>Juan Sánchez Sanchez</div>
                        <div class="cell-group">602</div>
                        <div><span class="badge-risk risk-medio">Riesgo Moderado</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-5', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-5">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 30/50 (Aislamiento en grupos escolares).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 80/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-bajo" style="animation-delay: 0.35s;">
                        <div class="cell-name"><div class="user-avatar">RG</div>Rosa García Peralta</div>
                        <div class="cell-group">602</div>
                        <div><span class="badge-risk risk-bajo">Bajo Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-6', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-6">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 10/50 (Prácticas seguras en redes).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 90/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-alto" style="animation-delay: 0.4s;">
                        <div class="cell-name"><div class="user-avatar">CP</div>Carlos Pérez Archundia</div>
                        <div class="cell-group">304</div>
                        <div><span class="badge-risk risk-alto">Alto Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-7', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-7">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 48/50 (Extorsión y suplantación de identidad).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 20/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-medio" style="animation-delay: 0.45s;">
                        <div class="cell-name"><div class="user-avatar">AL</div>Ana López Castilla</div>
                        <div class="cell-group">304</div>
                        <div><span class="badge-risk risk-medio">Riesgo Moderado</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-8', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-8">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 32/50 (Dependencia y ansiedad social).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 60/100</p></div>
                        </div>
                    </div>
                </div>

                <div class="student-wrapper">
                    <div class="student-row risk-bajo" style="animation-delay: 0.5s;">
                        <div class="cell-name"><div class="user-avatar">DM</div>Diego Martínez Rocha</div>
                        <div class="cell-group">304</div>
                        <div><span class="badge-risk risk-bajo">Bajo Riesgo</span></div>
                        <div><button class="btn-detalle" onclick="toggleDetail('det-9', this)">Ver detalle</button></div>
                    </div>
                    <div class="student-detail" id="det-9">
                        <div class="detail-grid">
                            <div class="detail-box"><h4>Último Diagnóstico</h4><p>Puntaje: 15/50 (Uso responsable de tecnología).</p></div>
                            <div class="detail-box"><h4>Último Quiz</h4><p>Calificación: 100/100</p></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="actions">
            <a href="{{ route('tutor.grupos') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar
            </a>

            <a href="{{ route('tutor.instrumentos') }}" class="btn-amber-action">
                Ir a diseñar instrumento
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>

    <script>
        function toggleDetail(id, btn) {
            const detail = document.getElementById(id);
            
            // Opcional: Cerrar los demás al abrir uno nuevo
            // document.querySelectorAll('.student-detail').forEach(d => { if(d.id !== id) { d.classList.remove('show'); d.previousElementSibling.querySelector('.btn-detalle').innerText = "Ver detalle"; d.previousElementSibling.querySelector('.btn-detalle').classList.remove('active'); } });

            detail.classList.toggle('show');
            btn.classList.toggle('active');
            btn.innerText = detail.classList.contains('show') ? "Ocultar detalle" : "Ver detalle";
        }
    </script>
</body>
</html>