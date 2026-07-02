<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Quiz | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* (Se mantiene exactamente igual tu CSS) */
        :root { --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --ambar-glow: rgba(255, 179, 71, 0.5); --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 100px 5% 50px; }
        a { text-decoration: none; color: inherit; }

        .bg-mesh { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%), radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%); z-index: -1; animation: breathe 12s ease-in-out infinite alternate; }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }
        .floating-shape { position: fixed; left: -10%; top: 20%; width: 500px; height: 500px; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; animation: morph 12s ease-in-out infinite, floatY 8s ease-in-out infinite; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.15); z-index: -1; opacity: 0.5; }

        nav { position: fixed; top: 0; width: 100%; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 20px; align-items: center; font-weight: 600; }
        .btn-logout { display: inline-flex; align-items: center; gap: 8px; border: 2px solid rgba(26, 55, 77, 0.2); padding: 6px 18px; border-radius: 30px; color: var(--texto-claro); transition: all 0.3s ease; font-size: 0.9rem; background: transparent; cursor: pointer; }
        .btn-logout:hover { border-color: #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); }

        .dashboard-wrapper { width: 100%; max-width: 900px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        .quiz-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 30px; margin-bottom: 30px; display: flex; align-items: center; gap: 30px; box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); transition: all 0.3s ease; }
        .quiz-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }

        .quiz-content { flex: 1; }
        .quiz-content h3 { font-size: 1.2rem; color: var(--azul-profundo); font-weight: 700; margin-bottom: 20px; line-height: 1.4; }
        .quiz-options { display: flex; flex-direction: column; gap: 12px; }
        .quiz-option { display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 12px; border: 2px solid rgba(64, 104, 130, 0.1); cursor: pointer; transition: all 0.3s ease; color: var(--texto-oscuro); font-weight: 500; }
        .quiz-option input[type="radio"] { display: none; }
        .radio-custom { width: 20px; height: 20px; border: 2px solid var(--verde-azulado); border-radius: 50%; position: relative; }
        .quiz-option input[type="radio"]:checked + .radio-custom::after { content: ''; position: absolute; top: 50%; left: 50%; width: 10px; height: 10px; background: var(--ambar); border-radius: 50%; transform: translate(-50%, -50%); }
        .quiz-option:hover { border-color: var(--verde-azulado); background: rgba(64, 104, 130, 0.02); }
        input[type="radio"]:checked ~ span { color: var(--azul-profundo); font-weight: 700; }
        input[type="radio"]:checked ~ .quiz-option { border-color: var(--ambar); background: rgba(255, 179, 71, 0.05); }

        .quiz-image-box { width: 150px; height: 150px; background: rgba(64, 104, 130, 0.05); border-radius: 20px; display: flex; justify-content: center; align-items: center; border: 2px dashed rgba(64, 104, 130, 0.2); flex-shrink: 0; color: var(--verde-azulado); transition: all 0.3s ease; }
        .quiz-card:hover .quiz-image-box { border-color: var(--verde-azulado); background: rgba(64, 104, 130, 0.1); transform: rotate(3deg); }

        .actions { display: flex; justify-content: center; align-items: center; gap: 30px; margin-top: 20px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes pulse-btn { 0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); } 70% { box-shadow: 0 0 0 15px rgba(255, 179, 71, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); } }
        .btn-resultados { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 35px; border-radius: 50px; font-weight: 800; font-size: 1.1rem; color: var(--azul-profundo); background: var(--ambar); border: none; cursor: pointer; box-shadow: 0 10px 20px var(--ambar-glow); animation: pulse-btn 2.5s infinite; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .btn-resultados svg { transition: transform 0.3s ease; }
        .btn-resultados:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 30px var(--ambar-glow); animation: none; opacity: 1; }
        .btn-resultados:hover svg { transform: translateX(5px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0% { border-radius: 30% 70% 70% 30%; } 50% { border-radius: 70% 30% 30% 70%; } 100% { border-radius: 30% 70% 70% 30%; } }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }

        @media (max-width: 768px) { .quiz-card { flex-direction: column-reverse; text-align: center; } .quiz-image-box { margin-bottom: 20px; width: 100px; height: 100px; } .actions { flex-direction: column; width: 100%; } .btn-regresar, .btn-resultados { width: 100%; justify-content: center; } }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>
    <div class="floating-shape"></div>

    <nav>
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="{{ route('estudiante.dashboard') }}">Inicio</a>
            <form action="{{ route('logout') }}" method="POST">
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
            <h1>Realizar Quiz</h1>
            <p>Pon a prueba tus conocimientos sobre seguridad digital y prevención.</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; font-weight: 600; border: 1px solid rgba(239, 68, 68, 0.2);">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('quiz.guardar') }}" method="POST">
            @csrf

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>1. Si alguien publica un comentario ofensivo sobre un compañero en un grupo de la universidad, lo mejor es:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q1" value="a" required><div class="radio-custom"></div><span>Ignorarlo y no meterse en problemas.</span></label>
                        <label class="quiz-option"><input type="radio" name="q1" value="b"><div class="radio-custom"></div><span>Responder agresivamente para defenderlo.</span></label>
                        <label class="quiz-option"><input type="radio" name="q1" value="c"><div class="radio-custom"></div><span>Reportar el mensaje y ofrecer apoyo al compañero.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>2. El concepto de "Huella Digital" se refiere a:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q2" value="a" required><div class="radio-custom"></div><span>La contraseña que usas para desbloquear tu celular.</span></label>
                        <label class="quiz-option"><input type="radio" name="q2" value="b"><div class="radio-custom"></div><span>El rastro de datos que dejas al usar internet.</span></label>
                        <label class="quiz-option"><input type="radio" name="q2" value="c"><div class="radio-custom"></div><span>Un programa para evitar el ciberacoso.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>3. ¿Qué es el "Grooming"?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q3" value="a" required><div class="radio-custom"></div><span>Cuando un adulto se gana la confianza de un menor online con fines de abuso.</span></label>
                        <label class="quiz-option"><input type="radio" name="q3" value="b"><div class="radio-custom"></div><span>Un virus que roba las fotos de tu galería.</span></label>
                        <label class="quiz-option"><input type="radio" name="q3" value="c"><div class="radio-custom"></div><span>Insultar a alguien mientras juegan videojuegos en línea.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>4. Si recibes una foto comprometedora de un amigo sin que la persona de la foto sepa, debes:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q4" value="a" required><div class="radio-custom"></div><span>Reenviarla a tu mejor amigo para comentarla.</span></label>
                        <label class="quiz-option"><input type="radio" name="q4" value="b"><div class="radio-custom"></div><span>Guardarla en tu celular por si acaso.</span></label>
                        <label class="quiz-option"><input type="radio" name="q4" value="c"><div class="radio-custom"></div><span>Borrarla inmediatamente y no compartirla con nadie.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>5. ¿Cuál es una buena práctica para proteger tu privacidad en redes sociales?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q5" value="a" required><div class="radio-custom"></div><span>Aceptar solicitudes de amistad de cualquier persona para tener más seguidores.</span></label>
                        <label class="quiz-option"><input type="radio" name="q5" value="b"><div class="radio-custom"></div><span>Configurar tu perfil como privado y revisar quién ve tus publicaciones.</span></label>
                        <label class="quiz-option"><input type="radio" name="q5" value="c"><div class="radio-custom"></div><span>Compartir tu ubicación exacta siempre que subes una historia.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>6. El "Phishing" es un método donde los atacantes:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q6" value="a" required><div class="radio-custom"></div><span>Se hacen pasar por una entidad confiable para robar tus contraseñas.</span></label>
                        <label class="quiz-option"><input type="radio" name="q6" value="b"><div class="radio-custom"></div><span>Te bloquean el acceso a tus redes sociales.</span></label>
                        <label class="quiz-option"><input type="radio" name="q6" value="c"><div class="radio-custom"></div><span>Publican cosas negativas en tu muro.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>7. Si eres víctima de ciberacoso, el primer paso recomendado es:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q7" value="a" required><div class="radio-custom"></div><span>Borrar todas tus redes sociales para siempre.</span></label>
                        <label class="quiz-option"><input type="radio" name="q7" value="b"><div class="radio-custom"></div><span>Guardar evidencias (capturas de pantalla) y bloquear al acosador.</span></label>
                        <label class="quiz-option"><input type="radio" name="q7" value="c"><div class="radio-custom"></div><span>Amenazar al acosador de vuelta.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>8. ¿Qué significa "Sexting"?</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q8" value="a" required><div class="radio-custom"></div><span>Enviar o recibir mensajes, fotos o videos de contenido sexual explícito.</span></label>
                        <label class="quiz-option"><input type="radio" name="q8" value="b"><div class="radio-custom"></div><span>Hacer videollamadas con 6 personas a la vez.</span></label>
                        <label class="quiz-option"><input type="radio" name="q8" value="c"><div class="radio-custom"></div><span>Usar una app para conocer gente nueva cerca de ti.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>9. Un "Troll" en internet es una persona que:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q9" value="a" required><div class="radio-custom"></div><span>Busca provocar enfado, discusiones o molestar intencionalmente en foros y redes.</span></label>
                        <label class="quiz-option"><input type="radio" name="q9" value="b"><div class="radio-custom"></div><span>Es el administrador de un grupo de WhatsApp.</span></label>
                        <label class="quiz-option"><input type="radio" name="q9" value="c"><div class="radio-custom"></div><span>Reporta el contenido inapropiado a las plataformas.</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg></div>
            </div>

            <div class="quiz-card">
                <div class="quiz-content">
                    <h3>10. Una contraseña segura debería contener idealmente:</h3>
                    <div class="quiz-options">
                        <label class="quiz-option"><input type="radio" name="q10" value="a" required><div class="radio-custom"></div><span>Tu nombre y fecha de nacimiento para no olvidarla.</span></label>
                        <label class="quiz-option"><input type="radio" name="q10" value="b"><div class="radio-custom"></div><span>Letras mayúsculas, minúsculas, números y símbolos especiales, siendo larga.</span></label>
                        <label class="quiz-option"><input type="radio" name="q10" value="c"><div class="radio-custom"></div><span>La palabra "password" seguida de números como "123".</span></label>
                    </div>
                </div>
                <div class="quiz-image-box"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></div>
            </div>

            <div class="actions">
                <a href="{{ route('estudiante.material') }}" class="btn-regresar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Regresar
                </a>

                <button type="submit" class="btn-resultados">
                    Ir a ver resultados
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </div>
        </form>
    </div>
</body>
</html>