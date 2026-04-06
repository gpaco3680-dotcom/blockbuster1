<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="section-header mb-4">
    <h2 class="section-title">Catálogo</h2>
    <p class="mb-3 text-muted">Explora nuestra colección de películas y series con datos de duración, clasificación y disponibilidad. Elige tu próximo entretenimiento con información clara y tarjetas interactivas.</p>
</div>

<div class="info-grid mb-4">
    <div class="info-card">
        <h5>Total de títulos</h5>
        <p><?= count($streaming) ?> contenidos disponibles, actualizados para tu selección.</p>
    </div>
    <div class="info-card">
        <h5>Acceso rápido</h5>
        <p>Haz clic en "Ver detalle" para conocer más sobre cada título y rentarlo directamente.</p>
    </div>
    <div class="info-card">
        <h5>Más información</h5>
        <p>Encuentra duración, temporadas, clasificación y estado en cada tarjeta. Ideal para elegir rápidamente.</p>
    </div>
</div>

<div class="streaming-grid">
    <?php foreach ($streaming as $item): ?>
    <div class="card streaming-card">
        <img src="<?= esc($item['caratula_streaming'] ?: 'https://via.placeholder.com/600x360/1f4f8b/ffffff?text=Blockbuster') ?>" alt="<?= esc($item['nombre_streaming']) ?>">
        <div class="streaming-card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <span class="badge badge-primary"><?= esc(ucfirst($item['tipo_streaming'] ?? 'Título')) ?></span>
                <span class="badge badge-outline"><?= $item['estatus_streaming'] ? 'Disponible' : 'No disponible' ?></span>
            </div>
            <span class="badge badge-outline mb-2"><?= esc($item['nombre_genero'] ?? 'Sin género') ?></span>
            <h3 class="streaming-card-title"><?= esc($item['nombre_streaming']) ?></h3>
            <p class="streaming-card-text"><?= esc($item['descripcion_streaming'] ?: 'Contenido emocionante y seleccionado para ti.') ?></p>
            <div class="streaming-card-tags mb-3">
                <span class="badge badge-outline">Duración: <?= esc($item['duracion_streaming'] ?: 'N/A') ?> min</span>
                <span class="badge badge-outline">Temporadas: <?= esc($item['temporadas_streaming'] ?: '1') ?></span>
                <span class="badge badge-outline">Clasificación: <?= esc($item['clasificacion_streaming'] ?: 'General') ?></span>
            </div>
            <div class="streaming-card-actions">
                <a href="/cliente/catalogo/detalle/<?= $item['id_streaming'] ?>" class="btn btn-primary w-100">Ver detalle</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
