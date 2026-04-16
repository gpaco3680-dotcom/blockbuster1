<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header text-white text-center py-4" style="background-color: #152238; border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i> Actualizar Mis Datos</h4>
                </div>
                
                <div class="card-body p-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <form action="<?= base_url('cliente/perfil/actualizar') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                <input type="text" name="nombre" class="form-control" value="<?= esc($usuario['nombre_usuario']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope text-primary"></i></span>
                                <input type="email" name="correo" class="form-control" value="<?= esc($usuario['correo_usuario']) ?>" required>
                            </div>
                        </div>

                        <div class="alert alert-info py-2 shadow-sm">
                            <small><i class="fas fa-info-circle me-1"></i> Si no deseas cambiar tu contraseña, deja el siguiente campo en blanco.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nueva Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-danger"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Escribe nueva contraseña solo si deseas cambiarla">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-lg text-white fw-bold shadow-sm" style="background-color: #1f4f8b;">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                            <a href="<?= base_url('cliente/perfil') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>