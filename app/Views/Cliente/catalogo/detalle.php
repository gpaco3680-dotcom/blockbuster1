<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4 mb-5">
    <div class="row bg-white p-4 shadow-sm" style="border-radius: 15px;">
        
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <?php 
                $nombreFoto = $item['caratula_streaming'] ?: 'default.jpg';
                $rutaFisica = FCPATH . 'uploads/' . $nombreFoto;
                if (file_exists($rutaFisica) && !empty($item['caratula_streaming'])) {
                    $urlImg = base_url('uploads/' . $nombreFoto);
                } else {
                    $urlImg = "https://placehold.co/400x600/152238/FFFFFF?text=" . urlencode($item['nombre_streaming']);
                }
            ?>
            <img src="<?= $urlImg ?>" class="img-fluid rounded" style="width: 100%; max-width: 350px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);" alt="<?= esc($item['nombre_streaming']) ?>">
        </div>
        
        <div class="col-md-8">
            <h1 class="display-5 fw-bold" style="color: #152238;"><?= esc($item['nombre_streaming']) ?></h1>
            <span class="badge mb-3" style="background-color: #1f4f8b; font-size: 1rem;"><?= esc($item['nombre_genero'] ?? 'Sin género') ?></span>
            
            <p class="lead text-muted mt-3" style="line-height: 1.6;">
                <?= esc($item['sipnosis_streaming'] ?: 'Sin descripción disponible por el momento.') ?>
            </p>
            
            <ul class="list-unstyled mt-4 p-3 bg-light rounded border-start border-4 border-primary">
                <li class="mb-2"><strong><i class="fas fa-clock text-primary me-2"></i>Duración:</strong> <?= esc($item['duracion_streaming'] ?: 'N/A') ?></li>
                <li class="mb-2"><strong><i class="fas fa-tv text-primary me-2"></i>Temporadas:</strong> <?= esc($item['temporadas_streaming'] ?: 'N/A') ?></li>
                <li><strong><i class="fas fa-info-circle text-primary me-2"></i>Clasificación:</strong> <?= esc($item['clasificacion_streaming'] ?: 'General') ?></li>
            </ul>

            <div class="mt-4">
                <?php if ($yaRentado): ?>
                    
                    <?php if (isset($estatus_alquiler) && $estatus_alquiler == 1): ?>
                        <div class="alert alert-info d-inline-block p-2 px-4 shadow-sm mb-3" style="border-radius: 10px;">
                            <i class="fas fa-check-double me-2"></i> <strong>Contenido Culminado</strong>
                        </div>
                        <br>
                        <a href="<?= base_url('cliente/catalogo/reproductor/'.$video['id_video']) ?>" class="btn btn-outline-success btn-lg fw-bold shadow-sm">
                            <i class="fas fa-redo me-2"></i> VOLVER A VER
                        </a>

                    <?php else: ?>
                        <?php if (!empty($video)): ?>
                            <a href="<?= base_url('cliente/catalogo/reproductor/'.$video['id_video']) ?>" class="btn btn-success btn-lg fw-bold shadow-sm">
                                <i class="fas fa-play-circle me-2"></i> VER AHORA
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-lg disabled shadow-sm">
                                <i class="fas fa-clock me-2"></i> PRÓXIMAMENTE DISPONIBLE
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php else: ?>
                    <a href="<?= base_url('cliente/alquiler/rentar/'.$item['id_streaming']) ?>" class="btn btn-primary btn-lg fw-bold shadow-sm">
                        <i class="fas fa-ticket-alt me-2"></i> Alquilar Película
                    </a>
                <?php endif; ?>

                <a href="<?= base_url('cliente/catalogo') ?>" class="btn btn-outline-secondary btn-lg ms-2 shadow-sm">
                    Volver al catálogo
                </a>
            </div>

            <hr class="my-5">

            <div class="mt-4">
                <h3 class="text-dark fw-bold mb-3"><i class="fab fa-youtube text-danger me-2"></i>Tráiler Oficial</h3>
                
                <?php if (!empty($item['trailer_streaming'])): ?>
                    <?php 
                        // Limpieza de URL para obtener el ID de YouTube
                        $urlParts = explode('/', rtrim($item['trailer_streaming'], '/'));
                        $youtubeId = end($urlParts); 
                        // Manejo por si es formato watch?v=
                        if (strpos($youtubeId, 'watch?v=') !== false) {
                            $youtubeId = substr($youtubeId, strpos($youtubeId, 'v=') + 2);
                        }
                    ?>
                    <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
                        <iframe 
                            src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light border text-center py-4">
                        <i class="fas fa-video-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Tráiler no disponible por el momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>