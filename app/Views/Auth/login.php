<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - Blockbuster</title>
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
        }

        body {
            background: linear-gradient(180deg, #f4f8ff 0%, #ffffff 100%);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 24px;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            margin-top: 40px; /* Margen por si dejas el letrero verde de conexión */
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 44px;
            box-shadow: 0 24px 65px var(--shadow-color);
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 2.6rem;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-header .brand-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 12px;
        }

        .login-header p {
            color: var(--muted-color);
            font-size: 1rem;
            margin-top: 12px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            color: var(--text-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-control {
            background-color: var(--surface-soft);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 14px;
            padding: 14px 16px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(21, 34, 56, 0.45);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(31, 64, 139, 0.16);
            outline: none;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent-color) 0%, #b22b40 100%);
            border: none;
            color: white;
            font-weight: 800;
            padding: 14px 30px;
            border-radius: 14px;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(214, 52, 71, 0.2);
            color: white;
        }

        .login-footer {
            text-align: center;
            margin-top: 28px;
        }

        .login-footer p {
            color: var(--muted-color);
            margin: 0;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 700;
        }

        .login-footer a:hover {
            color: var(--accent-color);
        }

        .alert {
            border-radius: 14px;
            border: 1px solid rgba(31, 64, 139, 0.12);
            margin-bottom: 24px;
            padding: 12px 16px;
        }

        .alert-danger {
            background: rgba(214, 52, 71, 0.12);
            color: #742234;
            border-left: 4px solid var(--accent-color);
        }

        .input-group-text {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--primary-color);
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0;
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label {
            color: var(--muted-color);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-icon">
                    <i class="fas fa-film"></i>
                </div>
                <h1>Blockbuster</h1>
                <p>Streaming de Peliculas y Series</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="remember-me">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Recuérdame
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
            </form>

            <div class="login-footer">
                <p>¿No tienes cuenta? <a href="<?= base_url('register') ?>">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>