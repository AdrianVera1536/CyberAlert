<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Movimientos | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- ESTILOS UNIFICADOS CIBERSALUD --- */
        :root {
            --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347;
            --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A;
            --texto-claro: #64748B; --color-morado-btn: #9b59b6; --danger: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape { position: fixed; left: -5%; top: 20%; width: 450px; height: 450px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 15s ease-in-out infinite alternate; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.4; }

        /* --- NAVBAR --- */
        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); padding-bottom: 2px; }

        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(231, 76, 60, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--danger); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; font-weight: 600; }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper { width: 100%; max-width: 1200px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 30px; text-align: left; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 5px; }
        .dash-header p { color: var(--texto-claro); font-size: 1rem; }

        /* --- TABLA DE AUDITORÍA --- */
        .table-container { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 25px; overflow: hidden; box-shadow: 0 10px 40px rgba(26, 55, 77, 0.08); border: 1px solid rgba(255, 255, 255, 0.9); margin-bottom: 40px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: var(--azul-profundo); color: white; padding: 18px 15px; text-align: left; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        td { padding: 18px 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 0.95rem; }
        tr:hover td { background-color: rgba(248, 250, 252, 0.5); }

        /* --- BADGES (ETIQUETAS) --- */
        .badge { padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge-insert { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-update { background-color: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* --- CAJA JSON --- */
        .json-box { 
            background-color: #0F172A; color: #4ade80; padding: 15px; 
            border-radius: 10px; font-family: 'Courier New', monospace; 
            font-size: 0.8rem; white-space: pre-wrap; margin: 0;
            max-height: 120px; overflow-y: auto; max-width: 400px;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.5);
        }
        /* Scrollbar para la caja JSON */
        .json-box::-webkit-scrollbar { width: 6px; }
        .json-box::-webkit-scrollbar-track { background: #0F172A; }
        .json-box::-webkit-scrollbar-thumb { background: #475569; border-radius: 4px; }

        /* --- BOTÓN DE REGRESO --- */
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 12px; padding: 14px 35px; border-radius: 50px; font-weight: 700; font-size: 1rem; color: var(--color-morado-btn); background: transparent; border: 2.5px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

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
            
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
            <button onclick="document.getElementById('logout-form').submit();" class="btn-logout">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Cerrar Sesión
            </button>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="dash-header">
            <h1>Auditoría de Movimientos</h1>
            <p>Registro automático de cambios estructurales en la base de datos de CiberSalud.</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Usuario Autor</th>
                        <th>Tabla Afectada</th>
                        <th>Acción</th>
                        <th>Detalles del Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $mov)
                    <tr>
                        <td style="color: var(--texto-claro); font-weight: 500;">{{ \Carbon\Carbon::parse($mov->created_at)->format('d/m/Y H:i:s') }}</td>
                        <td><strong style="color: var(--azul-profundo);">{{ $mov->usuario }}</strong></td>
                        <td style="font-weight: 600;">{{ strtoupper($mov->nombre_tabla) }}</td>
                        <td>
                            <span class="badge 
                                @if($mov->accion == 'INSERT') badge-insert 
                                @elseif($mov->accion == 'UPDATE') badge-update 
                                @else badge-delete @endif">
                                {{ $mov->accion }}
                            </span>
                        </td>
                        <td>
                            <pre class="json-box">@php echo json_encode($mov->datos_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); @endphp</pre>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($movimientos->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px 20px; color: var(--texto-claro);">
                            <div style="font-size: 3rem; margin-bottom: 15px;">🛡️</div>
                            <h3 style="color: var(--azul-profundo); margin-bottom: 5px;">El sistema de auditoría está en línea</h3>
                            <p>Aún no se han registrado movimientos recientes en la base de datos.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div style="display: flex; width: 100%;">
            <a href="{{ route('admin.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Volver al Panel Directivo
            </a>
        </div>
    </div>

</body>
</html>