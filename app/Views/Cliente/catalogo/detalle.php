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
                <?= esc($item['sipnosis_streaming']) ?: 'Sin descripción disponible por el momento.' ?>
            </p>
            
            <ul class="list-unstyled mt-4 p-3 bg-light rounded border-start border-4 border-primary">
                <li class="mb-2"><strong><i class="fas fa-clock text-primary me-2"></i>Duración:</strong> <?= esc($item['duracion_streaming'] ?: 'N/A') ?></li>
                <li class="mb-2"><strong><i class="fas fa-tv text-primary me-2"></i>Temporadas:</strong> <?= esc($item['temporadas_streaming'] ?: 'N/A') ?></li>
                <li><strong><i class="fas fa-info-circle text-primary me-2"></i>Clasificación:</strong> <?= esc($item['clasificacion_streaming'] ?: 'General') ?></li>
            </ul>

            <div class="mt-4">
                <?php if (isset($yaRentado) && $yaRentado): ?>
                    <a href="<?= base_url('cliente/catalogo/reproductor/'.$item['id_streaming']) ?>" class="btn btn-lg fw-bold px-4 shadow-sm btn-success animate__animated animate__pulse animate__infinite">
                        <i class="fas fa-play-circle me-2"></i> VER AHORA
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('cliente/alquiler/rentar/'.$item['id_streaming']) ?>" class="btn btn-lg fw-bold px-4 shadow-sm" style="background-color: #1f4f8b; color: white;">
                        <i class="fas fa-ticket-alt me-2"></i> Alquilar Ahora
                    </a>
                <?php endif; ?>

                <a href="<?= base_url('cliente/catalogo') ?>" class="btn btn-outline-secondary btn-lg ms-2 shadow-sm">
                    Volver al catálogo
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>