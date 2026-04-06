<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?>Blockbuster | Panel Operador</title>
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
            --sidebar-bg: #ffffff;
            --sidebar-border: #d63447;
        }

        body {
            background: linear-gradient(180deg, #f4f8ff 0%, #ffffff 100%);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            padding: 20px 0;
            border-right: 4px solid var(--sidebar-border);
        }

        .sidebar .nav-link {
            color: var(--text-color);
            padding: 14px 22px;
            margin: 6px 10px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: #fff;
            transform: translateX(4px);
        }

        .navbar {
            background: var(--header-bg);
            border-bottom: 3px solid var(--accent-color);
            box-shadow: 0 12px 28px rgba(31, 64, 139, 0.12);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-brand i {
            margin-right: 12px;
        }

        .main-content {
            padding: 36px;
        }

        .card {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 18px 40px var(--shadow-color);
            color: var(--text-color);
        }

        .card-header {
            background-color: var(--surface-soft);
            border-color: var(--border-color);
            color: var(--primary-color);
            font-weight: 700;
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
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(31, 64, 139, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(214, 52, 71, 0.12);
        }

        .user-section {
            padding: 24px;
            background-color: #f2f6ff;
            border-radius: 16px;
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
        }

        .btn-logout {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-logout:hover {
            background-color: #b22b40;
            border-color: #b22b40;
        }

        h2, h3, h4 {
            color: var(--primary-color);
            font-weight: 700;
        }

        .alert {
            border-radius: 14px;
        }

        .badge {
            padding: 8px 14px;
            font-weight: 700;
        }

        .form-control, .form-select {
            background-color: var(--surface);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 14px;
        }

        .form-control:focus, .form-select:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.2rem rgba(31, 64, 139, 0.16);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-color);
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/operador">
                <i class="fas fa-tasks"></i> Blockbuster - Operador
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="text-light">
                        <i class="fas fa-user-circle"></i> <?= session()->get('nombre') ?: 'Operador' ?>
                    </span>
                    <a href="/auth/logout" class="btn btn-logout btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="row g-0">
        <div class="col-md-3 col-lg-2">
            <div class="sidebar">
                <div class="user-section text-center">
                    <i class="fas fa-tasks fa-2x" style="color: var(--primary-color);"></i>
                    <p class="mt-2 mb-0 fw-bold">Operador</p>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link <?= (strpos(current_url(), '/operador/clientes') !== false) ? 'active' : '' ?>" href="/operador/clientes">
                        <i class="fas fa-users"></i> Clientes
                    </a>
                    <a class="nav-link <?= (strpos(current_url(), '/operador/pagos') !== false) ? 'active' : '' ?>" href="/operador/pagos">
                        <i class="fas fa-credit-card"></i> Validar Pagos
                    </a>
                    <a class="nav-link <?= (strpos(current_url(), '/operador/change-password') !== false) ? 'active' : '' ?>" href="/operador/change-password">
                        <i class="fas fa-key"></i> Cambiar Contraseña
                    </a>
                </nav>
            </div>
        </div>

        <div class="col-md-9 col-lg-10">
            <div class="main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>