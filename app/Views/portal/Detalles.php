<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?> - Blockbuster</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bb-blue: #152238;
            --bb-accent: #1f4f8b;
            --bb-yellow: #FFCC00;
            --bb-bg: #f4f6f9;
        }

        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: var(--bb-bg); color: #333; margin: 0; }
        
        /* Navbar Estilo Blockbuster */
        .header { background-color: var(--bb-blue); padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 5px solid var(--bb-yellow); }
        .logo { color: var(--bb-yellow); font-size: 24px; font-weight: 900; text-decoration: none; letter-spacing: 1px; }
        .nav a { color: white; margin-left: 15px; text-decoration: none; font-weight: bold; }
        .nav a:hover { color: var(--bb-yellow); }

        /* Contenedor Principal */
        .container { max-width: 1100px; margin: 40px auto; padding: 30px; display: flex; gap: 40px; background-color: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Póster */
        .poster img { width: 350px; border-radius: 8px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); border: 1px solid #ddd; }
        
        /* Información */
        .info { flex: 1; }
        .info h1 { margin-top: 0; font-size: 42px; color: var(--bb-blue); font-weight: 800; }
        
        .tags { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 25px; color: #555; font-size: 15px; align-items: center; }
        .tag { background-color: var(--bb-blue); color: white; padding: 4px 12px; border-radius: 5px; font-weight: bold; }
        
        .sinopsis-title { color: var(--bb-accent); font-weight: 800; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; margin-bottom: 10px; }
        .sinopsis-text { line-height: 1.8; font-size: 17px; color: #444; }

        /* Botones */
        .btn-alquilar { display: inline-block; background-color: var(--bb-accent); color: white; padding: 15px 35px; text-decoration: none; border-radius: 8px; font-size: 18px; font-weight: bold; margin-top: 25px; transition: 0.3s; box-shadow: 0 4px 15px rgba(31, 79, 139, 0.3); }
        .btn-alquilar:hover { background-color: var(--bb-yellow); color: var(--bb-blue); transform: translateY(-3px); }
        
        .btn-login { display: inline-block; background-color: #f8f9fa; color: var(--bb-blue); padding: 15px 35px; text-decoration: none; border-radius: 8px; font-size: 17px; margin-top: 25px; border: 2px solid var(--bb-blue); font-weight: bold; }
        .btn-login:hover { background-color: var(--bb-blue); color: white; }

        /* Tráiler */
        .trailer-section { margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee; }
        .trailer-section h3 { color: var(--bb-blue); font-size: 24px; margin-bottom: 20px; }
        iframe { width: 100%; height: 500px; border: none; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        @media (max-width: 800px) {
            .container { flex-direction: column; align-items: center; }
            .poster img { width: 100%; max-width: 300px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="<?= base_url('/') ?>" class="logo">BLOCKBUSTER</a>
        <div class="nav">
            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <span style="color: white; margin-right: 15px;"><i class="fas fa-user-circle"></i> Hola, <?= esc($sesion['nombre']) ?></span>
                <a href="<?= base_url('cliente/perfil') ?>">Mi Perfil</a>
                <a href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i></a>
            <?php else: ?>
                <a href="<?= base_url('auth') ?>"><i class="fas fa-user-lock"></i> Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="poster">
            <?php 
                $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg';
                $urlImg = base_url('uploads/'.$foto);
            ?>
            <img src="<?= $urlImg ?>" alt="Carátula" onerror="this.src='https://placehold.co/400x600/152238/FFFFFF?text=Blockbuster';">
        </div>

        <div class="info">
            <h1><?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?></h1>
            
            <div class="tags">
                <span class="tag"><?= esc($item['clasificacion_streaming']) ?></span>
                <span><i class="far fa-calendar-alt"></i> <?= date('Y', strtotime($item['fecha_estreno_streaming'])) ?></span>
                <span class="badge" style="background: #e9ecef; color: #152238; padding: 5px 10px; border-radius: 4px;">
                    <?= esc(mb_convert_encoding($item['nombre_genero'], 'UTF-8', 'ISO-8859-1')) ?>
                </span>
                <span><i class="fas fa-clock"></i> 
                    <?= ($item['duracion_streaming']) ? $item['duracion_streaming'].' min' : $item['temporadas_streaming'].' Temporadas' ?>
                </span>
            </div>

            <div class="sinopsis-title">Sinopsis</div>
            <p class="sinopsis-text">
                <?= esc(mb_convert_encoding($item['sipnosis_streaming'], 'UTF-8', 'ISO-8859-1')) ?>
            </p>

            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <?php if($sesion['id_rol'] == 3): ?>
                    <a href="<?= base_url('cliente/alquiler/rentar/'.$item['id_streaming']) ?>" class="btn-alquilar">
                        <i class="fas fa-ticket-alt"></i> Alquilar Ahora
                    </a>
                <?php else: ?>
                    <div style="background-color: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin-top: 20px; border-radius: 5px;">
                        <i class="fas fa-exclamation-triangle text-warning"></i> 
                        Eres <strong><?= ($sesion['id_rol'] == 1) ? 'Administrador' : 'Operador' ?></strong>. 
                        Entra como cliente para rentar.
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div>
                    <a href="<?= base_url('auth') ?>" class="btn-login">
                        <i class="fas fa-lock me-2"></i> Inicia Sesión para Alquilar
                    </a>
                </div>
            <?php endif; ?>

            <?php if(!empty($item['trailer_streaming'])): ?>
                <?php 
                    $url = $item['trailer_streaming'];
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
                    $youtube_id = (isset($match[1])) ? $match[1] : null;
                ?>
                <?php if($youtube_id): ?>
                <div class="trailer-section">
                    <h3><i class="fab fa-youtube text-danger"></i> Tráiler Oficial</h3>
                    <iframe src="https://www.youtube.com/embed/<?= $youtube_id ?>" allowfullscreen></iframe>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>