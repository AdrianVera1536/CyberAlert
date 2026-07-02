<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Instrumentos | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- ESTILOS UNIFICADOS CIBERSALUD --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A;
            --texto-claro: #64748B; --color-morado-btn: #9b59b6; --danger: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; padding: 100px 5% 50px; display: flex; flex-direction: column; align-items: center; }
        
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; }
        .floating-shape { position: fixed; right: -5%; top: 10%; width: 450px; height: 450px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite alternate; z-index: -1; opacity: 0.4; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); text-decoration: none; }
        .nav-logo span { color: var(--ambar); }

        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); padding-bottom: 2px; text-decoration: none; transition: 0.3s; }

        /* Estilos del botón Cerrar Sesión */
        .btn-logout {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid rgba(231, 76, 60, 0.2); padding: 6px 18px; border-radius: 30px;
            color: var(--danger); transition: all 0.3s ease; font-size: 0.9rem;
            background: transparent; cursor: pointer; font-weight: 600;
        }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s ease forwards; }

        .admin-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px);
            border-radius: 30px; padding: 40px; margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08);
            display: grid; grid-template-columns: 1fr 220px; gap: 30px;
        }

        .inputs-column { display: flex; flex-direction: column; gap: 20px; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 12px 0; background: transparent; border: none; border-bottom: 2.5px solid var(--azul-profundo); font-size: 1.1rem; outline: none; transition: 0.3s;
        }
        .form-group input:focus, .form-group textarea:focus { border-bottom-color: var(--ambar); }

        .table-container { background: white; border-radius: 25px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--azul-profundo); color: white; padding: 15px; text-align: left; font-size: 0.8rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #f8f9fa; }

        .btn-guardar { background: var(--ambar); color: var(--azul-profundo); padding: 16px 45px; border-radius: 50px; font-weight: 800; border: none; cursor: pointer; transition: 0.4s; width: 100%; }
        .btn-guardar:hover { transform: translateY(-3px); box-shadow: 0 10px 20px var(--ambar-glow); }
        
        .btn-back { display: inline-flex; align-items: center; gap: 10px; margin-top: 30px; color: var(--color-morado-btn); font-weight: 700; text-decoration: none; padding: 12px 30px; border-radius: 50px; border: 2.5px solid var(--color-morado-btn); transition: 0.3s; }
        .btn-back:hover { background: var(--color-morado-btn); color: white; }

        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 100% { border-radius: 70% 30% 30% 70%; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <a href="{{ route('admin.dashboard') }}" class="nav-logo">CiberAlert<span>.</span></a>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-inicio">Inicio</a>
            
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                @csrf
            </form>
            <button onclick="document.getElementById('logout-form').submit();" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Cerrar Sesión
            </button>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <h1>Administrar Instrumentos</h1>
        <p style="margin-bottom: 30px; color: var(--texto-claro)">Gestiona los bancos de preguntas para los diagnósticos.</p>

        @if(session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 15px; margin-bottom: 20px; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        <div class="admin-card">
            <form id="inst-form" action="{{ route('admin.instrumentos.store') }}" method="POST" style="display: contents;">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="inst-id">

                <div class="inputs-column">
                    <div class="form-group">
                        <input type="text" name="nombre" id="input-nombre" placeholder="Nombre del Instrumento" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descripcion" id="input-descripcion" placeholder="Descripción breve del objetivo" rows="2" style="font-family: inherit;" required></textarea>
                    </div>
                    <button type="button" onclick="resetForm()" id="btn-cancelar" style="display:none; align-self: flex-start; background: #eee; border:none; padding: 5px 15px; border-radius: 10px; cursor: pointer;">Cancelar Edición</button>
                </div>

                <div style="display: flex; align-items: center;">
                    <button type="submit" class="btn-guardar">Guardar Instrumento</button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Instrumento</th>
                        <th>Descripción</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instrumentos as $i)
                    <tr>
                        <td><strong>{{ $i->nombre }}</strong></td>
                        <td style="color: var(--texto-claro); font-size: 0.85rem;">{{ $i->descripcion }}</td>
                        <td>
                            <button onclick="editInst({{ json_encode($i) }})" style="background:#e0f2f1; color:#00897b; border:none; padding:6px 12px; border-radius:8px; cursor:pointer; font-weight:700;">Editar</button>
                            <form action="{{ route('admin.instrumentos.destroy', $i->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar instrumento?')" style="background:#fee2e2; color:#ef4444; border:none; padding:6px 12px; border-radius:8px; cursor:pointer; font-weight:700;">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Volver al Panel Principal
        </a>
    </div>

    <script>
        function editInst(inst) {
            document.getElementById('inst-form').action = "{{ route('admin.instrumentos.update') }}";
            document.getElementById('form-method').value = "PUT";
            document.getElementById('inst-id').value = inst.id;
            document.getElementById('input-nombre').value = inst.nombre;
            document.getElementById('input-descripcion').value = inst.descripcion;
            document.getElementById('btn-cancelar').style.display = "block";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('inst-form').action = "{{ route('admin.instrumentos.store') }}";
            document.getElementById('form-method').value = "POST";
            document.getElementById('inst-form').reset();
            document.getElementById('btn-cancelar').style.display = "none";
        }
    </script>
</body>
</html>