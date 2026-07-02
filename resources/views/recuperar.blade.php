<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | CiberAlert</title>
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
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow: hidden; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        a { text-decoration: none; color: inherit; }

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
            position: absolute; left: -5%; top: 10%; width: 450px; height: 450px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite;
            box-shadow: 0 20px 50px rgba(26, 55, 77, 0.2); z-index: 1; opacity: 0.7;
        }
        .floating-shape-2 {
            position: absolute; right: 10%; bottom: 10%; width: 200px; height: 200px;
            background: var(--ambar); border-radius: 50%;
            animation: floatY 8s ease-in-out infinite reverse; z-index: 1; opacity: 0.6; filter: blur(5px);
        }

        /* --- CONTENEDOR DEL FORMULARIO --- */
        .auth-container {
            position: relative; z-index: 10; width: 100%; max-width: 480px;
            padding: 50px 40px; background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(25px); -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.6); border-radius: 30px;
            box-shadow: 0 25px 50px rgba(26, 55, 77, 0.1);
            animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            opacity: 0; transform: translateY(40px);
        }

        .auth-header { text-align: center; margin-bottom: 35px; }
        .auth-header .icon-lock { 
            width: 60px; height: 60px; background: rgba(64, 104, 130, 0.1);
            color: var(--verde-azulado); border-radius: 50%; display: flex;
            align-items: center; justify-content: center; margin: 0 auto 15px;
        }
        .auth-header h1 { font-size: 2rem; font-weight: 800; color: var(--azul-profundo); line-height: 1.2; }
        .auth-header p { color: var(--texto-claro); font-size: 0.95rem; margin-top: 10px; line-height: 1.5; }

        /* --- CAMPOS DE FORMULARIO --- */
        .input-group { margin-bottom: 35px; position: relative; }
        .input-group label {
            display: block; font-weight: 600; color: var(--azul-profundo);
            margin-bottom: 8px; font-size: 0.95rem;
        }
        
        .input-wrapper { position: relative; }
        .input-wrapper svg {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: var(--verde-azulado); opacity: 0.7; width: 20px; height: 20px;
            transition: all 0.3s ease;
        }
        
        .input-group input {
            width: 100%; padding: 16px 16px 16px 45px;
            border: 2px solid rgba(64, 104, 130, 0.2);
            border-radius: 15px; background: rgba(255, 255, 255, 0.9);
            font-size: 1rem; color: var(--texto-oscuro);
            transition: all 0.3s ease; outline: none;
        }
        
        .input-group input:focus {
            border-color: var(--verde-azulado);
            box-shadow: 0 0 0 4px rgba(64, 104, 130, 0.1);
            background: var(--blanco);
        }
        .input-group input:focus + svg { color: var(--azul-profundo); opacity: 1; }

        /* --- BOTONES DE ACCIÓN --- */
        .actions {
            display: flex; justify-content: space-between; align-items: center;
            gap: 20px; margin-bottom: 25px;
        }

        .btn-regresar {
            flex: 1; display: inline-flex; justify-content: center; align-items: center; gap: 8px;
            padding: 15px 20px; border-radius: 50px; font-weight: 700; font-size: 1.05rem;
            color: var(--verde-azulado); background: transparent; border: 2px solid var(--verde-azulado);
            transition: all 0.4s ease; cursor: pointer;
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
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-acceder svg { transition: transform 0.3s ease; }
        .btn-acceder:hover {
            transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow);
            animation: none; opacity: 1;
        }
        .btn-acceder:hover svg { transform: translateX(5px) translateY(-5px); }

        /* --- ENLACE INFERIOR --- */
        .bottom-link {
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

        /* KEYFRAMES */
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape-2"></div>

    <div class="auth-container">
        
        <div class="auth-header">
            <div class="icon-lock">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h1>Recuperar Contraseña</h1>
            <p>Ingresa tu correo y te enviaremos las instrucciones para restablecer tu acceso.</p>
        </div>

        @if (session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background: #fee2e2; color: #ef4444; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: center;">
        {{ $errors->first() }}
    </div>
@endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf <div class="input-group">
                <label for="correo">Correo Electrónico :</label>
                <div class="input-wrapper">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <input type="email" id="correo" name="email" placeholder="ejemplo@tecnm.mx" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('login') }}" class="btn-regresar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Regresar
                </a>

                <button type="submit" class="btn-acceder">
                    Enviar Enlace
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>

        </form>

        <div class="bottom-link">
            ¿Recordaste tu contraseña? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>

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
    </script>
</body>
</html>