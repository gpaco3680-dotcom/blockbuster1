<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<style>
    /* Estilos personalizados para la lista de capítulos */
    .playlist-container {
        background-color: #1a1d20;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #343a40;
    }

    .playlist-header {
        background: linear-gradient(135deg, #152238 0%, #1f4f8b 100%);
        padding: 1.25rem;
    }

    .chapter-list {
        max-height: 70vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #1f4f8b #1a1d20;
    }

    /* Personalización del scroll para Chrome/Edge */
    .chapter-list::-webkit-scrollbar { width: 6px; }
    .chapter-list::-webkit-scrollbar-track { background: #1a1d20; }
    .chapter-list::-webkit-scrollbar-thumb { background: #1f4f8b; border-radius: 10px; }

    .chapter-item {
        background-color: #1a1d20;
        border-bottom: 1px solid #2d3238;
        padding: 15px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        color: #adb5bd;
    }

    .chapter-item:hover {
        background-color: #252a30;
        color: #fff;
        padding-left: 20px; /* Efecto de empuje */
    }

    .chapter-item.active {
        background-color: #1f4f8b;
        color: #fff;
        border-left: 5px solid #FFCC00;
    }

    .chapter-number {
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
        color: #FFCC00;
        margin-bottom: 4px;
        display: block;
    }

    .chapter-title {
        font-size: 0.95rem;
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }

    .playing-now {
        font-size: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
    }
</style>

<div class="container-fluid mt-4 px-4">
    <div class="row">
        <div class="col-lg-8 col-xl-9 mb-4">
            <div class="bg-dark p-1 rounded shadow-lg" style="border: 2px solid #343a40;">
                <div class="ratio ratio-16x9" style="border-radius: 8px; overflow: hidden; background: #000;">
                    <video id="videoPlayer" controls autoplay controlsList="nodownload">
                        <source src="<?= base_url('uploads/videos/' . $video['video']) ?>" type="video/mp4">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-white rounded shadow-sm border-start border-5 border-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold mb-1" style="color: #152238;"><?= esc($streaming['nombre_streaming']) ?></h1>
                        <p class="fs-5 text-primary mb-0">
                            <i class="fas fa-film me-2"></i> 
                            Temporada <?= $video['video_temporada'] ?> — Episodio <?= $video['capitulo_temporada'] ?>
                        </p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-dark px-3 py-2 fs-6"><?= esc($video['nombre_temporada']) ?></span>
                    </div>
                </div>
                <hr>
                <h5 class="section-label text-muted small fw-bold">DESCRIPCIÓN DEL CAPÍTULO</h5>
                <p class="text-secondary" style="line-height: 1.7;">
                    <?= esc($video['descripcion_capitulo_temporada'] ?: 'No hay una descripción específica para este capítulo.') ?>
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-xl-3">
            <div class="playlist-container shadow-lg">
                <div class="playlist-header">
                    <h5 class="text-white mb-0 fw-bold">
                        <i class="fas fa-play-circle text-warning me-2"></i> Contenido de la Serie
                    </h5>
                    <small class="text-white-50"><?= count($playlist) ?> Capítulos disponibles</small>
                </div>

                <div class="chapter-list">
                    <?php if(!empty($playlist)): ?>
                        <?php foreach($playlist as $cap): ?>
                            <a href="<?= base_url('cliente/catalogo/reproductor/'.$cap['id_video']) ?>" 
                               class="chapter-item <?= ($cap['id_video'] == $video['id_video']) ? 'active' : '' ?>">
                                
                                <span class="chapter-number">
                                    Temporada <?= $cap['video_temporada'] ?> • Episodio <?= $cap['capitulo_temporada'] ?>
                                </span>
                                
                                <span class="chapter-title">
                                    <?= esc($cap['nombre_temporada']) ?>
                                </span>

                                <?php if($cap['id_video'] == $video['id_video']): ?>
                                    <span class="playing-now">
                                        <i class="fas fa-volume-up me-1"></i> Reproduciendo
                                    </span>
                                <?php else: ?>
                                    <small class="text-muted"><i class="far fa-play-circle"></i> Ver capítulo</small>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                            <p>No se encontraron otros capítulos.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mt-4 d-grid gap-2">
                <a href="<?= base_url('cliente/catalogo/detalle/'.$streaming['id_streaming']) ?>" class="btn btn-outline-dark fw-bold py-2">
                    <i class="fas fa-chevron-left me-2"></i> Volver a Detalles
                </a>
                <a href="<?= base_url('cliente/catalogo') ?>" class="btn btn-primary fw-bold py-2">
                    <i class="fas fa-th-large me-2"></i> Ir al Catálogo
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    const video = document.getElementById('videoPlayer');

    video.onended = function() {
        console.log("Capítulo terminado. Buscando el siguiente...");

        // 1. Buscamos el elemento que está 'active' en la lista lateral
        const currentActive = document.querySelector('.chapter-item.active');
        
        if (currentActive) {
            // 2. Buscamos el siguiente elemento hermano (el siguiente capítulo)
            const nextChapter = currentActive.nextElementSibling;

            if (nextChapter && nextChapter.classList.contains('chapter-item')) {
                // 3. Si existe un siguiente capítulo, redirigimos después de 2 segundos
                // para que el usuario no se asuste con el cambio repentino
                setTimeout(() => {
                    window.location.href = nextChapter.href;
                }, 2000);
            } else {
                // Si ya no hay más capítulos (es el último de la lista)
                alert("¡Has llegado al final de la serie!");
            }
        }
    };
</script>
<?= $this->endSection() ?>