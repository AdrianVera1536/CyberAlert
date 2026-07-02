<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Tutor | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5);
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B;
            --color-morado-btn: #9b59b6; --danger: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; right: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }

        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; font-weight: 600; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- CONTENEDOR --- */
        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- TARJETA DE ASIGNACIÓN --- */
        .assign-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border-radius: 30px; padding: 40px; margin-bottom: 40px; box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08); }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 700; color: var(--azul-profundo); margin-bottom: 10px; font-size: 0.9rem; }
        
        .select-wrapper { position: relative; }
        .select-wrapper select { width: 100%; padding: 15px 20px; border: 2px solid rgba(64, 104, 130, 0.2); border-radius: 15px; background: white; font-size: 1rem; outline: none; appearance: none; cursor: pointer; }
        .select-wrapper::after { content: '▼'; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: var(--verde-azulado); pointer-events: none; }

        /* --- TABLA DE GESTIÓN --- */
        .table-container { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.03); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--azul-profundo); color: white; }
        th, td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #eee; }
        tr:hover { background: #fcfcfc; }

        /* --- BOTONES --- */
        .btn-action { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 14px 25px; border-radius: 50px; font-weight: 700; cursor: pointer; border: none; transition: 0.3s; font-family: 'Poppins'; }
        .btn-asignar { background: var(--ambar); color: var(--azul-profundo); width: 100%; font-size: 1.1rem; }
        .btn-asignar:hover { transform: translateY(-2px); box-shadow: 0 10px 20px var(--ambar-glow); }
        
        .btn-delete { background: #fee2e2; color: #ef4444; padding: 8px 15px; font-size: 0.85rem; }
        .btn-delete:hover { background: #ef4444; color: white; }

        .btn-regresar { background: transparent; border: 2.5px solid var(--color-morado-btn); color: var(--color-morado-btn); text-decoration: none; display: inline-flex; max-width: 250px; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: translateX(-5px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('directivo.dashboard') }}" style="color: var(--azul-profundo); font-weight: 600; margin-right: 20px;">Inicio</a>
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
            <h1>Asignar tutor a grupo</h1>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 15px; margin-bottom: 20px; border: 1px solid #34d399;">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORMULARIO DE ASIGNACIÓN --}}
        <div class="assign-card">
            <form action="{{ route('directivo.asignar.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Grupo Académico:</label>
                        <div class="select-wrapper">
                            <select name="id_grupo" required>
                                <option value="" disabled selected>Selecciona grupo...</option>
                                @foreach($grupos as $g)
                                    {{-- 🔥 CORRECCIÓN: Usamos $g->id que es el nombre real en tu BD --}}
                                    <option value="{{ $g->id }}">{{ $g->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tutor Responsable:</label>
                        <div class="select-wrapper">
                            <select name="id_tutor" required>
                                <option value="" disabled selected>Selecciona docente...</option>
                                @foreach($tutores as $t)
                                    <option value="{{ $t->id }}">{{ $t->nombre }} {{ $t->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-action btn-asignar">
                    Vincular Tutor al Grupo
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left: 8px;"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                </button>
            </form>
        </div>

        {{-- TABLA DE GESTIÓN --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Grupo</th>
                        <th>Tutor Actual</th>
                        <th style="text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gruposConTutor as $gt)
                    <tr>
                        <td style="font-weight: 600; color: var(--azul-profundo);">{{ $gt->nombre }}</td>
                        <td>{{ $gt->tutor_nombre ?? 'Sin asignar' }}</td>
                        <td style="text-align: center;">
                            {{-- 🔥 CORRECCIÓN: Validamos id_tutor para evitar errores de propiedad --}}
                            @if(isset($gt->id_tutor) && $gt->id_tutor)
                                <form action="{{ route('directivo.asignar.destroy', $gt->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('¿Quitar tutor de este grupo?')">
                                        Desvincular
                                    </button>
                                </form>
                            @else
                                <span style="color: var(--texto-claro); font-size: 0.85rem; font-style: italic;">Disponible</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="text-align: left;">
            <a href="{{ route('directivo.dashboard') }}" class="btn-action btn-regresar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 8px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Panel
            </a>
        </div>
    </div>

</body>
</html>