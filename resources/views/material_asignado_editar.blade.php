<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asignación | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root { 
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5); 
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B; 
            --color-morado-btn: #9b59b6; --color-peligro: #ef4444; --verde-confirmar: #27ae60; 
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        
        .floating-shape { position: fixed; right: -10%; bottom: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }

        /* --- CONTENEDOR --- */
        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 5px; }

        /* --- TARJETA --- */
        .assign-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 40px; margin-bottom: 30px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; font-weight: 600; color: var(--azul-profundo); margin-bottom: 8px; font-size: 0.95rem; }
        
        .select-wrapper { position: relative; }
        .select-wrapper select { width: 100%; padding: 14px 15px; border: 2px solid rgba(64, 104, 130, 0.2); border-radius: 12px; background: rgba(255, 255, 255, 0.9); font-size: 1rem; color: var(--texto-oscuro); outline: none; appearance: none; transition: all 0.3s ease; cursor: pointer; }
        .select-wrapper::after { content: '▼'; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 0.8rem; color: var(--verde-azulado); pointer-events: none; }

        /* --- BOTONES --- */
        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(64, 104, 130, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(64, 104, 130, 0); } 100% { box-shadow: 0 0 0 0 rgba(64, 104, 130, 0); } }
        
        .btn-confirm { grid-column: span 2; margin-top: 20px; background: var(--verde-azulado); color: white; border: none; padding: 18px; border-radius: 15px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); animation: pulse-btn 2.5s infinite; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-confirm:hover { transform: translateY(-3px) scale(1.01); background: var(--azul-profundo); animation: none; }

        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; text-decoration: none; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        /* ANIMACIONES */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .actions { flex-direction: column; width: 100%; } .btn-regresar { width: 100%; } }
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
            <h1 style="color: var(--azul-profundo); font-weight: 800; font-size: 2.5rem;">Editar Asignación</h1>
            <p style="color: var(--texto-claro); margin-bottom: 30px;">Actualiza el grupo o la prioridad de este material.</p>
        </div>

        <div class="assign-card">
            {{-- ... (dentro de tu formulario) ... --}}
<form action="{{ route('tutor.material.update', [$asignacion->id_material, $asignacion->id_grupo]) }}" method="POST" class="form-grid">
    @csrf
    @method('PUT')

    {{-- GRUPO (Bloqueado visualmente) --}}
    <div class="input-group">
        <label>Grupo :</label>
        <div class="select-wrapper">
            <select disabled>
                <option selected>{{ $asignacion->grupo->nombre }}</option>
            </select>
        </div>
        {{-- Enviamos el ID real en un campo oculto para que el controlador no de error --}}
        <input type="hidden" name="id_grupo" value="{{ $asignacion->id_grupo }}">
    </div>

    {{-- RECURSO (Bloqueado visualmente) --}}
    <div class="input-group">
        <label>Recurso :</label>
        <div class="select-wrapper">
            <select disabled>
                <option selected>{{ $asignacion->material->titulo }}</option>
            </select>
        </div>
        {{-- Enviamos el ID real en un campo oculto --}}
        <input type="hidden" name="id_material" value="{{ $asignacion->id_material }}">
    </div>

    {{-- NIVEL DE RIESGO (Editable) --}}
    <div class="input-group">
        <label>Nivel de riesgo dirigido :</label>
        <div class="select-wrapper">
            <select name="nivel_riesgo" required>
                <option value="Todos" {{ $asignacion->nivel_riesgo == 'Todos' ? 'selected' : '' }}>Todos los estudiantes</option>
                <option value="Bajo" {{ $asignacion->nivel_riesgo == 'Bajo' ? 'selected' : '' }}>Solo Riesgo Bajo</option>
                <option value="Medio" {{ $asignacion->nivel_riesgo == 'Medio' ? 'selected' : '' }}>Solo Riesgo Medio</option>
                <option value="Alto" {{ $asignacion->nivel_riesgo == 'Alto' ? 'selected' : '' }}>Solo Riesgo Alto</option>
            </select>
        </div>
    </div>

    {{-- PRIORIDAD (Editable) --}}
    <div class="input-group">
        <label>Prioridad :</label>
        <div class="select-wrapper">
            <select name="prioridad" required>
                <option value="Baja" {{ $asignacion->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                <option value="Normal" {{ $asignacion->prioridad == 'Normal' ? 'selected' : '' }}>Normal</option>
                <option value="Alta" {{ $asignacion->prioridad == 'Alta' ? 'selected' : '' }}>Alta / Urgente</option>
            </select>
        </div>
    </div>

    <button type="submit" class="btn-confirm">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path></svg>
        Guardar Cambios
    </button>
</form>
        </div>

        <div class="actions" style="margin-top: 30px;">
            <a href="{{ route('tutor.material.index') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Cancelar
            </a>
        </div>
    </div>

</body>
</html>