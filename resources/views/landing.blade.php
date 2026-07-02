<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiberAlert | Diagnóstico de Ciberbullying Universitario</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
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
        body { background-color: var(--gris-fondo); color: var(--texto-oscuro); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* --- UTILIDADES Y ANIMACIONES SCROLL --- */
        .reveal { opacity: 0; transform: translateY(60px); transition: all 0.8s cubic-bezier(0.5, 0, 0, 1); }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }

        /* --- BACKGROUND ANIMADO --- */
        .bg-mesh {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: radial-gradient(at 0% 0%, rgba(26, 55, 77, 0.08) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(64, 104, 130, 0.12) 0px, transparent 50%),
                        radial-gradient(at 100% 100%, rgba(255, 179, 71, 0.08) 0px, transparent 50%);
            z-index: -1; animation: breathe 12s ease-in-out infinite alternate;
        }
        @keyframes breathe { 0% { transform: scale(1); } 100% { transform: scale(1.1); } }

        /* --- NAVBAR --- */
        nav {
            position: fixed; top: 0; width: 100%; padding: 20px 5%;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000; transition: all 0.4s ease;
        }
        nav.scrolled { background: rgba(255, 255, 255, 0.95); box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .nav-logo { font-weight: 800; font-size: 1.5rem; color: var(--azul-profundo); }
        .nav-logo span { color: var(--ambar); }
        .nav-links { display: flex; gap: 30px; align-items: center; font-weight: 600; }
        .nav-links a.link-hover { position: relative; color: var(--verde-azulado); transition: color 0.3s; }
        .nav-links a.link-hover:hover { color: var(--azul-profundo); }
        
        /* 🚀 BOTÓN: INICIAR SESIÓN */
        .btn-login { 
            border: 2px solid var(--verde-azulado); 
            padding: 10px 28px; 
            border-radius: 30px; 
            color: var(--verde-azulado);
            font-weight: 700;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important; 
        }
        .btn-login::before {
            content: ''; position: absolute; top: 0; left: 0; width: 0%; height: 100%;
            background: var(--verde-azulado); transition: all 0.4s ease; z-index: -1;
        }
        .btn-login:hover { 
            color: var(--blanco) !important; 
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(64, 104, 130, 0.2);
        }
        .btn-login:hover::before { width: 100%; }

        /* --- HERO SECTION --- */
        .hero { height: 100vh; display: flex; align-items: center; padding: 0 5%; position: relative; overflow: hidden; }
        .hero-content { max-width: 700px; z-index: 10; position: relative; }
        
        .floating-shape {
            position: absolute; right: 10%; top: 25%; width: 400px; height: 400px;
            background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: morph 8s ease-in-out infinite, floatY 6s ease-in-out infinite;
            box-shadow: 0 20px 50px rgba(26, 55, 77, 0.2); z-index: 1;
        }
        .floating-shape-2 {
            position: absolute; right: 30%; top: 55%; width: 150px; height: 150px;
            background: var(--ambar); border-radius: 50%;
            animation: floatY 8s ease-in-out infinite reverse; z-index: 2; opacity: 0.8; filter: blur(2px);
        }

        .badge { display: inline-block; background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); padding: 8px 20px; border-radius: 30px; font-weight: 600; margin-bottom: 25px; border: 1px solid rgba(64, 104, 130, 0.2); animation: fadeDown 1s ease forwards; }
        .hero h1 { font-size: 4rem; font-weight: 800; line-height: 1.1; color: var(--azul-profundo); margin-bottom: 25px; animation: fadeUp 1s ease 0.2s forwards; opacity: 0; }
        .hero h1 span { color: var(--ambar); position: relative; }
        .hero h1 span::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 12px; background: var(--ambar-glow); z-index: -1; transform: skewX(-15deg); }
        .hero p { font-size: 1.25rem; color: var(--texto-claro); margin-bottom: 40px; animation: fadeUp 1s ease 0.4s forwards; opacity: 0; }
        
        /* 🚀 BOTÓN PRINCIPAL ACCEDER */
        @keyframes pulse-btn {
            0% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(255, 179, 71, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 179, 71, 0); }
        }
        
        .btn-acceder { 
            display: inline-flex; align-items: center; gap: 12px; 
            padding: 18px 45px; font-size: 1.2rem; font-weight: 800; 
            color: var(--azul-profundo); background: var(--ambar); 
            border-radius: 50px; 
            box-shadow: 0 10px 30px var(--ambar-glow); 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            animation: fadeUp 1s ease 0.6s forwards, pulse-btn 2.5s infinite; 
            opacity: 0; 
        }
        .btn-acceder svg { transition: transform 0.3s ease; }
        
        /* SOLUCIÓN AL BUG: Añadir opacity: 1 explícitamente para que no desaparezca */
        .btn-acceder:hover { 
            transform: translateY(-5px) scale(1.03); 
            box-shadow: 0 15px 40px var(--ambar-glow); 
            animation: none; 
            opacity: 1; 
        }
        .btn-acceder:hover svg { transform: translateX(6px); }

        /* --- ESTADÍSTICAS BANNER --- */
        .stats-section { 
            background: var(--azul-profundo); padding: 60px 5%; color: var(--blanco); 
            position: relative; z-index: 10; margin-top: -30px; 
            border-radius: 40px 40px 0 0; 
            box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
        }
        .stats-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); text-align: center; gap: 30px; }
        
        .stat-number {
            display: flex;
            justify-content: center;
            align-items: baseline; 
            margin-bottom: 5px;
        }
        
        .stat-number .counter { font-size: 3.5rem; color: var(--ambar); font-weight: 800; line-height: 1; }
        .stat-number .symbol { font-size: 2.2rem; color: var(--ambar); font-weight: 800; margin-left: 2px; line-height: 1; }
        
        .stat-item p { font-size: 1.05rem; opacity: 0.9; font-weight: 400; text-transform: uppercase; letter-spacing: 1px; }

        /* --- QUIÉNES SOMOS --- */
        .about-section { padding: 120px 5%; text-align: center; position: relative; z-index: 10; }
        .about-container { max-width: 900px; margin: 0 auto; }
        .about-section h2 { font-size: 3rem; color: var(--azul-profundo); margin-bottom: 30px; font-weight: 800; }
        .about-section h2::after { content: ''; display: block; width: 80px; height: 5px; background: var(--ambar); margin: 20px auto 0; border-radius: 5px; }
        .about-section p { font-size: 1.25rem; color: var(--texto-claro); line-height: 1.8; }

        /* --- ¿POR QUÉ ELEGIRNOS? --- */
        .features-section { padding: 80px 5%; max-width: 1200px; margin: 0 auto; z-index: 10; position: relative; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .feature-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); padding: 40px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.9); box-shadow: 0 20px 40px rgba(0,0,0,0.03); transition: all 0.4s ease; }
        .feature-card:hover { transform: translateY(-15px); background: var(--blanco); box-shadow: 0 30px 60px rgba(26, 55, 77, 0.1); border-color: var(--verde-azulado); }
        .f-icon { width: 60px; height: 60px; background: rgba(64, 104, 130, 0.1); color: var(--verde-azulado); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 25px; transition: all 0.4s ease; }
        .feature-card:hover .f-icon { background: var(--verde-azulado); color: var(--blanco); transform: rotate(-10deg) scale(1.1); }
        .feature-card h3 { font-size: 1.5rem; color: var(--azul-profundo); margin-bottom: 15px; }
        .feature-card p { color: var(--texto-claro); line-height: 1.6; }

        /* --- ¿CÓMO FUNCIONA? --- */
        .steps-section { padding: 120px 5%; background: linear-gradient(to bottom, transparent, rgba(64, 104, 130, 0.05)); text-align: center; position: relative; z-index: 10; }
        .steps-section h2 { font-size: 2.8rem; color: var(--azul-profundo); margin-bottom: 60px; }
        .steps-grid { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; position: relative; }
        .steps-grid::before { content: ''; position: absolute; top: 40px; left: 10%; width: 80%; height: 3px; background: rgba(64, 104, 130, 0.2); z-index: -1; }
        .step { position: relative; }
        .step-number { width: 80px; height: 80px; background: var(--blanco); border: 4px solid var(--ambar); color: var(--azul-profundo); font-size: 2rem; font-weight: 800; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; box-shadow: 0 10px 20px rgba(255, 179, 71, 0.3); }
        .step h3 { color: var(--azul-profundo); margin-bottom: 10px; }
        .step p { color: var(--texto-claro); font-size: 0.95rem; }

        /* --- BANNER CTA FINAL --- */
        .cta-section { margin: 80px 5%; background: linear-gradient(135deg, var(--verde-azulado), var(--azul-profundo)); border-radius: 40px; padding: 80px 40px; text-align: center; color: var(--blanco); position: relative; z-index: 10; box-shadow: 0 20px 50px rgba(26, 55, 77, 0.4); overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; width: 300px; height: 300px; background: var(--ambar); border-radius: 50%; filter: blur(80px); opacity: 0.2; top: -100px; right: -100px; }
        .cta-section h2 { font-size: 3rem; margin-bottom: 20px; }
        .cta-section p { font-size: 1.2rem; opacity: 0.9; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto; }
        
        .btn-white { 
            background: var(--blanco); color: var(--azul-profundo); 
            padding: 18px 45px; border-radius: 50px; font-weight: 800; font-size: 1.2rem; 
            display: inline-flex; align-items: center; gap: 10px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-white svg { transition: transform 0.3s ease; }
        .btn-white:hover { 
            transform: translateY(-5px) scale(1.05); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
            color: var(--ambar); 
        }
        .btn-white:hover svg { transform: translateX(5px); }

        /* --- FOOTER CONTACTOS --- */
        footer { background-color: var(--azul-profundo); color: var(--blanco); padding: 80px 5% 40px; position: relative; z-index: 10; }
        .footer-content { max-width: 1200px; margin: 0 auto; text-align: center; }
        .footer-title { font-size: 2rem; color: var(--ambar); margin-bottom: 40px; font-weight: 600; }
        .contact-grid { display: flex; justify-content: center; align-items: center; gap: 60px; flex-wrap: wrap; margin-bottom: 60px; }
        .contact-item { display: flex; flex-direction: column; align-items: center; gap: 15px; transition: transform 0.3s ease; }
        .contact-item:hover { transform: translateY(-5px); }
        .icon-box { width: 70px; height: 70px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--ambar); transition: all 0.3s ease; }
        .contact-item:hover .icon-box { background: var(--verde-azulado); border-color: var(--verde-azulado); color: var(--blanco); }
        .contact-text { font-size: 1.2rem; font-weight: 400; letter-spacing: 1px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; font-size: 0.9rem; color: rgba(255,255,255,0.5); }

        /* KEYFRAMES */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeDown { from { opacity: 0; transform: translateY(-40px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes morph {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }
        @keyframes floatY { 0% { transform: translateY(0); } 50% { transform: translateY(-30px); } 100% { transform: translateY(0); } }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .hero { flex-direction: column; text-align: center; justify-content: center; }
            .hero h1 { font-size: 3rem; }
            .floating-shape, .floating-shape-2 { display: none; }
            .stats-grid, .steps-grid { grid-template-columns: 1fr; gap: 40px; }
            .steps-grid::before { display: none; }
            .contact-grid { gap: 30px; flex-direction: column; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <div class="bg-mesh"></div>

    <nav id="navbar">
        <div class="nav-logo">CiberAlert<span>.</span></div>
        <div class="nav-links">
            <a href="#about" class="link-hover">Quiénes Somos</a>
            <a href="#features" class="link-hover">Ventajas</a>
            <a href="#how" class="link-hover">¿Cómo Funciona?</a>
            <a href="registro" class="link-hover">Regístrate</a>
            <a href="login" class="btn-login">Iniciar Sesión</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <div class="badge">Plataforma Segura</div>
            <h1>Diagnóstico inteligente de <span>Ciberbullying</span></h1>
            <p>Sistema web de difusion y diagnostico de riesgos de ciberbullying en estudiantes de educacion superior.</p>
            
            <a href="login" class="btn-acceder">
                Acceder
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="floating-shape"></div>
        <div class="floating-shape-2"></div>
    </header>

    <section class="stats-section reveal">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">
                    <span class="counter" data-target="100">0</span>
                    <span class="symbol">%</span>
                </div>
                <p>Confidencialidad Garantizada</p>
            </div>
            
            <div class="stat-item">
                <div class="stat-number">
                    <span class="counter" data-target="24">0</span>
                    <span class="symbol">/7</span>
                </div>
                <p>Disponibilidad del Sistema</p>
            </div>
            
            <div class="stat-item">
                <div class="stat-number">
                    <span class="counter" data-target="3">0</span>
                </div>
                <p>Niveles de Riesgo Detectados</p>
            </div>
        </div>
    </section>

    <section id="about" class="about-section reveal">
        <div class="about-container">
            <h2>¿Quiénes somos?</h2>
            <p>Somos una plataforma tecnológica dedicada al bienestar estudiantil. Nuestro objetivo es proporcionar una herramienta confidencial, rápida y científicamente validada para detectar niveles de riesgo asociados al ciberbullying, garantizando un entorno académico digital sano y respetuoso para todos los estudiantes de educación superior.</p>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="features-grid">
            <div class="feature-card reveal delay-1">
                <div class="f-icon">🔒</div>
                <h3>Privacidad Absoluta</h3>
                <p>Tus datos están encriptados. Los resultados son estrictamente personales y no se comparten con la institución sin tu permiso.</p>
            </div>
            <div class="feature-card reveal delay-2">
                <div class="f-icon">🧠</div>
                <h3>Validación Psicológica</h3>
                <p>El algoritmo de diagnóstico está basado en cuestionarios estandarizados por profesionales de la salud mental.</p>
            </div>
            <div class="feature-card reveal delay-3">
                <div class="f-icon">⚡</div>
                <h3>Resultados Inmediatos</h3>
                <p>Completa el test en menos de 5 minutos y recibe un informe detallado sobre tu nivel de exposición digital al instante.</p>
            </div>
        </div>
    </section>

    <section id="how" class="steps-section reveal">
        <h2>¿Cómo funciona el proceso?</h2>
        <div class="steps-grid">
            <div class="step reveal delay-1">
                <div class="step-number">1</div>
                <h3>Crea tu perfil</h3>
                <p>Regístrate de manera segura usando tu correo.</p>
            </div>
            <div class="step reveal delay-2">
                <div class="step-number">2</div>
                <h3>Realiza el Test</h3>
                <p>Responde un cuestionario breve sobre tus interacciones en internet y redes sociales.</p>
            </div>
            <div class="step reveal delay-3">
                <div class="step-number">3</div>
                <h3>Obtén Orientación</h3>
                <p>Recibe tu diagnóstico de riesgo y accede a recursos de apoyo psicológico si lo necesitas.</p>
            </div>
        </div>
    </section>

    <section class="cta-section reveal">
        <h2>Tu bienestar emocional es lo principal</h2>
        <p>No estás solo. Identificar el problema es el primer paso para solucionarlo. Únete a la comunidad de estudiantes que priorizan su salud digital.</p>
        
        <a href="#" class="btn-white">
            Comenzar Evaluación
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </section>

    <footer>
        <div class="footer-content reveal">
            <h3 class="footer-title">Contactos</h3>
            <div class="contact-grid">
                <div class="contact-item">
                    <div class="icon-box">📱</div>
                    <span class="contact-text">722 545 4269</span>
                </div>
                <div class="contact-item">
                    <div class="icon-box">📧</div>
                    <span class="contact-text">r05063958@gmail.com</span>
                </div>
                <div class="contact-item">
                    <div class="icon-box">🌐</div>
                    <span class="contact-text">https://ciberalert.ecosoftics.lat</span>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 CiberAlert. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // 1. Efecto Parallax del Ratón
        document.addEventListener('mousemove', function(e) {
            const shape1 = document.querySelector('.floating-shape');
            const shape2 = document.querySelector('.floating-shape-2');
            if(shape1 && shape2) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                shape1.style.transform = `translate(${x * -40}px, ${y * -40}px)`;
                shape2.style.transform = `translate(${x * 60}px, ${y * 60}px)`;
            }
        });

        // 2. Efecto Scroll en Navbar
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) { nav.classList.add('scrolled'); } 
            else { nav.classList.remove('scrolled'); }
        });

        // 3. Animación de revelado al hacer scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    if(entry.target.classList.contains('stats-section')) { runCounters(); }
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

        // 4. Animación de números
        let countersRun = false;
        function runCounters() {
            if(countersRun) return;
            countersRun = true;
            const counters = document.querySelectorAll('.counter');
            const speed = 150; 

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        }
    </script>
</body>
</html>