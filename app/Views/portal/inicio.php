<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blockbuster - Portal Público</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #141414; color: white; margin: 0; }
        .header { background-color: #000; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { color: #e50914; font-size: 24px; font-weight: bold; }
        .nav a { color: white; margin-left: 15px; text-decoration: none; }
        .container { padding: 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .card { background-color: #222; border-radius: 8px; overflow: hidden; text-align: center; padding-bottom: 15px; }
        .card img { width: 100%; height: 300px; object-fit: cover; }
        .card h3 { font-size: 16px; margin: 10px 0; }
        .btn { background-color: #e50914; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">BLOCKBUSTER</div>
        <div class="nav">
            <?php if(isset($sesion['logged_in']) && $sesion['logged_in']): ?>
                <span>Hola, <?= $sesion['nombre'] ?></span>
                <a href="<?= base_url('auth/logout') ?>">Cerrar Sesión</a>
            <?php else: ?>
                <a href="<?= base_url('auth') ?>">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <h2>Catálogo Disponible</h2>
        
        <div class="grid">
            <?php if(!empty($catalogo)): ?>
                <?php foreach($catalogo as $item): ?>
                    <div class="card">
                        <img src="<?= base_url('assets/img/'.$item['caratula_streaming']) ?>" alt="Carátula" onerror="this.src='https://via.placeholder.com/200x300?text=Sin+Imagen'">
                        
                        <h3><?= $item['nombre_streaming'] ?></h3>
                        <p style="color: #aaa; font-size: 12px;"><?= $item['nombre_genero'] ?></p>
                        
                        <p style="font-size: 13px;">
                            <?= ($item['duracion_streaming']) ? 'Duración: '.$item['duracion_streaming'] : 'Temporadas: '.$item['temporadas_streaming'] ?>
                        </p>
                        
                        <a href="<?= base_url('streaming/detalles/'.$item['id_streaming']) ?>" class="btn">Ver Detalles</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay contenido disponible por el momento.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>