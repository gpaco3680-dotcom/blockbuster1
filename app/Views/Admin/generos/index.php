<?= $this->extend('Layouts/admin_layout') ?>

<?php $this->section('content'); ?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Gestión de Géneros</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo base_url('/admin/generos/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Género
            </a>
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
                        <th>Descripción</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($generos)): ?>
                        <?php foreach ($generos as $genero): ?>
                            <tr>
                                <td><?php echo $genero['id_genero']; ?></td>
                                <td><?php echo $genero['nombre_genero']; ?></td>
                                <td><?php echo $genero['descripcion_genero'] ?? '-'; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo ($genero['estatus_genero'] == 'activo') ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($genero['estatus_genero'] ?? 'activo'); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('/admin/generos/' . $genero['id_genero'] . '/edit'); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form method="POST" action="<?php echo base_url('/admin/generos/' . $genero['id_genero']); ?>" style="display:inline;" onsubmit="return confirm('¿Confirma la eliminación?');">
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
                            <td colspan="5" class="text-center py-4">
                                <p class="text-muted">No hay géneros registrados.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
