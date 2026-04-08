<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #1f4f8b;">
            <i class="fas fa-film me-2"></i>Gestión de Streaming
        </h2>
        <a href="<?= base_url('admin/streaming/new') ?>" class="btn btn-primary fw-bold shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Crear Contenido
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #152238; color: #ffffff;">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nombre</th>
                        <th>Duración / Temp</th>
                        <th>Clasificación</th>
                        <th>Estatus</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($streaming)): ?>
                        <?php foreach ($streaming as $item): ?>
                            <tr>
                                <td class="ps-4 text-muted">#<?= $item['id_streaming'] ?></td>
                                <td>
                                    <span class="fw-bold text-dark"><?= esc($item['nombre_streaming']) ?></span>
                                </td>
                                <td>
                                    <?php if ($item['temporadas_streaming']): ?>
                                        <span class="badge bg-soft-blue text-primary" style="background-color: #eef4ff;">
                                            <i class="fas fa-tv me-1"></i> <?= $item['temporadas_streaming'] ?> Temp
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">
                                            <i class="fas fa-clock me-1"></i> <?= $item['duracion_streaming'] ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge border text-dark" style="border-color: #d2e1f7 !important;">
                                        <?= esc($item['clasificacion_streaming']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= ($item['estatus_streaming'] == 1) ? 'bg-success' : 'bg-danger' ?>">
                                        <?= ($item['estatus_streaming'] == 1) ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="<?= base_url('admin/streaming/' . $item['id_streaming'] . '/edit') ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('admin/streaming/' . $item['id_streaming']) ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este contenido?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No hay contenido registrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>