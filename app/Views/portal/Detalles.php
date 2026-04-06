<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $item['nombre_streaming'] ?> - Blockbuster</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #141414; color: white; margin: 0; }
        .header { background-color: #000; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { color: #e50914; font-size: 24px; font-weight: bold; text-decoration: none; }
        .container { max-width: 1000px; margin: 40px auto; padding: 20px; display: flex; gap: 40px; background-color: #222; border-radius: 8px; }
        .poster img { width: 300px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.5); }
        .info { flex: 1; }
        .info h1 { margin-top: 0; font-size: 36px; }
        .tags { display: flex; gap: 10px; margin-bottom: 20px; color: #aaa; font-size: 14px; align-items: center; }
        .tag { border: 1px solid #aaa; padding: 3px 8px; border-radius: 3px; }
        .btn-alquilar { display: inline-block; background-color: #e50914; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .btn-login { display: inline-block; background-color: #333; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-size: 18px; margin-top: 20px; border: 1px solid #555; }
        .trailer { margin-top: 40px; }
        iframe { width: 100%; height: 500px; border: none; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="header">
        <a href="<?= base_url('/') ?>" class="logo">BLOCKBUSTER</a>
        <div class="nav">
            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <span style="margin-right: 15px;">Hola, <?= $sesion['nombre'] ?></span>
                <a href="<?= base_url('cliente/perfil') ?>" style="color: white; margin-right: 15px;">Mi Perfil</a>
                <a href="<?= base_url('auth/logout') ?>" style="color: white;">Cerrar Sesión</a>
            <?php else: ?>
                <a href="<?= base_url('auth') ?>" style="color: white;">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="poster">
            <img src="<?= base_url('assets/img/'.$item['caratula_streaming']) ?>" alt="Carátula" onerror="this.src='https://via.placeholder.com/300x450?text=Sin+Imagen'">
        </div>

        <div class="info">
            <h1><?= $item['nombre_streaming'] ?></h1>
            
            <div class="tags">
                <span class="tag"><?= $item['clasificacion_streaming'] ?></span>
                <span><?= date('Y', strtotime($item['fecha_estreno_streaming'])) ?></span>
                <span><?= $item['nombre_genero'] ?></span>
                <span>
                    <?= ($item['duracion_streaming']) ? $item['duracion_streaming'].' min' : $item['temporadas_streaming'].' Temporadas' ?>
                </span>
            </div>

            <h3>Sinopsis</h3>
            <p style="line-height: 1.6;"><?= $item['sipnosis_streaming'] ?></p>

            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <?php if($sesion['id_rol'] == 3): ?>
                    <a href="<?= base_url('cliente/alquiler/rentar/'.$item['id_streaming']) ?>" class="btn-alquilar">Alquilar Ahora</a>
                <?php else: ?>
                    <p style="color: #ffcc00; margin-top: 20px;">* Eres <?= ($sesion['id_rol'] == 1) ? 'Administrador' : 'Operador' ?>. Solo los clientes pueden realizar alquileres.</p>
                <?php endif; ?>
            <?php else: ?>
                <div>
                    <a href="<?= base_url('auth') ?>" class="btn-login">Inicia Sesión para Alquilar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!empty($item['trailer_streaming'])): ?>
        <?php 
            // Truco rápido de PHP para convertir link de YouTube a Embed
            $url = $item['trailer_streaming'];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
            $youtube_id = (isset($match[1])) ? $match[1] : null;
        ?>
        <?php if($youtube_id): ?>
        <div class="container trailer">
            <div style="width: 100%;">
                <h3>Tráiler Oficial</h3>
                <iframe src="https://www.youtube.com/embed/<?= $youtube_id ?>" allowfullscreen></iframe>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>