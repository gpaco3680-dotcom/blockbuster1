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
            --primary-color: #0056b3; /* Azul fuerte */
            --accent-color: #000000; /* Negro */
            --surface: #ffffff; /* Blanco */
            --surface-soft: #f8f9fa; /* Blanco grisáceo para inputs */
            --text-color: #141414; /* Negro casi puro */
            --muted-color: #6c757d;
            --border-color: #dee2e6;
        }

        body {
            background: linear-gradient(180deg, #eaf2ff 0%, #ffffff 100%);
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
            max-width: 580px; /* Un poco más ancho para acomodar el plan */
        }

        .register-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 22px;
            padding: 38px;
            box-shadow: 0 24px 65px rgba(0, 86, 179, 0.15);
        }

        .register-header {
            text-align: center;
            margin-bottom: 34px;
        }

        .register-header h1 {
            color: var(--accent-color);
            font-size: 2.3rem;
            font-weight: 900;
            margin: 0;
            letter-spacing: 1px;
        }

        .register-header .brand-icon {
            font-size: 3rem;
            color: var(--primary-color);
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

        .form-control, .form-select {
            background-color: var(--surface-soft);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 14px;
            padding: 12px 14px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(0, 86, 179, 0.2);
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
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border: none;
            color: white;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 14px;
            font-size: 1rem;
            width: 100%;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            letter-spacing: 0.7px;
            margin-top: 20px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.3);
            color: white;
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

        .plan-selector {
            border: 2px solid var(--primary-color);
            background-color: rgba(0, 86, 179, 0.05);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="brand-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h1>BLOCKBUSTER</h1>
                <p>Crea tu cuenta, elige tu plan y disfruta.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('/auth/register') ?>" method="post" id="registerForm">
                <?= csrf_field() ?>

                <div class="row-two-columns">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Juan" required>
                    </div>

                    <div class="form-group">
                        <label for="ap_paterno" class="form-label">Apellido Paterno *</label>
                        <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" placeholder="García" required>
                    </div>
                </div>

                <div class="row-two-columns">
                    <div class="form-group">
                        <label for="ap_materno" class="form-label">Apellido Materno *</label>
                        <input type="text" id="ap_materno" name="ap_materno" class="form-control" placeholder="López" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo" class="form-label">Sexo *</label>
                        <select id="sexo" name="sexo" class="form-select" required>
                            <option value="1">Masculino</option>
                            <option value="0">Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: white; border: 1px solid var(--border-color); color: var(--primary-color);">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" class="form-control" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="row-two-columns">
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña *</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: white; border: 1px solid var(--border-color); color: var(--primary-color);">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required minlength="6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirmar *</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: white; border: 1px solid var(--border-color); color: var(--primary-color);">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="id_plan" class="form-label" style="color: var(--primary-color);">
                        <i class="fas fa-star"></i> Elige tu Plan de Renta *
                    </label>
                    <select id="id_plan" name="id_plan" class="form-select plan-selector" required>
                        <option value="" disabled selected>Selecciona el plan que mejor se adapte a ti...</option>
                        <?php if(isset($planes)): ?>
                            <?php foreach($planes as $plan): ?>
                                <option value="<?= $plan['id_plan'] ?>">
                                    <?= esc($plan['nombre_plan']) ?> - $<?= number_format($plan['precio_plan'], 2) ?> 
                                    (Límite: <?= $plan['cantidad_limite_plan'] ?> streams)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </button>
            </form>

            <div class="register-footer">
                <p>¿Ya tienes cuenta? <a href="<?= base_url('/auth') ?>">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validar contraseñas iguales
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor, verifícalas.');
            }
        });
    </script>
</body>
</html>