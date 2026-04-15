<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-video"></i> Gestión de Videos</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('/admin/videos/create') ?>" class="btn btn-primary">
                <i class="fas fa-upload"></i> Subir Nuevo Video
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Pertenece a (Streaming)</th>
                        <th>Archivo</th>
                        <th>Temporada/Capítulo</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($videos)): ?>
                        <?php foreach($videos as $v): ?>
                        <tr>
                            <td><strong><?= $v['id_video'] ?></strong></td>
                            <td><?= esc(mb_convert_encoding($v['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?></td>
                            <td><small class="text-muted"><?= esc($v['video']) ?></small></td>
                            <td>
                                <?php if(!empty($v['nombre_temporada'])): ?>
                                    <span class="badge bg-secondary"><?= esc($v['nombre_temporada']) ?></span>
                                    <span class="badge bg-info text-dark">Cap. <?= esc($v['capitulo_temporada']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted italic">Película (Única)</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= ($v['estatus_video'] == 1) ? 'success' : 'danger'; ?>">
                                    <?= ($v['estatus_video'] == 1) ? 'Disponible' : 'No Disponible'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <form method="POST" action="<?= base_url('/admin/videos/eliminar/' . $v['id_video']) ?>" onsubmit="return confirm('¿Confirma la eliminación definitiva de este recurso?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No se han encontrado videos vinculados al catálogo actual.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>