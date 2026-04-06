<?= $this->extend('Layouts/admin_layout') ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Editar Género</h2>

            <form action="<?php echo base_url('/admin/generos/' . $genero['id_genero']); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="nombre_genero" class="form-label">Nombre del Género *</label>
                    <input type="text" class="form-control" id="nombre_genero" name="nombre_genero" 
                           value="<?php echo $genero['nombre_genero']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion_genero" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion_genero" name="descripcion_genero" rows="4"><?php echo $genero['descripcion_genero'] ?? ''; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="estatus_genero" class="form-label">Estatus *</label>
                    <select class="form-select" id="estatus_genero" name="estatus_genero" required>
                        <option value="activo" <?php echo ($genero['estatus_genero'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo ($genero['estatus_genero'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="<?php echo base_url('/admin/generos'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
