<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Temáticas | CiberAlert</title>
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
        .floating-shape { position: fixed; left: -10%; top: -10%; width: 600px; height: 600px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2px solid var(--ambar); padding-bottom: 2px; transition: 0.3s; }
        .nav-link-inicio:hover { color: var(--verde-azulado); }

        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; font-family: 'Poppins', sans-serif; font-weight: 600; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); }

        /* --- ALERTAS --- */
        .alert { padding: 15px; border-radius: 12px; margin-bottom: 25px; font-weight: 500; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #34d399; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; }

        /* --- GRID DE GESTIÓN --- */
        .management-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px; margin-bottom: 40px; }

        .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 30px; box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); }
        .glass-card h3 { color: var(--azul-profundo); margin-bottom: 20px; border-bottom: 2px solid var(--ambar); display: inline-block; padding-bottom: 5px; }

        .topics-list { list-style: none; max-height: 500px; overflow-y: auto; padding-right: 5px; }
        .topics-list::-webkit-scrollbar { width: 6px; }
        .topics-list::-webkit-scrollbar-thumb { background: var(--verde-azulado); border-radius: 10px; }
        
        .topic-item { padding: 12px 15px; border-radius: 12px; background: rgba(26, 55, 77, 0.03); margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; font-weight: 500; color: var(--azul-profundo); border: 1px solid transparent; transition: 0.3s; }
        .topic-item:hover { background: white; border-color: var(--verde-azulado); transform: translateX(5px); }

        /* --- FORMULARIOS --- */
        .actions-column { display: flex; flex-direction: column; gap: 25px; }
        .form-group { display: flex; flex-direction: column; gap: 10px; }
        .form-group label { font-weight: 700; color: var(--azul-profundo); font-size: 0.95rem; }
        
        .input-text, .select-custom { width: 100%; padding: 14px 20px; border-radius: 15px; border: 2px solid rgba(64, 104, 130, 0.2); background: white; outline: none; transition: 0.3s; font-size: 1rem; }
        .input-text:focus, .select-custom:focus { border-color: var(--ambar); box-shadow: 0 0 0 4px var(--ambar-glow); }

        .btn-action { padding: 14px; border-radius: 15px; border: none; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; width: 100%; font-size: 1rem; }
        .btn-add { background: var(--verde-azulado); color: white; margin-top: 5px; }
        .btn-add:hover { background: var(--azul-profundo); transform: translateY(-2px); }

        .btn-edit { background: transparent; border: 2px solid var(--verde-azulado); color: var(--verde-azulado); margin-top: 5px; }
        .btn-edit:hover { background: var(--verde-azulado); color: white; }

        .delete-section { border: 2px dashed #e74c3c; padding: 25px; border-radius: 24px; background: rgba(231, 76, 60, 0.02); }
        .delete-section .select-custom { border-color: rgba(231, 76, 60, 0.4); }
        .delete-section .select-custom:focus { border-color: #e74c3c; box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1); }
        
        .btn-delete { background: #e74c3c; color: white; }
        .btn-delete:hover { background: #c0392b; box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3); transform: translateY(-2px); }

        /* --- BOTONES INFERIORES --- */
        .footer-nav { display: flex; justify-content: flex-start; margin-top: 10px; }
        .btn-regresar { display: inline-flex; align-items: center; gap: 10px; padding: 15px 35px; border-radius: 50px; color: var(--color-morado-btn); border: 2.5px solid var(--color-morado-btn); font-weight: 700; transition: 0.3s; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: white; transform: translateX(-5px); }

        /* ANIMACIONES */
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } 100% { border-radius: 30% 70% 70% 30%; } }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }
        @media (max-width: 850px) { .management-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('directivo.dashboard') }}" class="nav-link-inicio">Inicio</a>
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
            <h1>Administrar temática pregunta</h1>
        </div>

        {{-- Alertas de Éxito o Error --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="management-grid">
            
            {{-- COLUMNA IZQUIERDA: ACCIONES CRUD --}}
            <div class="actions-column">
                
                {{-- 1. CREAR --}}
                <div class="glass-card">
                    <form action="{{ route('tematicas.store') }}" method="POST" class="form-group">
                        @csrf
                        <label>Agregar nueva temática +</label>
                        <input type="text" name="nombre" class="input-text" placeholder="Escriba el nombre..." required>
                        <button type="submit" class="btn-action btn-add">Agregar a la lista</button>
                    </form>
                </div>

                {{-- 2. EDITAR --}}
                <div class="glass-card">
                    <form action="{{ route('tematicas.update') }}" method="POST" class="form-group">
                        @csrf
                        @method('PUT')
                        <label>Editar temática</label>
                        <select name="id" class="select-custom" required>
                            <option value="" disabled selected>Selecciona temática...</option>
                            @foreach($tematicas as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="nuevo_nombre" class="input-text" placeholder="Escriba el nuevo nombre..." required>
                        <button type="submit" class="btn-action btn-edit">Actualizar nombre</button>
                    </form>
                </div>

                {{-- 3. ELIMINAR --}}
                <div class="delete-section">
                    {{-- Asegúrate que la ruta sea tematicas.destroy --}}
                    <form action="{{ route('tematicas.destroy') }}" method="POST" onsubmit="return confirm('¿De verdad quieres borrar esto?');">
                        @csrf
                        @method('DELETE') {{-- 🔥 INDISPENSABLE --}}
                        
                        <label style="color: #e74c3c;">Eliminar temática</label>
                        
                        {{-- 🔥 El name debe ser id_tematica para que el controlador lo entienda --}}
                        <select name="id_tematica" class="select-custom" required>
                            <option value="" disabled selected>Selecciona temática a eliminar...</option>
                            @foreach($tematicas as $t)
                                {{-- 🔥 El value debe ser el ID real de la base de datos --}}
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-action btn-delete">Eliminar definitivamente</button>
                    </form>
                </div>
            </div>

            {{-- COLUMNA DERECHA: LISTA DE TEMÁTICAS --}}
            <div class="glass-card">
                <h3>Temáticas actuales</h3>
                <ul class="topics-list">
                    {{-- Validamos si hay registros --}}
                    @if(isset($tematicas) && count($tematicas) > 0)
                        @foreach($tematicas as $t)
                            <li class="topic-item">
                                {{ $t->nombre }}
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--verde-azulado)" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </li>
                        @endforeach
                    @else
                        <li class="topic-item" style="color: var(--texto-claro);">No hay temáticas registradas aún.</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-nav">
            <a href="{{ route('directivo.dashboard') }}" class="btn-regresar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Regresar al Panel
            </a>
        </div>
    </div>

</body>
</html>