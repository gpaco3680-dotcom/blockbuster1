<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?>Blockbuster | Streaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1f4f8b;
            --accent-color: #d63447;
            --surface: #ffffff;
            --surface-soft: #f3f7ff;
            --text-color: #152238;
            --muted-color: #5f718e;
            --border-color: #d2e1f7;
            --shadow-color: rgba(31, 64, 139, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(180deg, #eef5ff 0%, #f8fbff 45%, #ffffff 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 10px 30px rgba(31, 64, 139, 0.08);
            padding: 18px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-color) !important;
            transition: color 0.25s ease, transform 0.25s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: var(--accent-color) !important;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 4px;
        }

        .main-content {
            padding: 50px 0;
            min-height: calc(100vh - 100px);
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 18px;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background: var(--accent-color);
            margin-top: 10px;
            border-radius: 999px;
        }

        .card {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            box-shadow: 0 18px 40px var(--shadow-color);
            transition: transform 0.35s ease, box-shadow 0.35s ease;
            color: var(--text-color);
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 55px rgba(31, 64, 139, 0.18);
        }

        .card-header,
        .card-body,
        .card-footer {
            background: transparent;
        }

        .card-title {
            color: var(--text-color);
            font-weight: 700;
        }

        .card-text {
            color: var(--muted-color);
        }

        .btn-primary {
            background: var(--accent-color);
            border-color: var(--accent-color);
            font-weight: 700;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-primary:hover {
            background: #b32a3b;
            border-color: #b32a3b;
            transform: scale(1.03);
            box-shadow: 0 14px 30px rgba(214, 52, 71, 0.2);
        }

        .btn-secondary {
            background-color: var(--surface-soft);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: #e8efff;
        }

        .badge {
            border-radius: 999px;
            padding: 0.55em 0.9em;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-primary {
            background-color: var(--primary-color);
            color: #fff;
        }

        .badge-accent {
            background-color: var(--accent-color);
            color: #fff;
        }

        .badge-outline {
            background-color: rgba(31, 64, 139, 0.08);
            color: var(--primary-color);
            border: 1px solid rgba(31, 64, 139, 0.14);
        }

        .footer {
            background-color: #f7faff;
            border-top: 1px solid var(--border-color);
            padding: 40px 0;
            margin-top: 40px;
            color: var(--muted-color);
        }

        .footer h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 18px;
        }

        .footer a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.25s ease;
        }

        .footer a:hover {
            color: var(--accent-color);
        }

        .form-control,
        .form-select {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 12px;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(31, 64, 139, 0.16);
        }

        .form-label {
            font-weight: 700;
            color: var(--text-color);
        }

        .streaming-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .streaming-card {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            overflow: hidden;
            border-radius: 24px;
        }

        .streaming-card img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 24px 24px 0 0;
        }

        .streaming-card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .streaming-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .streaming-card-text {
            color: var(--muted-color);
            min-height: 3.6rem;
        }

        .streaming-card-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.7rem;
            margin-bottom: 1rem;
        }

        .streaming-card-actions {
            margin-top: auto;
        }

        .catalog-summary {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px 24px;
            box-shadow: 0 14px 30px rgba(31, 64, 139, 0.08);
        }

        .catalog-summary p {
            color: var(--muted-color);
            margin-bottom: 0.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            padding: 22px;
            border-radius: 20px;
            box-shadow: 0 16px 30px rgba(31, 64, 139, 0.08);
            transition: transform 0.25s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
        }

        .info-card h5 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .info-card p {
            color: var(--muted-color);
            line-height: 1.6;
        }

        .detail-card {
            border-radius: 24px;
            overflow: hidden;
        }

        .detail-card .card-body {
            padding: 30px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .detail-meta {
            display: grid;
            gap: 12px;
        }

        .detail-meta span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted-color);
        }

        .detail-meta span strong {
            color: var(--text-color);
        }

        @media (max-width: 992px) {
            .streaming-grid,
            .info-grid,
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .carousel-fade img {
                height: auto;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.4rem;
            }

            .section-title {
                font-size: 1.7rem;
            }

            .card {
                border-radius: 18px;
            }

            .streaming-card img {
                height: 220px;
            }
        }
    </style>
    <?= $this->renderSection('styles') ?>
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), '/cliente/catalogo') !== false) ? 'active' : '' ?>" href="/cliente/catalogo">
                            <i class="fas fa-compass"></i> Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), '/cliente/perfil') !== false) ? 'active' : '' ?>" href="/cliente/perfil">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos(current_url(), '/cliente/change-password') !== false) ? 'active' : '' ?>" href="/cliente/change-password">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth/logout">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid px-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6><i class="fas fa-film"></i> Blockbuster Streaming</h6>
                    <p>La mejor plataforma de streaming de películas y series.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Links Útiles</h6>
                    <ul class="list-unstyled">
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/cliente/catalogo">Catálogo</a></li>
                        <li><a href="/cliente/perfil">Perfil</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Contacto</h6>
                    <p>Email: support@blockbuster.com<br>Teléfono: +1 (555) 123-4567</p>
                </div>
            </div>
            <hr style="border-color: var(--primary-color); opacity: 0.5;">
            <div class="text-center">
                <p>&copy; 2026 Blockbuster Streaming. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>