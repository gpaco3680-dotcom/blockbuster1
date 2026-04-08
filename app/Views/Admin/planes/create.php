<?= $this->extend('Layouts/admin_layout') ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4">Crear Nuevo Plan</h2>

            <form action="<?php echo base_url('/admin/planes'); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="nombre_plan" class="form-label">Nombre del Plan *</label>
                    <input type="text" class="form-control" id="nombre_plan" name="nombre_plan" required>
                </div>

                <div class="mb-3">
                    <label for="precio_plan" class="form-label">Precio ($) *</label>
                    <input type="number" step="0.01" class="form-control" id="precio_plan" name="precio_plan" required>
                </div>

                <div class="mb-3">
                    <label for="cantidad_limite_plan" class="form-label">Límite de Alquileres *</label>
                    <input type="number" class="form-control" id="cantidad_limite_plan" name="cantidad_limite_plan" required>
                    <small class="text-muted">Cantidad máxima de películas/series que el cliente podrá rentar con este plan.</small>
                </div>

                <div class="mb-3">
                    <label for="estatus_plan" class="form-label">Estatus *</label>
                    <select class="form-select" id="estatus_plan" name="estatus_plan" required>
                        <option value="1" selected>Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="<?php echo base_url('/admin/planes'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>