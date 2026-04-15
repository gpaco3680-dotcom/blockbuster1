<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --bb-blue: #152238;
        --bb-accent: #1f4f8b;
        --bb-yellow: #FFCC00;
        --bb-bg: #f4f6f9;
        --bb-red: #dc3545;
    }

    body { background-color: var(--bb-bg); }

    /* Secciones de Título */
    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        margin-top: 40px;
    }

    .section-header h3 {
        color: var(--bb-blue);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0;
        margin-right: 15px;
    }

    .section-line {
        flex-grow: 1;
        height: 2px;
        background: linear-gradient(to right, var(--bb-yellow), transparent);
    }

    /* Contenedor de Cuadrícula */
    .blockbuster-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    /* Tarjeta de Película Mejorada */
    .movie-card {
        background-color: #ffffff;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .movie-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    /* Badge de "Nuevo" */
    .badge-new {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--bb-red);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.7rem;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .img-container {
        width: 100%;
        aspect-ratio: 2 / 3;
        background-color: var(--bb-blue);
        overflow: hidden;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .movie-card:hover .img-container img { transform: scale(1.1); }

    .card-info { padding: 15px; display: flex; flex-direction: column; flex-grow: 1; }

    .movie-title {
        color: var(--bb-blue);
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 5px;
        min-height: 2.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-blockbuster {
        background-color: var(--bb-accent);
        color: #ffffff;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        transition: 0.3s;
        margin-top: auto;
    }

    .btn-blockbuster:hover {
        background-color: var(--bb-yellow);
        color: var(--bb-blue);
    }
</style>

<div class="container mt-5">
    
    <header class="mb-5 text-center">
        <h1 class="fw-bold" style="color: var(--bb-blue); letter-spacing: 2px;">PORTAL DE STREAMING</h1>
        <p class="text-muted">Explora el mejor contenido disponible para ti</p>
        <div class="mx-auto" style="width: 100px; height: 5px; background-color: var(--bb-yellow);"></div>
    </header>

    <div class="section-header">
        <h3><i class="fas fa-clock text-danger me-2"></i>Recién Agregados</h3>
        <div class="section-line"></div>
    </div>
    <div class="blockbuster-grid">
        <?php foreach ($recientes as $item): ?>
            <article class="movie-card">
                <div class="badge-new">NUEVO</div>
                <div class="img-container">
                    <?php $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg'; ?>
                    <img src="<?= base_url('uploads/' . $foto) ?>" alt="<?= esc($item['nombre_streaming']) ?>" onerror="this.src='https://placehold.co/400x600/152238/FFCC00?text=Blockbuster';">
                </div>
                <div class="card-info">
                    <h3 class="movie-title"><?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?></h3>
                    <a href="<?= base_url('cliente/catalogo/detalle/' . $item['id_streaming']) ?>" class="btn-blockbuster">Ver Detalles</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="section-header">
        <h3><i class="fas fa-fire text-warning me-2"></i>Más Visitados</h3>
        <div class="section-line"></div>
    </div>
    <div class="blockbuster-grid">
        <?php foreach ($populares as $item): ?>
            <article class="movie-card border-top border-4 border-warning">
                <div class="img-container">
                    <?php $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg'; ?>
                    <img src="<?= base_url('uploads/' . $foto) ?>" alt="<?= esc($item['nombre_streaming']) ?>">
                </div>
                <div class="card-info">
                    <h3 class="movie-title"><?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?></h3>
                    <a href="<?= base_url('cliente/catalogo/detalle/' . $item['id_streaming']) ?>" class="btn-blockbuster">Ver Detalles</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="section-header">
        <h3><i class="fas fa-th-large text-primary me-2"></i>Todos los Disponibles</h3>
        <div class="section-line"></div>
    </div>
    <div class="blockbuster-grid">
        <?php foreach ($streaming as $item): ?>
            <article class="movie-card">
                <div class="img-container">
                    <?php $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg'; ?>
                    <img src="<?= base_url('uploads/' . $foto) ?>" alt="<?= esc($item['nombre_streaming']) ?>">
                </div>
                <div class="card-info">
                    <span class="badge mb-2 align-self-start" style="background-color: #f1f3f5; color: var(--bb-blue); font-size: 0.7rem;">
                        <i class="fas fa-tag"></i> <?= esc(mb_convert_encoding($item['nombre_genero'] ?? 'General', 'UTF-8', 'ISO-8859-1')) ?>
                    </span>
                    <h3 class="movie-title"><?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?></h3>
                    <a href="<?= base_url('cliente/catalogo/detalle/' . $item['id_streaming']) ?>" class="btn-blockbuster">Ver Detalles</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>