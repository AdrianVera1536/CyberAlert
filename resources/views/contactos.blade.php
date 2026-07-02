<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos de Apoyo | CiberAlert</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root { --azul-profundo: #1A374D; --verde-azulado: #406882; --ambar: #FFB347; --blanco: #FFFFFF; --gris-fondo: #F8FAFC; --texto-oscuro: #0F172A; --texto-claro: #64748B; --color-morado-btn: #9b59b6; --color-psico: #e056fd; --color-ciber: #2c3e50; --color-tutor: #00b894; }
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

        .dashboard-wrapper { width: 100%; max-width: 1000px; animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; opacity: 0; transform: translateY(40px); }
        .dash-header { margin-bottom: 40px; text-align: center; }
        .dash-header h1 { font-size: 2.5rem; font-weight: 800; color: var(--azul-profundo); margin-bottom: 10px; }
        .dash-header p { font-size: 1.1rem; color: var(--texto-claro); }

        .contacts-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 50px; }
        .contact-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 24px; padding: 40px 30px; display: flex; flex-direction: column; align-items: center; text-align: center; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 10px 30px rgba(26, 55, 77, 0.05); position: relative; overflow: hidden; }
        .contact-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: var(--card-color); transform: scaleX(0); transition: transform 0.4s ease; transform-origin: center; }
        .contact-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(26, 55, 77, 0.1); background: var(--blanco); }
        .contact-card:hover::before { transform: scaleX(1); }

        .contact-icon { width: 80px; height: 80px; border-radius: 50%; display: flex; justify-content: center; align-items: center; background: rgba(64, 104, 130, 0.05); color: var(--card-color); margin-bottom: 20px; transition: all 0.3s ease; border: 2px dashed var(--card-color); }
        .contact-card:hover .contact-icon { background: var(--card-color); color: var(--blanco); border-style: solid; transform: scale(1.1); }
        .contact-card h3 { font-size: 1.4rem; color: var(--azul-profundo); font-weight: 700; margin-bottom: 15px; }
        
        .contact-info { width: 100%; display: flex; flex-direction: column; gap: 10px; }
        .info-line { display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.95rem; color: var(--texto-claro); padding: 8px 0; border-bottom: 1px solid rgba(64, 104, 130, 0.1); }
        .info-line:last-child { border-bottom: none; }
        .info-line strong { color: var(--azul-profundo); }

        .card-psico { --card-color: var(--color-psico); }
        .card-ciber { --card-color: var(--color-ciber); }
        .card-tutor { --card-color: var(--color-tutor); }

        .actions { display: flex; justify-content: center; align-items: center; margin-top: 20px; }
        .btn-regresar { display: inline-flex; justify-content: center; align-items: center; gap: 8px; padding: 16px 45px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; color: var(--color-morado-btn); background: transparent; border: 2px solid var(--color-morado-btn); transition: all 0.4s ease; cursor: pointer; text-decoration: none; }
        .btn-regresar svg { transition: transform 0.3s ease; }
        .btn-regresar:hover { background: var(--color-morado-btn); color: var(--blanco); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(155, 89, 182, 0.2); }
        .btn-regresar:hover svg { transform: translateX(-5px); }

        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes morph { 0%, 100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; } 50% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; } }
        @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }

        @media (max-width: 768px) { .contacts-grid { grid-template-columns: 1fr; } .btn-regresar { width: 100%; } }
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
            <h1>Contactos de Apoyo</h1>
            <p>No estás solo. Comunícate con los profesionales disponibles para ayudarte en cualquier momento.</p>
        </div>

        <div class="contacts-grid">
            
            <div class="contact-card card-psico">
                <div class="contact-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"></path></svg>
                </div>
                <h3>Apoyo Psicológico</h3>
                <div class="contact-info">
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span><strong>Tel:</strong> 800 911 2000</span>
                    </div>
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>lalineadelavida@salud.gob.mx</span>
                    </div>
                    <div class="info-line" style="font-size: 0.85rem;">
                        Línea de la Vida (Atención 24/7)
                    </div>
                </div>
            </div>

            <div class="contact-card card-ciber">
                <div class="contact-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h3>Policía Cibernética</h3>
                <div class="contact-info">
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span><strong>Emergencias:</strong> 088</span>
                    </div>
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>cert-mx@sspc.gob.mx</span>
                    </div>
                    <div class="info-line" style="font-size: 0.85rem;">
                        Denuncia de delitos cibernéticos
                    </div>
                </div>
            </div>

            <div class="contact-card card-tutor">
                <div class="contact-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3>Tutores (Institucional)</h3>
                <div class="contact-info">
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span><strong>Tel:</strong> (726) 266 5200</span>
                    </div>
                    <div class="info-line">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>tutoria@tecnm.mx</span>
                    </div>
                    <div class="info-line" style="font-size: 0.85rem;">
                        Acompañamiento en tu plantel
                    </div>
                </div>
            </div>

        </div>

        <div class="actions">
            <a href="{{ route('estudiante.dashboard') }}" class="btn-regresar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Regresar
            </a>
        </div>

    </div>

</body>
</html>