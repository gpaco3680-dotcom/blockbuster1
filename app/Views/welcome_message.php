<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blockbuster - Streaming de Peliculas y Series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1f4f8b;
            --accent-color: #d63447;
            --surface: #ffffff;
            --surface-soft: #eef4ff;
            --text-color: #152238;
            --muted-color: #5f718e;
            --border-color: #d2e1f7;
            --card-bg: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(180deg, #f4f8ff 0%, #ffffff 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navbar */
        .navbar {
            background: var(--primary-color);
            border-bottom: 3px solid var(--accent-color);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #ffffff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(229, 9, 20, 0.2) 0%, rgba(58, 58, 58, 0.5) 100%);
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23221f1f" width="1200" height="600"/><circle cx="100" cy="100" r="80" fill="%23e50914" opacity="0.1"/><circle cx="1100" cy="500" r="100" fill="%23e50914" opacity="0.05"/></svg>');
            background-size: cover;
            background-position: center;
            border-bottom: 3px solid var(--primary-color);
            padding: 100px 0;
            text-align: center;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.5rem;
            color: #b0b0b0;
            margin-bottom: 30px;
        }

        .hero .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .hero .btn-primary:hover {
            background-color: #b30710;
            border-color: #b30710;
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(229, 9, 20, 0.4);
        }

        .hero .btn-secondary {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 13px 38px;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .hero .btn-secondary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #2f2f2f 100%);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid rgba(229, 9, 20, 0.3);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: 0 15px 40px rgba(229, 9, 20, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .feature-card h4 {
            color: var(--light-text);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #b0b0b0;
            line-height: 1.6;
        }

        /* Plans Section */
        .plans {
            padding: 80px 0;
            background-color: var(--dark-bg);
        }

        .plan-card {
            background: linear-gradient(135deg, #2f2f2f 0%, #1f1f1f 100%);
            border: 2px solid rgba(229, 9, 20, 0.3);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .plan-card.featured {
            border-color: var(--primary-color);
            transform: scale(1.05);
            box-shadow: 0 20px 50px rgba(229, 9, 20, 0.2);
        }

        .plan-card .badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 20px;
        }

        .plan-card h4 {
            color: var(--light-text);
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .plan-price {
            font-size: 2.5rem;
            color: var(--primary-color);
            font-weight: bold;
            margin: 20px 0;
        }

        .plan-price span {
            font-size: 1rem;
            color: #b0b0b0;
        }

        .plan-features {
            list-style: none;
            margin: 25px 0;
            text-align: left;
        }

        .plan-features li {
            padding: 10px 0;
            color: #b0b0b0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .plan-features li i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        .plan-card .btn {
            margin-top: 20px;
            width: 100%;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, var(--dark-bg) 100%);
            border-top: 3px solid var(--primary-color);
            padding: 30px 0;
            color: #b0b0b0;
        }

        .footer h6 {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 15px;
        }

        .footer a {
            color: #b0b0b0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .plan-card.featured {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/">
                <i class="fas fa-film"></i> Blockbuster
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">
                            <i class="fas fa-star"></i> Características
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#plans">
                            <i class="fas fa-list"></i> Planes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="/login">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="/register">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Blockbuster Streaming</h1>
            <p>Películas y Series sin límites</p>
            <div class="gap-3 d-flex justify-content-center flex-wrap">
                <a href="/register" class="btn btn-primary">
                    <i class="fas fa-play"></i> Comenzar Ahora
                </a>
                <a href="#plans" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i> Ver Planes
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container-fluid px-4">
            <h2 class="section-title">¿Por qué Blockbuster?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-tv"></i></div>
                        <h4>Contenido Ilimitado</h4>
                        <p>Acceso a cientos de películas y series en alta definición disponibles 24/7.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                        <h4>Multiplatforma</h4>
                        <p>Disfruta en tu smart TV, computadora, tablet o smartphone donde quieras.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <h4>Perfiles Personalizados</h4>
                        <p>Crea múltiples perfiles para que toda la familia disfrute con sus preferencias.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-hd"></i></div>
                        <h4>Calidad 4K</h4>
                        <p>Mira en Ultra HD con audio Dolby Atmos para la mejor experiencia visual.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-download"></i></div>
                        <h4>Descarga Offline</h4>
                        <p>Descarga tus favoritos y vélos sin conexión a internet en cualquier momento.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <h4>Soporte 24/7</h4>
                        <p>Equipo de atención al cliente disponible para resolver cualquier duda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Plans Section -->
    <section class="plans" id="plans">
        <div class="container-fluid px-4">
            <h2 class="section-title">Nuestros Planes</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="plan-card">
                        <h4>Plan Básico</h4>
                        <div class="plan-price">$9.99 <span>/mes</span></div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> 1 pantalla simultánea</li>
                            <li><i class="fas fa-check"></i> Calidad HD</li>
                            <li><i class="fas fa-check"></i> Acceso a catálogo completo</li>
                            <li><i class="fas fa-check"></i> Cancelación flexible</li>
                        </ul>
                        <a href="/register" class="btn btn-primary">Suscribirse</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="plan-card featured">
                        <span class="badge">POPULAR</span>
                        <h4>Plan Premium</h4>
                        <div class="plan-price">$15.99 <span>/mes</span></div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> 4 pantallas simultáneas</li>
                            <li><i class="fas fa-check"></i> Calidad 4K Ultra HD</li>
                            <li><i class="fas fa-check"></i> Acceso a catálogo completo</li>
                            <li><i class="fas fa-check"></i> Descargas offline</li>
                            <li><i class="fas fa-check"></i> Audio Dolby Atmos</li>
                        </ul>
                        <a href="/register" class="btn btn-primary">Suscribirse</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="plan-card">
                        <h4>Plan Familiar</h4>
                        <div class="plan-price">$19.99 <span>/mes</span></div>
                        <ul class="plan-features">
                            <li><i class="fas fa-check"></i> 6 pantallas simultáneas</li>
                            <li><i class="fas fa-check"></i> Calidad 4K Ultra HD</li>
                            <li><i class="fas fa-check"></i> Perfiles varios</li>
                            <li><i class="fas fa-check"></i> Descargas offline</li>
                            <li><i class="fas fa-check"></i> Audio Dolby Atmos</li>
                        </ul>
                        <a href="/register" class="btn btn-primary">Suscribirse</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6><i class="fas fa-film"></i> Blockbuster Streaming</h6>
                    <p>Tu plataforma de entretenimiento definitiva. Películas, series y entretenimiento de calidad.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Links Rápidos</h6>
                    <ul class="list-unstyled">
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/login">Iniciar Sesión</a></li>
                        <li><a href="/register">Registrarse</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contacto</h6>
                    <p>
                        Email: support@blockbuster.com<br>
                        Teléfono: +1 (555) 123-4567<br>
                        Chat: 24/7 disponible
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Blockbuster Streaming. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
