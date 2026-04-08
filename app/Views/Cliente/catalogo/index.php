<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --bb-blue: #152238;
        --bb-accent: #1f4f8b;
        --bb-yellow: #FFCC00;
        --bb-bg: #f4f6f9;
    }

    body { background-color: var(--bb-bg); }

    /* Contenedor de Cuadrícula */
    .blockbuster-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 30px;
        grid-auto-rows: 1fr; /* Mantiene todas las filas de la misma altura */
        padding-bottom: 40px;
    }

    /* Tarjeta de Película */
    .movie-card {
        background-color: #ffffff;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-bottom: 4px solid var(--bb-accent);
    }

    .movie-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    /* Contenedor de Imagen con Proporción de Póster */
    .img-container {
        width: 100%;
        aspect-ratio: 2 / 3;
        background-color: var(--bb-blue);
        position: relative;
        overflow: hidden;
    }

    .img-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .movie-card:hover .img-container img {
        transform: scale(1.05);
    }

    /* Información de la Tarjeta */
    .card-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .movie-title {
        color: var(--bb-blue);
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 8px;
        min-height: 2.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .movie-meta {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .movie-meta i {
        color: var(--bb-accent);
        margin-right: 5px;
    }

    /* Botón Blockbuster */
    .btn-container {
        margin-top: auto; /* Empuja el botón siempre al final de la tarjeta */
    }

    .btn-blockbuster {
        background-color: var(--bb-accent);
        color: #ffffff;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        display: block;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-blockbuster:hover {
        background-color: var(--bb-yellow);
        color: var(--bb-blue);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

<div class="container mt-5">
    <header class="d-flex justify-content-between align-items-end mb-5 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-0" style="color: var(--bb-blue); text-transform: uppercase; letter-spacing: 1px;">
                Catálogo Disponible
            </h2>
            <div style="width: 80px; height: 5px; background-color: var(--bb-yellow); margin-top: 10px;"></div>
        </div>
    </header>

    <div class="blockbuster-grid">
        <?php foreach ($streaming as $item): ?>
            <article class="movie-card">
                
                <div class="img-container">
                    <?php 
                        $foto = !empty($item['caratula_streaming']) ? $item['caratula_streaming'] : 'default.jpg';
                        $urlImagen = base_url('uploads/' . $foto);
                    ?>
                    <img src="<?= $urlImagen ?>" 
                         alt="<?= esc($item['nombre_streaming']) ?>" 
                         onerror="this.onerror=null; this.src='https://placehold.co/400x600/152238/FFCC00?text=Blockbuster';">
                </div>
                
                <div class="card-info">
                    <span class="badge mb-2 align-self-start" style="background-color: #f1f3f5; color: var(--bb-blue); border: 1px solid #dee2e6;">
                        <i class="fas fa-tag"></i> 
                        <?= esc(mb_convert_encoding($item['nombre_genero'] ?? 'General', 'UTF-8', 'ISO-8859-1')) ?>
                    </span>
                    
                    <h3 class="movie-title">
                        <?= esc(mb_convert_encoding($item['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?>
                    </h3>
                    
                    <div class="movie-meta">
                        <?php if(!empty($item['duracion_streaming'])): ?>
                            <span><i class="fas fa-clock"></i> <?= esc($item['duracion_streaming']) ?></span>
                        <?php endif; ?>
                        
                        <?php if(!empty($item['temporadas_streaming'])): ?>
                            <span class="<?= !empty($item['duracion_streaming']) ? 'ms-3' : '' ?>">
                                <i class="fas fa-tv"></i> <?= esc($item['temporadas_streaming']) ?> Temp.
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="btn-container">
                        <a href="<?= base_url('cliente/catalogo/detalle/' . $item['id_streaming']) ?>" class="btn-blockbuster">
                            Ver Detalles
                        </a>
                    </div>
                </div>

            </article>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>