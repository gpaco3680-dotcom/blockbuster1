<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-upload"></i> Subir Nuevo Video</h2>
            <a href="<?= base_url('/admin/videos') ?>" class="btn btn-secondary btn-sm mt-2">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('/admin/videos/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_streaming" class="form-label">Asignar a (Película o Serie) *</label>
                        <select name="id_streaming" id="id_streaming" class="form-select" required>
                            <option value="">Seleccione una opción...</option>
                            <?php foreach($streamings as $s): ?>
                                <option value="<?= $s['id_streaming'] ?>"><?= $s['nombre_streaming'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="estatus_video" class="form-label">Estatus Inicial *</label>
                        <select name="estatus_video" id="estatus_video" class="form-select" required>
                            <option value="1">Disponible</option>
                            <option value="-1">No Disponible</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="video_file" class="form-label">Archivo de Video (.mp4) *</label>
                        <input type="file" class="form-control" id="video_file" name="video_file" accept="video/mp4" required>
                    </div>
                </div>

                <hr class="mt-4 mb-4">
                <h5 class="text-muted mb-3"><i class="fas fa-tv"></i> Detalles si es una Serie (Opcional)</h5>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nombre_temporada" class="form-label">Nombre de Temporada</label>
                        <input type="text" class="form-control" id="nombre_temporada" name="nombre_temporada" placeholder="Ej: Temporada 1, Parte 1">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="video_temporada" class="form-label">Número de Temporada</label>
                        <input type="number" class="form-control" id="video_temporada" name="video_temporada" placeholder="Ej: 1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="capitulo_temporada" class="form-label">Número de Capítulo</label>
                        <input type="number" class="form-control" id="capitulo_temporada" name="capitulo_temporada" placeholder="Ej: 1, 2, 3...">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-4">
                        <label for="descripcion_capitulo_temporada" class="form-label">Sinopsis del Capítulo</label>
                        <textarea class="form-control" id="descripcion_capitulo_temporada" name="descripcion_capitulo_temporada" rows="2" placeholder="Breve descripción del episodio..."></textarea>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Video</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>