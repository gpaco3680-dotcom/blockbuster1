<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="section-header mb-4">
    <h2 class="section-title">Detalle del Contenido</h2>
    <p class="text-muted">Información completa del título para que elijas con seguridad. Aquí verás descripción, duración, temporadas, clasificación y estado.</p>
</div>

<div class="detail-grid">
    <div class="card detail-card">
        <img src="<?= esc($item['caratula_streaming'] ?: 'https://via.placeholder.com/900x400/1f4f8b/ffffff?text=Detalle+de+contenido') ?>" alt="<?= esc($item['nombre_streaming']) ?>">
        <div class="card-body">
            <h3 class="card-title"><?= esc($item['nombre_streaming']) ?></h3>
            <span class="badge badge-outline mb-3"><?= esc($item['nombre_genero'] ?? 'Sin género') ?></span>
            <p class="card-text"><?= esc($item['sipnosis_streaming'] ?? $item['descripcion_streaming'] ?? 'Descripción no disponible.') ?></p>
            <div class="detail-meta">
                <span><strong>Género:</strong> <?= esc($item['nombre_genero'] ?? 'Sin género') ?></span>
                <span><strong>Duración:</strong> <?= esc($item['duracion_streaming'] ?: 'N/A') ?> min</span>
                <span><strong>Temporadas:</strong> <?= esc($item['temporadas_streaming'] ?: '1') ?></span>
                <span><strong>Clasificación:</strong> <?= esc($item['clasificacion_streaming'] ?: 'General') ?></span>
                <span><strong>Estado:</strong> <?= $item['estatus_streaming'] ? 'Activo' : 'Inactivo' ?></span>
                <span><strong>Tipo:</strong> <?= esc(ucfirst($item['tipo_streaming'] ?: 'película')) ?></span>
            </div>
            <div class="mt-4">
                <a href="/cliente/alquiler/rentar/<?= $item['id_streaming'] ?>" class="btn btn-primary">Rentar este título</a>
                <a href="/cliente/catalogo" class="btn btn-secondary ms-2">Volver al catálogo</a>
            </div>
        </div>
    </div>

    <div class="info-card">
        <h5>¿Qué encontrarás aquí?</h5>
        <p>Este espacio te muestra todos los detalles relevantes antes de rentar: clasificación, duración, número de temporadas y disponibilidad actual. Ideal para planificar tu noche de entretenimiento.</p>
        <h5 class="mt-4">Recomendaciones</h5>
        <p>Si te gusta este título, prueba buscar otros contenidos con la misma clasificación o género para descubrir más recomendaciones.</p>
    </div>
</div>
<?= $this->endSection() ?>
