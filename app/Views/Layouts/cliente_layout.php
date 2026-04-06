<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?>Blockbuster | Mi Cuenta</title>
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
            --shadow-color: rgba(31, 64, 139, 0.12);
            --header-bg: #1f4f8b;
            --footer-bg: #f4f8ff;
        }

        body {
            background: linear-gradient(180deg, #f4f8ff 0%, #ffffff 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: var(--header-bg);
            border-bottom: 3px solid var(--accent-color);
            padding: 18px 0;
            box-shadow: 0 12px 28px rgba(31, 64, 139, 0.12);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .nav-link {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.85) !important;
            transition: color 0.25s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff !important;
            border-bottom: 2px solid #fff;
        }

        .main-content {
            padding: 40px 0;
            min-height: calc(100vh - 100px);
        }

        .card {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            box-shadow: 0 18px 40px var(--shadow-color);
            color: var(--text-color);
        }

        .card-header {
            background-color: var(--surface-soft);
            border-color: var(--border-color);
            border-bottom: 2px solid var(--accent-color);
        }

        .card-header h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background-color: #b22b40;
            border-color: #b22b40;
        }

        .table {
            color: var(--text-color);
            background-color: #fff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(31, 64, 139, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(214, 52, 71, 0.12);
        }

        .footer {
            background: var(--footer-bg);
            border-top: 2px solid var(--accent-color);
            padding: 30px 0;
            color: var(--muted-color);
            margin-top: 40px;
        }

        .footer h6 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .footer a {
            color: var(--muted-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--accent-color);
        }

        h2, h3, h4 {
            color: var(--primary-color);
            font-weight: 700;
        }

        .badge {
            padding: 8px 12px;
            font-weight: 700;
        }

        .alert {
            border-radius: 14px;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="/cliente/catalogo">
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
                    <p>Disfruta del mejor entretenimiento en streaming.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Links Útiles</h6>
                    <ul class="list-unstyled">
                        <li><a href="/cliente/catalogo">Catálogo</a></li>
                        <li><a href="/cliente/perfil">Mi Perfil</a></li>
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