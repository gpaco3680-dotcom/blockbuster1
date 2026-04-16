<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5 text-center">
    <h2 class="text-white bg-dark p-3 rounded"><?= esc($streaming['nombre_streaming']) ?></h2>
    
    <div class="ratio ratio-16x9 shadow-lg mt-4" style="border: 5px solid #152238; border-radius: 15px; overflow: hidden;">
        <video controls autoplay controlsList="nodownload">
            <source src="<?= base_url('uploads/videos/' . $video['video']) ?>" type="video/mp4">
            Tu navegador no soporta la reproducción de video.
        </video>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('cliente/catalogo/detalle/'.$streaming['id_streaming']) ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a detalles
        </a>
    </div>
</div>
<?= $this->endSection() ?>