<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario | CiberAlert</title>
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 30px 0; }
        a { text-decoration: none; color: inherit; }

        /* --- BACKGROUND ANIMADO Y FIGURAS --- */
        .bg-mesh {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%);
            z-index: -1; animation: breathe 12s ease-in-out infinite alternate;
        }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        .floating-shape {
            position: absolute; left: -10%; top: 5%; width: 500px; height: 500px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite;
            box-shadow: 0 20px 50px rgba(26, 55, 77, 0.2); z-index: 1; opacity: 0.6;
        }
        .floating-shape-2 {
            position: absolute; right: 5%; bottom: 5%; width: 250px; height: 250px;
            background: var(--ambar); border-radius: 50%;
            animation: floatY 8s ease-in-out infinite reverse; z-index: 1; opacity: 0.5; filter: blur(5px);
        }

        /* --- CONTENEDOR DEL FORMULARIO --- */
        .auth-container {
            position: relative; z-index: 10; width: 100%; max-width: 800px;
            padding: 50px 40px; background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.6); border-radius: 30px;
            box-shadow: 0 25px 50px rgba(26, 55, 77, 0.1);
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .auth-header { text-align: center; margin-bottom: 40px; }
        .auth-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); line-height: 1.2; }
        .auth-header p { color: var(--texto-claro); font-size: 1rem; margin-top: 10px; }

        /* --- GRID DEL FORMULARIO --- */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 30px;
        }

        /* --- CAMPOS DE FORMULARIO --- */
        .input-group { position: relative; }
        .input-group label {
            display: block; font-weight: 600; color: var(--azul-profundo);
            margin-bottom: 8px; font-size: 0.95rem;
        }
        
        .input-wrapper { position: relative; }
        .input-wrapper svg {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: var(--verde-azulado); opacity: 0.7; width: 20px; height: 20px;
            transition: all 0.3s ease; pointer-events: none;
        }
        
        .input-group input, .input-group select {
            width: 100%; padding: 16px 16px 16px 45px;
            border: 2px solid rgba(64, 104, 130, 0.2);
            border-radius: 15px; background: rgba(255, 255, 255, 0.9);
            font-size: 1rem; color: var(--texto-oscuro);
            transition: all 0.3s ease; outline: none;
            appearance: none; 
        }
        
        .select-wrapper::after {
            content: ''; position: absolute; right: 20px; top: 50%;
            width: 10px; height: 10px;
            border-right: 3px solid var(--verde-azulado);
            border-bottom: 3px solid var(--verde-azulado);
            transform: translateY(-50%) rotate(45deg); 
            margin-top: -3px; 
            pointer-events: none; opacity: 0.7; transition: all 0.3s ease;
        }
        
        .input-group input:focus, .input-group select:focus {
            border-color: var(--verde-azulado);
            box-shadow: 0 0 0 4px rgba(64, 104, 130, 0.1);
            background: var(--blanco);
        }
        .input-group input:focus + svg, .input-group select:focus + svg { color: var(--azul-profundo); opacity: 1; }
        .input-group select:focus ~ .select-wrapper::after { border-color: var(--azul-profundo); opacity: 1; }

        /* 🚀 CLASES PARA OCULTAR/MOSTRAR CAMPOS DINÁMICOS */
        .student-field, .tutor-field {
            display: none; 
            animation: fadeInDrop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        @keyframes fadeInDrop {
            from { opacity: 0; transform: translateY(-15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* --- BOTONES DE ACCIÓN --- */
        .actions {
            grid-column: 1 / -1; 
            display: flex; justify-content: space-between; align-items: center;
            gap: 20px; margin-top: 20px; margin-bottom: 25px;
        }

        .btn-regresar {
            flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px;
            padding: 15px 20px; border-radius: 50px; font-weight: 700; font-size: 1.05rem;
            color: var(--verde-azulado); background: transparent; border: 2px solid var(--verde-azulado);
            transition: all 0.4s ease; cursor: pointer; text-align: center;
        }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover {
            background: var(--verde-azulado); color: var(--blanco);
            transform: translateY(-3px); box-shadow: 0 10px 20px rgba(64, 104, 130, 0.2);
        }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn {
            0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); }
        }

        .btn-acceder {
            flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px;
            padding: 15px 20px; border-radius: 50px; font-weight: 800; font-size: 1.05rem;
            color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer;
            box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-align: center;
        }
        .btn-acceder svg { transition: transform 0.3s ease; }
        .btn-acceder:hover {
            transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow);
            animation: none; opacity: 1;
        }
        .btn-acceder:hover svg { transform: translateX(5px); }

        /* --- ENLACE INFERIOR --- */
        .bottom-link {
            grid-column: 1 / -1; 
            text-align: center; font-size: 0.95rem; color: var(--texto-claro);
            border-top: 1px solid rgba(64, 104, 130, 0.1); padding-top: 20px;
        }
        .bottom-link a {
            color: var(--azul-profundo); font-weight: 700; position: relative; transition: color 0.3s;
        }
        .bottom-link a::after {
            content: ''; position: absolute; width: 0; height: 2px;
            bottom: -2px; left: 0; background-color: var(--ambar); transition: width 0.3s;
        }
        .bottom-link a:hover { color: var(--ambar); }
        .bottom-link a:hover::after { width: 100%; }

        @keyframes morph {
            0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; }
        }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .auth-container { padding: 40px 25px; margin: 20px; }
            .form-grid { grid-template-columns: 1fr; gap: 20px; } 
            .actions { flex-direction: column-reverse; gap: 15px; }
            .btn-regresar, .btn-acceder { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape-2"></div>

    <div class="auth-container">
        
        <div class="auth-header">
            <h1>Registro de Usuario</h1>
            <p>Completa tus datos para crear tu cuenta institucional.</p>
        </div>

        <form action="{{ route('registro.post') }}" method="POST" class="form-grid">
            @csrf <div class="input-group">
                <label for="nombre">Nombre :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required value="{{ old('nombre') }}">
                </div>
            </div>

            <div class="input-group">
                <label for="correo">Correo :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="email" id="correo" name="email" placeholder="ejemplo@tecnm.mx" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="input-group">
                <label for="apellido_paterno">Apellido paterno :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido paterno" required>
                </div>
            </div>

            <div class="input-group">
                <label for="password">Contraseña :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <div class="input-group">
                <label for="apellido_materno">Apellido materno :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input type="text" id="apellido_materno" name="apellido_materno" placeholder="Apellido materno" required>
                </div>
            </div>

            <div class="input-group">
                <label for="telefono">Número teléfono :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <input type="tel" id="telefono" name="telefono" placeholder="10 dígitos">
                </div>
            </div>

             <div class="input-group select-wrapper">
                <label for="institucion">Institución :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"></path><path d="M9 8h1"></path><path d="M9 12h1"></path><path d="M9 16h1"></path><path d="M14 8h1"></path><path d="M14 12h1"></path><path d="M14 16h1"></path><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path></svg>
                    <select id="institucion" name="id_institucion" required>
                        <option value="" disabled selected>Selecciona institución...</option>
                        <option value="1">TecNM (Tecnológico Nacional de México)</option>
                        <option value="2">UAEMéx</option>
                        <option value="3">UNAM</option>
                        <option value="4">IPN</option>
                    </select>
                </div>
            </div>

            <div class="input-group select-wrapper">
                <label for="tipo_usuario">Selecciona tipo de usuario :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <select id="tipo_usuario" name="id_rol" required>
                        <option value="" disabled selected>Elige una opción...</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="tutor">Tutor</option>
                        <option value="directivo">Directivo</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
            </div>

            <div class="input-group select-wrapper student-field">
                <label for="carrera">Carrera :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <select id="carrera" name="carrera">
                        <option value="" disabled selected>Selecciona carrera...</option>
                        <option value="sistemas">Ing. en Sistemas Computacionales</option>
                        <option value="gestion">Ing. en Gestión Empresarial</option>
                        <option value="industrial">Ing. Industrial</option>
                        <option value="arquitectura">Arquitectura</option>
                    </select>
                </div>
            </div>

            <div class="input-group select-wrapper student-field">
                <label for="semestre">Semestre :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <select id="semestre" name="semestre">
                        <option value="" disabled selected>Selecciona semestre...</option>
                        @for ($i = 1; $i <= 9; $i++)
                            <option value="{{ $i }}">{{ $i }}er Semestre</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="input-group select-wrapper student-field">
                <label for="grupo">Grupo :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <select id="grupo" name="id_grupo">
                        <option value="" disabled selected>Selecciona grupo...</option>
                        <option value="1">Grupo A</option>
                        <option value="2">Grupo B</option>
                        <option value="3">Grupo C</option>
                    </select>
                </div>
            </div>

            <div class="input-group select-wrapper tutor-field">
                <label for="departamento">Carrera / Departamento :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    <select id="departamento" name="departamento">
                        <option value="" disabled selected>Selecciona una opción...</option>
                        <option value="sistemas_depto">Depto. Sistemas y Computación</option>
                        <option value="ciencias_basicas">Depto. Ciencias Básicas</option>
                        <option value="economico_admin">Depto. Económico-Administrativo</option>
                        <option value="psicopedagogia">Psicopedagogía / Orientación</option>
                    </select>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('login') }}" class="btn-regresar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Regresar
                </a>

                <button type="submit" class="btn-acceder">
                    Registrarse
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </button>
            </div>

            <div class="bottom-link">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('mousemove', function(e) {
            const shape1 = document.querySelector('.floating-shape');
            const shape2 = document.querySelector('.floating-shape-2');
            if(shape1 && shape2) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                shape1.style.transform = `translate(${x * -30}px, ${y * -30}px)`;
                shape2.style.transform = `translate(${x * 40}px, ${y * 40}px)`;
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const selectTipoUsuario = document.getElementById('tipo_usuario');
            const studentFields = document.querySelectorAll('.student-field');
            const tutorFields = document.querySelectorAll('.tutor-field');

            selectTipoUsuario.addEventListener('change', function() {
                studentFields.forEach(field => field.style.display = 'none');
                tutorFields.forEach(field => field.style.display = 'none');

                if (this.value === 'estudiante') {
                    studentFields.forEach(field => field.style.display = 'block');
                } else if (this.value === 'tutor') {
                    tutorFields.forEach(field => field.style.display = 'block');
                }
            });
        });
    </script>
</body>
</html>