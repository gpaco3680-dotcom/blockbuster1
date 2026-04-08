<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <h2 class="mb-4">Agregar Nuevo Streaming (Película / Serie)</h2>

            <form action="<?php echo base_url('/admin/streaming'); ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-control" name="nombre_streaming" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Género *</label>
                        <select class="form-select" name="id_genero" required>
                            <option value="">Seleccione un género...</option>
                            <?php foreach ($generos as $genero): ?>
                                <option value="<?= $genero['id_genero'] ?>"><?= esc($genero['nombre_genero']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tipo de Contenido *</label>
                        <select class="form-select" name="tipo_streaming" id="tipo_streaming" required>
                            <option value="pelicula">Película</option>
                            <option value="serie">Serie</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="div_duracion">
                        <label class="form-label">Duración (HH:MM:SS)</label>
                        <input type="time" step="1" class="form-control" name="duracion_streaming">
                    </div>
                    
                    <div class="col-md-4" id="div_temporadas" style="display: none;">
                        <label class="form-label">Número de Temporadas</label>
                        <input type="number" class="form-control" name="temporadas_streaming" min="1">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Clasificación</label>
                        <input type="text" class="form-control" name="clasificacion_streaming" placeholder="Ej: PG-13, R" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Lanzamiento</label>
                        <input type="date" class="form-control" name="fecha_lanzamiento_streaming">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha de Estreno en Plataforma</label>
                        <input type="date" class="form-control" name="fecha_estreno_streaming">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">URL de Carátula (Imagen)</label>
                        <input type="text" class="form-control" name="caratula_streaming" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">URL del Tráiler (YouTube)</label>
                        <input type="text" class="form-control" name="trailer_streaming">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Sinopsis</label>
                    <textarea class="form-control" name="sipnosis_streaming" rows="4"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Estatus</label>
                    <select class="form-select" name="estatus_streaming">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="d-flex gap-2 mb-5">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Streaming</button>
                    <a href="<?= base_url('/admin/streaming') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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