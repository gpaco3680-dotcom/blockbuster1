<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($item['nombre_streaming']) ?> - Blockbuster</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bb-blue: #152238;
            --bb-accent: #1f4f8b;
            --bb-yellow: #FFCC00;
            --bb-bg: #f4f6f9;
            --bb-white: #ffffff;
            --bb-shadow: rgba(0,0,0,0.1);
        }

        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background-color: var(--bb-bg); 
            color: #333; 
            margin: 0; 
            line-height: 1.6;
        }

        .header { 
            background-color: var(--bb-blue); 
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 5px solid var(--bb-yellow); 
        }
        .logo { color: var(--bb-yellow); font-size: 24px; font-weight: 900; text-decoration: none; letter-spacing: 1px; }
        .nav a { color: white; margin-left: 15px; text-decoration: none; font-weight: bold; }
        .nav a:hover { color: var(--bb-yellow); }

        .alerts-container { max-width: 1100px; margin: 20px auto 0; padding: 0 30px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 10px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .main-container { 
            max-width: 1100px; 
            margin: 20px auto 40px; 
            padding: 30px; 
            display: flex; 
            gap: 40px; 
            background-color: var(--bb-white); 
            border-radius: 12px; 
            box-shadow: 0 10px 30px var(--bb-shadow); 
        }

        .poster-column { flex: 0 0 350px; }
        .poster-column img { 
            width: 100%; 
            border-radius: 8px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.2); 
            border: 1px solid #ddd; 
        }

        .info-column { flex: 1; }
        .info-column h1 { margin-top: 0; font-size: 42px; color: var(--bb-blue); font-weight: 800; line-height: 1.1; }
        
        .metadata-tags { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 25px; color: #555; font-size: 15px; align-items: center; }
        .badge-main { background-color: var(--bb-blue); color: white; padding: 4px 12px; border-radius: 5px; font-weight: bold; }
        .badge-secondary { background: #e9ecef; color: var(--bb-blue); padding: 5px 10px; border-radius: 4px; font-weight: 600; }

        .section-label { color: var(--bb-accent); font-weight: 800; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; margin-bottom: 8px; }
        .description-text { font-size: 17px; color: #444; margin-bottom: 30px; }

        .action-area { margin-bottom: 40px; }
        .btn { display: inline-block; padding: 15px 35px; border-radius: 8px; font-size: 17px; font-weight: bold; text-decoration: none; transition: 0.3s; cursor: pointer; border: none; }
        
        .btn-primary { background-color: var(--bb-accent); color: white; box-shadow: 0 4px 15px rgba(31, 79, 139, 0.3); }
        .btn-primary:hover { background-color: var(--bb-yellow); color: var(--bb-blue); transform: translateY(-3px); }
        
        .btn-outline { background-color: transparent; color: var(--bb-blue); border: 2px solid var(--bb-blue); }
        .btn-outline:hover { background-color: var(--bb-blue); color: white; }

        .trailer-container { margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee; }
        .video-wrapper { 
            position: relative; 
            padding-bottom: 56.25%; 
            height: 0; 
            overflow: hidden; 
            border-radius: 12px; 
            background: #000;
        }
        .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }

        @media (max-width: 900px) {
            .main-container { flex-direction: column; align-items: center; padding: 20px; }
            .poster-column { flex: 0 0 auto; width: 100%; max-width: 300px; }
            .info-column h1 { font-size: 32px; text-align: center; }
            .metadata-tags { justify-content: center; }
        }
    </style>
</head>
<body>

    <header class="header">
        <a href="<?= base_url('/') ?>" class="logo">BLOCKBUSTER</a>
        <nav class="nav">
            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <span style="color: white; margin-right: 15px;"><i class="fas fa-user-circle"></i> <?= esc($sesion['nombre']) ?></span>
                <a href="<?= base_url('cliente/perfil') ?>">Mi Perfil</a>
                <a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i></a>
            <?php else: ?>
                <a href="<?= base_url('auth') ?>"><i class="fas fa-user-lock"></i> Iniciar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="alerts-container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
    </div>

    <main class="main-container">
        <aside class="poster-column">
            <?php 
                $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg';
                $urlImg = base_url('uploads/'.$foto);
            ?>
            <img src="<?= $urlImg ?>" alt="Carátula de <?= esc($item['nombre_streaming']) ?>" onerror="this.src='https://placehold.co/400x600/152238/FFFFFF?text=Sin+Imagen';">
        </aside>

        <section class="info-column">
            <h1><?= esc($item['nombre_streaming']) ?></h1>
            
            <div class="metadata-tags">
                <span class="badge-main"><?= esc($item['clasificacion_streaming']) ?></span>
                <span class="badge-secondary"><?= esc($item['nombre_genero']) ?></span>
                <span><i class="far fa-calendar-alt"></i> <?= isset($item['fecha_estreno_streaming']) ? date('Y', strtotime($item['fecha_estreno_streaming'])) : 'N/A' ?></span>
                <span><i class="fas fa-clock"></i> <?= ($item['duracion_streaming']) ? $item['duracion_streaming'].' min' : $item['temporadas_streaming'].' Temp.' ?></span>
            </div>

            <div class="section-label">Sinopsis</div>
            <p class="description-text">
                <?= esc($item['sipnosis_streaming']) ?>
            </p>

            <div class="action-area">
                <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                    <?php if($sesion['id_rol'] == 3): ?>
                        <form action="<?= base_url('cliente/alquiler/rentar/'.$item['id_streaming']) ?>" method="POST">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-ticket-alt"></i> Alquilar Ahora
                            </button>
                        </form>
                    <?php else: ?>
                        <div style="background-color: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; border-radius: 5px;">
                            <i class="fas fa-info-circle text-warning"></i> 
                            Modo: <strong><?= ($sesion['id_rol'] == 1) ? 'Administrador' : 'Operador' ?></strong>.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?= base_url('auth') ?>" class="btn btn-outline">
                        <i class="fas fa-lock me-2"></i> Inicia Sesión para Alquilar
                    </a>
                <?php endif; ?>
            </div>

            <?php if(!empty($item['trailer_streaming'])): ?>
                <?php 
                    $url = $item['trailer_streaming']; 
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
                    $youtube_id = (isset($match[1])) ? $match[1] : null;
                ?>
                <?php if($youtube_id): ?>
                    <article class="trailer-container">
                        <h3 style="color: var(--bb-blue); font-size: 22px; margin-bottom: 20px;">
                            <i class="fab fa-youtube text-danger"></i> Tráiler Oficial
                        </h3>
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/<?= $youtube_id ?>?rel=0" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </article>
                <?php else: ?>
                    <p style="color: #dc3545; font-size: 0.9rem;">
                        <i class="fas fa-exclamation-triangle"></i> Formato de Tráiler no reconocido.
                    </p>
                <?php endif; ?>
            <?php endif; ?>

        </section>
    </main>

</body>
</html>