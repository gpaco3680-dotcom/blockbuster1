<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blockbuster - Catálogo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Tipografía y Fondo */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; color: #333; }
        
        /* Barra de Navegación Blockbuster */
        .header-bb { background-color: #152238; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 5px solid #FFCC00; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .logo-bb { color: #FFCC00; font-size: 28px; font-weight: 900; letter-spacing: 2px; text-decoration: none; }
        .nav-bb { display: flex; align-items: center; gap: 20px; color: white; font-size: 0.95rem; }
        .btn-nav { color: white; text-decoration: none; font-weight: bold; background-color: rgba(255,255,255,0.1); padding: 8px 18px; border-radius: 6px; transition: 0.3s; }
        .btn-nav:hover { background-color: #FFCC00; color: #152238; }

        /* Contenedor Principal */
        .container { padding: 40px; max-width: 1300px; margin: 0 auto; }
        .section-title { color: #152238; font-size: 2rem; font-weight: 800; text-transform: uppercase; margin: 0 0 10px 0; }
        .title-divider { width: 80px; height: 5px; background-color: #FFCC00; margin-bottom: 30px; }

        /* Grid Congelado (Evita que se rompa) */
        .blockbuster-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 30px; }

        /* Tarjeta de Película */
        .movie-card { background-color: #ffffff; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 6px 15px rgba(0,0,0,0.08); transition: transform 0.3s ease; border-bottom: 4px solid #1f4f8b; }
        .movie-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

        /* Imagen Segura */
        .img-container { width: 100%; aspect-ratio: 2 / 3; background-color: #152238; position: relative; overflow: hidden; }
        .img-container img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .movie-card:hover .img-container img { transform: scale(1.05); }

        /* Información de la Tarjeta */
        .card-info { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
        .genre-badge { display: inline-block; background-color: #e9ecef; color: #152238; font-size: 0.8rem; padding: 4px 10px; border-radius: 4px; border: 1px solid #ced4da; margin-bottom: 10px; align-self: flex-start; font-weight: bold; }
        .movie-title { color: #152238; font-size: 1.15rem; font-weight: 800; margin: 0 0 10px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.7rem; }
        .movie-meta { font-size: 0.85rem; color: #6c757d; margin-bottom: 20px; }
        .movie-meta i { color: #1f4f8b; width: 16px; }

        /* Botón Inferior */
        .btn-container { margin-top: auto; }
        .btn-blockbuster { background-color: #1f4f8b; color: #ffffff; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; border: none; padding: 12px; border-radius: 6px; transition: 0.3s; text-align: center; display: block; text-decoration: none; font-size: 0.9rem; }
        .btn-blockbuster:hover { background-color: #FFCC00; color: #152238; }
    </style>
</head>
<body>

    <div class="header-bb">
        <a href="<?= base_url('/') ?>" class="logo-bb">BLOCKBUSTER</a>
        <div class="nav-bb">
            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <span><i class="fas fa-user-circle me-1"></i> Hola, <?= esc($sesion['nombre']) ?></span>
                <a href="<?= base_url('cliente/catalogo') ?>" class="btn-nav" style="background-color: #1f4f8b; border: 1px solid #FFCC00;">Ir a mi cuenta</a>
                <a href="<?= base_url('auth/logout') ?>" class="btn-nav">Cerrar Sesión</a>
            <?php else: ?>
                <a href="<?= base_url('auth') ?>" class="btn-nav"><i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h2 class="section-title">Catálogo Disponible</h2>
        <div class="title-divider"></div>
        
        <div class="blockbuster-grid">
            <?php if(!empty($catalogo)): ?>
                <?php foreach($catalogo as $item): ?>
                    <div class="movie-card">
                        
                        <div class="img-container">
                            <?php 
                                $nombreFoto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg';
                                $urlImagen = base_url('uploads/' . $nombreFoto);
                            ?>
                            <img src="<?= $urlImagen ?>" alt="<?= esc($item['nombre_streaming']) ?>" onerror="this.onerror=null; this.src='https://placehold.co/400x600/152238/FFCC00?text=Blockbuster';">
                        </div>
                        
                        <div class="card-info">
                            <span class="genre-badge">
                                <i class="fas fa-film"></i> <?= esc(utf8_encode($item['nombre_genero'] ?? 'General')) ?>
                            </span>
                            
                            <h3 class="movie-title"><?= esc($item['nombre_streaming']) ?></h3>
                            
                            <div classs="movie-meta">
                                <?php if(!empty($item['duracion_streaming'])): ?>
                                    <div><i class="fas fa-clock"></i> Duración: <?= esc($item['duracion_streaming']) ?></div>
                                <?php else: ?>
                                    <div><i class="fas fa-tv"></i> Temporadas: <?= esc($item['temporadas_streaming']) ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="btn-container">
                                <a href="<?= base_url('streaming/detalles/'.$item['id_streaming']) ?>" class="btn-blockbuster">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; background-color: white; border-radius: 12px; color: #6c757d;">
                    <i class="fas fa-video-slash fa-3x mb-3"></i>
                    <h3>No hay contenido disponible por el momento.</h3>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>