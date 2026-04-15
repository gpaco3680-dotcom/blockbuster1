<?= $this->extend('Layouts/admin_layout') ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #152238;">Gestión de Planes</h2>
        
        <a href="<?= base_url('admin/planes/new') ?>" class="btn btn-lg shadow-sm text-white px-4 py-2" 
           style="background-color: #dc3545; border-radius: 10px; border: none;">
            <div class="d-flex align-items-center text-start">
                <span style="font-size: 1.5rem;" class="me-2">+</span>
                <div style="line-height: 1.2;">
                    <small style="display: block; font-size: 0.7rem; text-transform: uppercase; opacity: 0.8;">Nuevo</small>
                    <span class="fw-bold">Plan</span>
                </div>
            </div>
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Límite de Renta</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($planes)): ?>
                        <?php foreach ($planes as $plan): ?>
                            <tr>
                                <td class="fw-bold"><?= $plan['id_plan']; ?></td>
                                <td><?= $plan['nombre_plan']; ?></td>
                                <td class="text-success fw-bold">$<?= number_format($plan['precio_plan'], 2); ?></td>
                                <td><i class="fas fa-ticket-alt me-1 text-primary"></i> <?= $plan['cantidad_limite_plan']; ?></td>
                                <td>
                                    <span class="badge rounded-pill bg-<?= ($plan['estatus_plan'] == 1) ? 'success' : 'danger'; ?>">
                                        <?= ($plan['estatus_plan'] == 1) ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/planes/' . $plan['id_plan'] . '/edit'); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="<?= base_url('admin/planes/' . $plan['id_plan']); ?>" style="display:inline;" onsubmit="return confirm('¿Confirma la eliminación?');">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay planes registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>