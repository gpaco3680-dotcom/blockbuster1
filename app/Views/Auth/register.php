<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse - Blockbuster</title>
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
        }

        body {
            background: linear-gradient(180deg, #f4f8ff 0%, #eaf2ff 45%, #ffffff 100%);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            width: 100%;
            max-width: 520px;
        }

        .register-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            padding: 38px;
            box-shadow: 0 24px 65px rgba(31, 64, 139, 0.12);
        }

        .register-header {
            text-align: center;
            margin-bottom: 34px;
        }

        .register-header h1 {
            color: var(--primary-color);
            font-size: 2.3rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.8px;
        }

        .register-header .brand-icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .register-header p {
            color: var(--muted-color);
            font-size: 0.95rem;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            color: var(--text-color);
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            background-color: var(--surface-soft);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 14px;
            padding: 12px 14px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control::placeholder {
            color: rgba(21, 34, 56, 0.4);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(31, 64, 139, 0.16);
        }

        .row-two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 576px) {
            .row-two-columns {
                grid-template-columns: 1fr;
            }
        }

        .btn-register {
            background: linear-gradient(135deg, #d63447 0%, #b2233c 100%);
            border: none;
            color: white;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 14px;
            font-size: 1rem;
            width: 100%;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            letter-spacing: 0.7px;
            margin-top: 12px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(214, 52, 71, 0.22);
        }

        .register-footer {
            text-align: center;
            margin-top: 24px;
        }

        .register-footer p {
            color: var(--muted-color);
            margin: 0;
            font-size: 0.95rem;
        }

        .register-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 700;
        }

        .register-footer a:hover {
            color: var(--accent-color);
        }

        .alert {
            border-radius: 14px;
            font-size: 0.95rem;
        }

        .alert-danger {
            background-color: rgba(214, 52, 71, 0.1);
            border-color: rgba(214, 52, 71, 0.2);
            color: #8b2332;
        }

        .alert-success {
            background-color: rgba(31, 64, 139, 0.1);
            border-color: rgba(31, 64, 139, 0.2);
            color: #1f4f8b;
        }

        .password-strength {
            font-size: 0.9rem;
            margin-top: 5px;
            color: var(--muted-color);
        }

        .strength-weak {
            color: #d63447;
        }

        .strength-medium {
            color: #f08f1c;
        }

        .strength-strong {
            color: #1f4f8b;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="brand-icon">
                    <i class="fas fa-film"></i>
                </div>
                <h1>Blockbuster</h1>
                <p>Crea tu cuenta y comienza a disfrutar</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/register" method="post" id="registerForm">
                <?= csrf_field() ?>

                <div class="row-two-columns">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Juan" required>
                    </div>

                    <div class="form-group">
                        <label for="ap" class="form-label">Apellido Paterno *</label>
                        <input type="text" id="ap" name="ap" class="form-control" placeholder="García" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="am" class="form-label">Apellido Materno *</label>
                    <input type="text" id="am" name="am" class="form-control" placeholder="López" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: transparent; border: 1px solid rgba(229, 9, 20, 0.3); color: var(--primary-color);">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña *</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: transparent; border: 1px solid rgba(229, 9, 20, 0.3); color: var(--primary-color);">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required minlength="6">
                    </div>
                    <div class="password-strength" id="strengthIndicator"></div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: transparent; border: 1px solid rgba(229, 9, 20, 0.3); color: var(--primary-color);">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <label class="form-check-label" style="color: #b0b0b0; font-size: 0.85rem; margin-top: 15px;">
                    <input type="checkbox" class="form-check-input" name="terms" required>
                    Acepto los <a href="#" style="color: var(--primary-color); text-decoration: none;">términos y condiciones</a>
                </label>

                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </button>
            </form>

            <div class="register-footer">
                <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strength = document.getElementById('strengthIndicator');
            
            if (password.length < 6) {
                strength.textContent = '';
            } else if (password.length < 8) {
                strength.innerHTML = '<span class="strength-weak"><i class="fas fa-exclamation-circle"></i> Contraseña débil</span>';
            } else if (password.length < 12 || !/[A-Z]/.test(password) || !/[0-9]/.test(password)) {
                strength.innerHTML = '<span class="strength-medium"><i class="fas fa-info-circle"></i> Contraseña media</span>';
            } else {
                strength.innerHTML = '<span class="strength-strong"><i class="fas fa-check-circle"></i> Contraseña fuerte</span>';
            }
        });

        // Validate password match
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>