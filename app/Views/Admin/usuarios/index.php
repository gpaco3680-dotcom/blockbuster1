<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Gestión de Usuarios</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('/admin/usuarios/create') ?>" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach($usuarios as $u): ?>
                        <tr>
                            <td><strong><?= $u['id_usuario'] ?></strong></td>
                            <td><?= $u['nombre_usuario'] ?> <?= $u['ap_usuario'] ?> <?= $u['am_usuario'] ?></td>
                            <td><?= $u['email_usuario'] ?></td>
                            <td>
                                <?php 
                                    $roleNames = [1 => 'Administrador', 2 => 'Operador', 3 => 'Cliente'];
                                    echo $roleNames[$u['id_rol']] ?? 'Desconocido';
                                ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($u['estatus_usuario'] == 'activo') ? 'success' : 'danger'; ?>">
                                    <?= ucfirst($u['estatus_usuario']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('/admin/usuarios/' . $u['id_usuario'] . '/edit') ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form method="POST" action="<?= base_url('/admin/usuarios/' . $u['id_usuario']) ?>" style="display:inline;" onsubmit="return confirm('¿Confirma la eliminación?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">No hay usuarios registrados.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>