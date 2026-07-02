<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales Asignados | CiberAlert</title>
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
        
        /* --- BACKGROUND Y ANIMACIONES --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; right: -10%; bottom: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite; z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 1100px; animation: slideUp 0.8s forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px; }
        
        .btn-nuevo { display: inline-flex; align-items: center; gap: 8px; padding: 12px 25px; border-radius: 50px; font-weight: 700; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: 0.3s; text-decoration: none; }
        .btn-nuevo:hover { transform: translateY(-3px); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; }

        /* --- TABLA --- */
        .table-container { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 24px; padding: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 15px; font-weight: 700; color: var(--azul-profundo); border-bottom: 2px solid rgba(0,0,0,0.05); font-size: 0.9rem; text-transform: uppercase; }
        td { padding: 20px 15px; border-bottom: 1px solid rgba(0,0,0,0.05); vertical-align: middle; }

        /* --- BADGES (Etiquetas de colores) --- */
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
        
        /* Prioridad */
        .prio-alta { background: #fee2e2; color: #ef4444; }
        .prio-normal { background: #e0f2fe; color: #0ea5e9; }
        .prio-baja { background: #f0fdf4; color: #22c55e; }

        /* Riesgo */
        .riesgo-tag { background: #f1f5f9; color: var(--verde-azulado); border: 1px solid rgba(64, 104, 130, 0.2); }

        /* --- ACCIONES --- */
        .action-buttons { display: flex; gap: 10px; }
        .btn-icon { width: 35px; height: 35px; border-radius: 10px; display: flex; justify-content: center; align-items: center; transition: 0.3s; border: none; cursor: pointer; }
        .btn-edit { background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); }
        .btn-edit:hover { background: var(--verde-azulado); color: white; transform: scale(1.1); }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: var(--color-peligro); }
        .btn-delete:hover { background: var(--color-peligro); color: white; transform: scale(1.1); }

        .btn-regresar { margin-top: 30px; display: inline-flex; align-items: center; gap: 8px; padding: 15px 35px; border-radius: 50px; border: 2px solid var(--color-morado-btn); color: var(--color-morado-btn); font-weight: 700; text-decoration: none; transition: 0.3s; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: translateY(-3px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
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
                <h1>Materiales Asignados</h1>
                <p style="color: var(--texto-claro);">Gestión de recursos por grupo y nivel de riesgo.</p>
            </div>
            <a href="{{ route('tutor.material.crear') }}" class="btn-nuevo">+ Asignar Material</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Grupo</th>
                        <th>Riesgo Dirigido</th>
                        <th>Prioridad</th>
                        <th>Fecha</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asignaciones as $asig)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--azul-profundo);">{{ $asig->material->titulo }}</div>
                            <div style="font-size: 0.75rem; color: var(--texto-claro);">{{ $asig->material->tipo }}</div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--verde-azulado);">{{ $asig->grupo->nombre }}</span>
                        </td>
                        <td>
                            <span class="badge riesgo-tag">{{ $asig->nivel_riesgo ?? 'Todos' }}</span>
                        </td>
                        <td>
                            @php
                                $prioClass = match($asig->prioridad) {
                                    'Alta' => 'prio-alta',
                                    'Baja' => 'prio-baja',
                                    default => 'prio-normal',
                                };
                            @endphp
                            <span class="badge {{ $prioClass }}">{{ $asig->prioridad ?? 'Normal' }}</span>
                        </td>
                        <td style="color: var(--texto-claro); font-size: 0.85rem;">
                            {{ \Carbon\Carbon::parse($asig->fecha_asignacion)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="action-buttons" style="justify-content: flex-end;">
                                {{-- Editar --}}
                                <a href="{{ route('tutor.material.editar', [$asig->id_material, $asig->id_grupo]) }}" class="btn-icon btn-edit" title="Editar">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('tutor.material.destroy', [$asig->id_material, $asig->id_grupo]) }}" method="POST" onsubmit="return confirm('¿Eliminar esta asignación?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; padding: 40px; color: var(--texto-claro);">No hay materiales asignados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: center; margin-top: 20px;">
            <a href="{{ route('tutor.dashboard') }}" class="btn-regresar">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Dashboard
            </a>
        </div>
    </div>
</body>
</html>