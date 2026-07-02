<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
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
            --danger: #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; padding: 100px 5% 50px; display: flex; flex-direction: column; align-items: center; }
        
        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%);
            z-index: -1; animation: breathe 12s ease-in-out infinite alternate;
        }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape {
            position: fixed; left: -5%; bottom: -5%; width: 450px; height: 450px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 15s ease-in-out infinite alternate;
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
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); text-decoration: none; }
        .nav-logo span { color: var(--ambar); }

        .nav-links { display: flex; gap: 25px; align-items: center; font-weight: 600; }
        .nav-link-inicio { 
            color: var(--azul-profundo); border-bottom: 2.5px solid var(--ambar); 
            padding-bottom: 2px; text-decoration: none; transition: 0.3s;
        }

        .btn-logout {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid rgba(231, 76, 60, 0.2); padding: 6px 18px; border-radius: 30px;
            color: var(--danger); transition: all 0.3s ease; font-size: 0.9rem;
            background: transparent; cursor: pointer; font-weight: 600;
        }
        .btn-logout:hover { background: var(--danger); color: white; border-color: var(--danger); }

        /* --- CONTENEDOR PRINCIPAL --- */
        .dashboard-wrapper {
            width: 100%; max-width: 1100px;
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
        }

        h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }

        /* --- CARD DEL FORMULARIO --- */
        .admin-card {
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 30px;
            padding: 40px; margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(26, 55, 77, 0.08);
        }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        
        .form-group label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px; color: var(--azul-profundo); }
        .form-group input, .form-group select { 
            width: 100%; padding: 14px; background: white; border: 1.5px solid #eee; 
            border-radius: 15px; font-size: 1rem; outline: none; transition: 0.3s;
        }
        .form-group input:focus, .form-group select:focus { border-color: var(--ambar); box-shadow: 0 0 15px rgba(255,179,71,0.15); }

        /* --- TABLA --- */
        .table-container { 
            background: white; border-radius: 25px; overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.03);
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--azul-profundo); color: white; }
        th { padding: 18px; text-align: left; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        td { padding: 18px; border-bottom: 1px solid #f8f9fa; font-size: 0.95rem; }

        /* --- BOTONES --- */
        .btn-guardar { 
            background: var(--ambar); color: var(--azul-profundo); padding: 16px 45px; 
            border-radius: 50px; font-weight: 800; border: none; cursor: pointer; 
            margin-top: 25px; transition: 0.4s; font-size: 1rem;
            box-shadow: 0 8px 20px rgba(255, 179, 71, 0.2);
        }
        .btn-guardar:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(255, 179, 71, 0.35); }

        .btn-action { padding: 10px 18px; border-radius: 12px; font-weight: 700; cursor: pointer; border: none; transition: 0.3s; font-size: 0.85rem; }
        .btn-edit-row { background: #e0f2f1; color: #00897b; margin-right: 8px; }
        .btn-delete-row { background: #fee2e2; color: #ef4444; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 10px; margin-top: 30px;
            color: var(--color-morado-btn); font-weight: 700; text-decoration: none;
            padding: 14px 35px; border-radius: 50px; border: 2.5px solid var(--color-morado-btn);
            transition: 0.3s; background: transparent;
        }
        .btn-back:hover { background: var(--color-morado-btn); color: white; transform: translateY(-3px); }

        .role-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
        .role-1 { background: #e0f2fe; color: #0369a1; }
        .role-2 { background: #dcfce7; color: #15803d; }
        .role-3 { background: #fef3c7; color: #b45309; }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 100% { border-radius: 70% 30% 30% 70%; } }
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
        <h1>Gestión de Usuarios</h1>
        <p style="margin-bottom: 30px; color: var(--texto-claro)">Administra el personal del sistema CiberSalud.</p>

        @if(session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 18px; border-radius: 20px; margin-bottom: 25px; font-weight: 600; box-shadow: 0 10px 20px rgba(0,0,0,0.02);">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario --}}
        <div class="admin-card">
            <h3 id="form-title" style="margin-bottom: 25px; color: var(--azul-profundo);">Registrar Nuevo Usuario</h3>
            <form id="user-form" action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="user-id">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre(s)</label>
                        <input type="text" name="nombre" id="input-nombre" placeholder="Ej. Lucas" required>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" id="input-apellidos" placeholder="Ej. Rey Ponce" required>
                    </div>
                    <div class="form-group">
                        <label>Email Corporativo</label>
                        <input type="email" name="email" id="input-email" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="form-group">
                        <label>Rol Asignado</label>
                        <select name="id_rol" id="input-rol" required>
                            <option value="">Seleccionar...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Directivo</option>
                            <option value="3">Tutor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" id="input-pass" placeholder="Mín. 6 caracteres">
                        <small id="pass-hint" style="display:none; color: #64748B; margin-top: 5px; display: block;">* Dejar vacío si no deseas cambiarla</small>
                    </div>
                </div>
                
                <div style="display: flex; gap: 15px;">
                    <button type="submit" class="btn-guardar">Guardar Cambios</button>
                    <button type="button" onclick="resetForm()" id="btn-cancelar" style="display:none; margin-top:25px; background: #f1f5f9; border-radius: 50px; padding: 0 30px; border: none; cursor: pointer; font-weight: 700; color: var(--texto-claro);">Cancelar</button>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $u)
                    <tr>
                        <td><strong>{{ $u->nombre }} {{ $u->apellidos }}</strong></td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <span class="role-badge role-{{ $u->id_rol }}">
                                @if($u->id_rol == 1) Admin @elseif($u->id_rol == 2) Directivo @else Tutor @endif
                            </span>
                        </td>
                        <td>
                            <button class="btn-action btn-edit-row" onclick="editUser({{ json_encode($u) }})">Editar</button>
                            <form action="{{ route('admin.usuarios.destroy', $u->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete-row" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Botón Volver al Panel --}}
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Volver al Panel Principal
        </a>
    </div>

    <script>
        function editUser(user) {
            document.getElementById('form-title').innerText = "Editando a: " + user.nombre;
            document.getElementById('user-form').action = "{{ route('admin.usuarios.update') }}";
            document.getElementById('form-method').value = "PUT";
            
            document.getElementById('user-id').value = user.id;
            document.getElementById('input-nombre').value = user.nombre;
            document.getElementById('input-apellidos').value = user.apellidos;
            document.getElementById('input-email').value = user.email;
            document.getElementById('input-rol').value = user.id_rol;
            
            document.getElementById('input-pass').required = false;
            document.getElementById('pass-hint').style.display = "block";
            document.getElementById('btn-cancelar').style.display = "block";
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('form-title').innerText = "Registrar Nuevo Usuario";
            document.getElementById('user-form').action = "{{ route('admin.usuarios.store') }}";
            document.getElementById('form-method').value = "POST";
            document.getElementById('user-form').reset();
            document.getElementById('btn-cancelar').style.display = "none";
            document.getElementById('pass-hint').style.display = "none";
        }
    </script>
</body>
</html>