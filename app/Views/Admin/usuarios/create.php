<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4"><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h2>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Datos del Usuario</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/usuarios') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ap" class="form-label">Apellido Paterno *</label>
                                <input type="text" class="form-control" id="ap" name="ap" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="am" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="am" name="am">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_rol" class="form-label">Rol de Usuario *</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="">-- Seleccionar Rol --</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Operador</option>
                                    <option value="3">Cliente</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estatus" class="form-label">Estatus *</label>
                                <select class="form-select" id="estatus" name="estatus" required>
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Usuario
                            </button>
                            <a href="<?= base_url('/admin/usuarios') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
