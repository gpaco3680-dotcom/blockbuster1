<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="mb-4"><i class="fas fa-edit"></i> Editar Usuario</h2>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actualizar Datos del Usuario</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/usuarios/' . $usuario['id_usuario']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($usuario['nombre_usuario']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ap" class="form-label">Apellido Paterno *</label>
                                <input type="text" class="form-control" id="ap" name="ap" value="<?= esc($usuario['ap_usuario']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="am" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="am" name="am" value="<?= esc($usuario['am_usuario']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario['email_usuario']) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_rol" class="form-label">Rol de Usuario *</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="1" <?= $usuario['id_rol'] == 1 ? 'selected' : '' ?>>Administrador</option>
                                    <option value="2" <?= $usuario['id_rol'] == 2 ? 'selected' : '' ?>>Operador</option>
                                    <option value="3" <?= $usuario['id_rol'] == 3 ? 'selected' : '' ?>>Cliente</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estatus" class="form-label">Estatus *</label>
                                <select class="form-select" id="estatus" name="estatus" required>
                                    <option value="activo" <?= $usuario['estatus_usuario'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                                    <option value="inactivo" <?= $usuario['estatus_usuario'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> <strong>Nota:</strong> La contraseña no se puede cambiar desde esta sección.
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Usuario
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
