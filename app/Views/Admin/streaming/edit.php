<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="mb-4">Editar Streaming (Película / Serie)</h2>

            <form action="<?= base_url('admin/streaming/actualizar/' . $streaming['id_streaming']); ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="nombre_streaming" value="<?= esc($streaming['nombre_streaming']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Género *</label>
                        <select class="form-select" name="id_genero" required>
                            <option value="">Seleccione un género...</option>
                            <?php foreach ($generos as $genero): ?>
                                <option value="<?= $genero['id_genero'] ?>" <?= ($streaming['id_genero'] == $genero['id_genero']) ? 'selected' : '' ?>>
                                    <?= esc($genero['nombre_genero']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Contenido *</label>
                        <select class="form-select" name="tipo_streaming" id="tipo_streaming" required>
                            <option value="pelicula" <?= (empty($streaming['temporadas_streaming'])) ? 'selected' : '' ?>>Película</option>
                            <option value="serie" <?= (!empty($streaming['temporadas_streaming'])) ? 'selected' : '' ?>>Serie</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="div_duracion" style="display: <?= (empty($streaming['temporadas_streaming'])) ? 'block' : 'none' ?>;">
                        <label class="form-label">Duración (HH:MM:SS)</label>
                        <input type="time" step="1" class="form-control" name="duracion_streaming" value="<?= esc($streaming['duracion_streaming']) ?>">
                    </div>
                    
                    <div class="col-md-4" id="div_temporadas" style="display: <?= (!empty($streaming['temporadas_streaming'])) ? 'block' : 'none' ?>;">
                        <label class="form-label">Número de Temporadas</label>
                        <input type="number" class="form-control" name="temporadas_streaming" min="1" value="<?= esc($streaming['temporadas_streaming']) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Clasificación</label>
                        <input type="text" class="form-control" name="clasificacion_streaming" value="<?= esc($streaming['clasificacion_streaming']) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Lanzamiento</label>
                        <input type="date" class="form-control" name="fecha_lanzamiento_streaming" value="<?= esc($streaming['fecha_lanzamiento_streaming']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Estreno en Plataforma</label>
                        <input type="date" class="form-control" name="fecha_estreno_streaming" value="<?= esc($streaming['fecha_estreno_streaming']) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">URL de Carátula (Imagen)</label>
                        <input type="text" class="form-control" name="caratula_streaming" value="<?= esc($streaming['caratula_streaming']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">URL del Tráiler (YouTube)</label>
                        <input type="text" class="form-control" name="trailer_streaming" value="<?= esc($streaming['trailer_streaming']) ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Sinopsis</label>
                    <textarea class="form-control" name="sipnosis_streaming" rows="4"><?= esc($streaming['sipnosis_streaming']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Estatus</label>
                    <select class="form-select" name="estatus_streaming">
                        <option value="1" <?= ($streaming['estatus_streaming'] == 1) ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= ($streaming['estatus_streaming'] == 0) ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <div class="d-flex gap-2 mb-5">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                    <a href="<?= base_url('/admin/streaming') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mantenemos tu función que ya sirve para ocultar/mostrar duración o temporadas
    document.getElementById('tipo_streaming').addEventListener('change', function() {
        if(this.value === 'pelicula') {
            document.getElementById('div_duracion').style.display = 'block';
            document.getElementById('div_temporadas').style.display = 'none';
        } else {
            document.getElementById('div_duracion').style.display = 'none';
            document.getElementById('div_temporadas').style.display = 'block';
        }
    });
</script>
<?= $this->endSection() ?>