<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diseñar Instrumentos | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5);
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B;
            --color-morado-btn: #9b59b6; --color-peligro: #ef4444;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; right: -10%; bottom: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; }
        .btn-logout:hover { border-color: var(--color-peligro); color: var(--color-peligro); background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; }
        .header-text h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }
        
        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-nuevo { display: inline-flex; align-items: center; gap: 8px; padding: 12px 25px; border-radius: 50px; font-weight: 700; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: 0.4s; }
        .btn-nuevo:hover { transform: translateY(-3px); }

        .table-container { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 30px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); overflow-x: auto; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 15px 20px; font-weight: 700; color: var(--azul-profundo); text-transform: uppercase; font-size: 0.85rem; border-bottom: 2px solid rgba(64, 104, 130, 0.1); }
        td { padding: 20px; color: var(--texto-oscuro); border-bottom: 1px solid rgba(64, 104, 130, 0.05); }
        
        .inst-title { font-weight: 700; color: var(--azul-profundo); font-size: 1.1rem; }
        .inst-desc { font-size: 0.85rem; color: var(--texto-claro); margin-top: 4px; }
        
        .action-buttons { display: flex; gap: 10px; }
        .btn-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; transition: 0.3s; }
        .btn-edit { background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); }
        .btn-edit:hover { background: var(--verde-azulado); color: white; transform: translateY(-2px); }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: var(--color-peligro); }
        .btn-delete:hover { background: var(--color-peligro); color: white; transform: translateY(-2px); }

        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; color: var(--color-morado-btn); border: 2px solid var(--color-morado-btn); transition: 0.4s; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: translateY(-3px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
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
            <div class="header-text">
                <h1>Mis Instrumentos</h1>
                <p style="color: var(--texto-claro);">Gestiona los cuestionarios que se aplican a tus grupos.</p>
            </div>
            <a href="{{ route('tutor.instrumentos.crear') }}" class="btn-nuevo">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Crear Instrumento
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Instrumento</th>
                        <th>Preguntas</th>
                        <th>Versión</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if($instrumentos->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--texto-claro); padding: 40px;">Aún no has creado ningún instrumento.</td>
                        </tr>
                    @else
                        @foreach($instrumentos as $inst)
                        <tr>
                            <td>
                                <div class="inst-title">{{ $inst->nombre }}</div>
                                <div class="inst-desc">{{ $inst->descripcion }}</div>
                            </td>
                            
                            <td style="font-weight: 600; color: var(--texto-claro);">
                                {{ $inst->preguntas_count ?? '0' }}
                            </td>
                            
                            <td style="color: var(--texto-claro); font-size: 0.9rem; font-weight: 500;">
                                v{{ $inst->version ?? '1.0' }}
                            </td>
                            
                            <td>
                                <div class="action-buttons" style="justify-content: flex-end;">
                                    <a href="{{ route('tutor.instrumentos.editar', $inst->id_cuestionario) }}" class="btn-icon btn-edit" title="Editar">
    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
</a>
                                    
                                    <form action="{{ route('tutor.instrumentos.destroy', $inst->id_cuestionario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este instrumento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" title="Eliminar">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: center;">
            <a href="{{ route('tutor.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Dashboard
            </a>
        </div>
    </div>
</body>
</html>