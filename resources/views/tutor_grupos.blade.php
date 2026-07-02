<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos Asignados | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC;
            --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; left: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; background: transparent; cursor: pointer; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; font-weight: 600; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 700px; animation: slideUp 0.8s forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- CONTENEDOR DE GRUPO --- */
        .group-container { margin-bottom: 20px; width: 100%; }

        .group-row {
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 50px;
            padding: 15px 25px; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05);
            transition: all 0.3s ease; cursor: pointer; position: relative; z-index: 2;
        }
        .group-row:hover { background: var(--blanco); transform: scale(1.01); }

        .group-circle {
            width: 60px; height: 60px; border-radius: 50%;
            border: 3px solid var(--azul-profundo);
            display: flex; justify-content: center; align-items: center;
            font-size: 1.3rem; font-weight: 800; color: var(--azul-profundo);
            background: rgba(26, 55, 77, 0.05); transition: all 0.3s ease;
        }

        .btn-ver-estudiantes {
            border: 2px solid var(--verde-azulado); border-radius: 12px;
            padding: 10px 20px; color: var(--verde-azulado); font-weight: 600;
            transition: all 0.3s ease; background: transparent; cursor: pointer;
        }
        .btn-ver-estudiantes.active { background: var(--verde-azulado); color: var(--blanco); }

        /* --- LISTA DE ESTUDIANTES (OCULTA POR DEFECTO) --- */
        .students-list {
            max-height: 0; overflow: hidden; transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.4); border-radius: 0 0 30px 30px;
            margin: -25px 20px 0; padding: 0 20px; opacity: 0;
        }
        .students-list.show { max-height: 500px; padding: 40px 20px 20px; opacity: 1; margin-top: -35px; border: 1px solid rgba(255,255,255,0.5); }

        .student-item {
            display: flex; align-items: center; gap: 15px; padding: 12px 0;
            border-bottom: 1px solid rgba(64, 104, 130, 0.1); color: var(--texto-oscuro); font-weight: 500;
        }
        .student-item:last-child { border-bottom: none; }
        .student-avatar { width: 35px; height: 35px; background: var(--verde-azulado); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 700; }

        .actions { display: flex; justify-content: center; align-items: center; gap: 30px; margin-top: 40px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; color: var(--color-morado-btn); border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); }
        
        .btn-resultados { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; color: var(--azul-profundo); background: var(--ambar); border: none; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s ease; }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }

        @media (max-width: 768px) { .actions { flex-direction: column; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('tutor.dashboard') }}">Inicio</a>
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit" class="btn-logout">Cerrar Sesión</button></form>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header"><h1>Grupos asignados</h1></div>

        <div class="group-container">
            <div class="group-row" onclick="toggleStudents('list-601', this)">
                <div class="group-circle">601</div>
                <button class="btn-ver-estudiantes">Ver estudiantes</button>
            </div>
            <div class="students-list" id="list-601">
                <div class="student-item"><div class="student-avatar">AV</div> Adrian Rodrigo Vera Velazquez</div>
                <div class="student-item"><div class="student-avatar">LR</div> Luis Rebollar Vela</div>
                <div class="student-item"><div class="student-avatar">SO</div> Silbana Osorio Osorio</div>
            </div>
        </div>

        <div class="group-container">
            <div class="group-row" onclick="toggleStudents('list-602', this)">
                <div class="group-circle">602</div>
                <button class="btn-ver-estudiantes">Ver estudiantes</button>
            </div>
            <div class="students-list" id="list-602">
                <div class="student-item"><div class="student-avatar">MA</div> Miguel Ángel Garcia Reyes</div>
                <div class="student-item"><div class="student-avatar">JS</div> Juan Sánchez Sanchez</div>
                <div class="student-item"><div class="student-avatar">RG</div> Rosa García Peralta</div>
            </div>
        </div>

        <div class="group-container">
            <div class="group-row" onclick="toggleStudents('list-304', this)">
                <div class="group-circle">304</div>
                <button class="btn-ver-estudiantes">Ver estudiantes</button>
            </div>
            <div class="students-list" id="list-304">
                <div class="student-item"><div class="student-avatar">CP</div> Carlos Pérez Archundia</div>
                <div class="student-item"><div class="student-avatar">AL</div> Ana López Castilla</div>
                <div class="student-item"><div class="student-avatar">DM</div> Diego Martínez Rocha</div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('tutor.dashboard') }}" class="btn-regresar">Regresar</a>
            <a href="{{ route('tutor.resultados') }}" class="btn-resultados">Ir a resultados</a>
        </div>
    </div>

    <script>
        function toggleStudents(id, row) {
            const list = document.getElementById(id);
            const btn = row.querySelector('.btn-ver-estudiantes');
            
            // Cerrar otras listas si quieres que solo una esté abierta a la vez (opcional)
            // document.querySelectorAll('.students-list').forEach(l => { if(l.id !== id) l.classList.remove('show'); });

            list.classList.toggle('show');
            btn.classList.toggle('active');
            
            if(list.classList.contains('show')) {
                btn.innerText = "Cerrar lista";
            } else {
                btn.innerText = "Ver estudiantes";
            }
        }
    </script>
</body>
</html>