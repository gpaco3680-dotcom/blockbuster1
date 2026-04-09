<?= $this->extend('Layouts/admin_layout') ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Gestión de Planes</h2>
        </div>
        
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Límite de Renta</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($planes)): ?>
                        <?php foreach ($planes as $plan): ?>
                            <tr>
                                <td><?php echo $plan['id_plan']; ?></td>
                                <td><?php echo $plan['nombre_plan']; ?></td>
                                <td>$<?php echo number_format($plan['precio_plan'], 2); ?></td>
                                <td><?php echo $plan['cantidad_limite_plan']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($plan['estatus_plan'] == 1) ? 'success' : 'danger'; ?>">
                                        <?php echo ($plan['estatus_plan'] == 1) ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('/admin/planes/' . $plan['id_plan'] . '/edit'); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="POST" action="<?php echo base_url('/admin/planes/' . $plan['id_plan']); ?>" style="display:inline;" onsubmit="return confirm('¿Confirma la eliminación?');">
                                        <?php echo csrf_field(); ?>
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
                                <p class="text-muted">No hay planes registrados.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>