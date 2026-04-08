<?= $this->extend('Layouts/operador_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="fw-bold mb-4" style="color: #1f4f8b;">
        <i class="fas fa-users-cog me-2"></i>Gestión de Clientes
    </h2>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #152238; color: white;">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?= $cliente['id_usuario'] ?></td>
                            
                            <td class="fw-bold">
                                <?= esc(mb_convert_encoding($cliente['nombre_usuario'] . ' ' . $cliente['ap_usuario'], 'UTF-8', 'ISO-8859-1')) ?>
                            </td>
                            
                            <td><?= esc($cliente['email_usuario']) ?></td>
                            
                            <td>
                                <span class="badge <?= $cliente['estatus_usuario'] ? 'bg-success' : 'bg-danger' ?>">
                                    <i class="fas <?= $cliente['estatus_usuario'] ? 'fa-check-circle' : 'fa-times-circle' ?> me-1"></i>
                                    <?= $cliente['estatus_usuario'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('operador/clientes/aprobar/'.$cliente['id_usuario']) ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Activar Cliente">
                                        <i class="fas fa-user-check"></i> Aprobar
                                    </a>
                                    <a href="<?= base_url('operador/clientes/rechazar/'.$cliente['id_usuario']) ?>" 
                                       class="btn btn-sm btn-outline-secondary" 
                                       title="Suspender Cliente">
                                        <i class="fas fa-user-slash"></i> Suspender
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-1"></i> No hay clientes registrados en el sistema.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>