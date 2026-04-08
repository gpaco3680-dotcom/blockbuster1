<?= $this->extend('Layouts/operador_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2 class="fw-bold mb-4" style="color: #1f4f8b;">
        <i class="fas fa-file-invoice-dollar me-2"></i>Validación de Pagos Pendientes
    </h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #152238; color: white;">
                    <tr>
                        <th>Cliente</th>
                        <th>Tarjeta (Simulación)</th>
                        <th>Monto</th>
                        <th>Fecha Registro</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pagos)): ?>
                        <?php foreach($pagos as $pago): ?>
                        <tr>
                            <td class="fw-bold">
                                <?= esc(mb_convert_encoding($pago['nombre_usuario'] . ' ' . $pago['ap_usuario'], 'UTF-8', 'ISO-8859-1')) ?>
                            </td>
                            
                            <td>
                                <code class="text-dark bg-light p-1 rounded">
                                    <i class="fas fa-credit-card me-1 text-muted"></i>
                                    **** **** **** <?= substr($pago['numero_tarjeta'], -4) ?>
                                </code>
                            </td> 
                            
                            <td class="text-primary fw-bold">
                                $<?= number_format($pago['monto_pago'], 2) ?>
                            </td>
                            
                            <td class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i> <?= $pago['fecha_pago'] ?>
                            </td>
                            
                            <td class="text-center">
                                <form action="<?= base_url('operador/pagos/aprobar/'.$pago['id_pago']) ?>" method="POST" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-3">
                                        <i class="fas fa-check-double me-1"></i> Autorizar Acceso
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-clipboard-check fa-2x mb-2 d-block"></i>
                                No hay pagos pendientes de revisión.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>