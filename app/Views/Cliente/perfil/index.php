<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4" style="background-color: #f8faff;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                    </div>
                    <h4 class="fw-bold text-dark">
                        <?= esc(mb_convert_encoding(session()->get('nombre') ?? 'Usuario', 'UTF-8', 'ISO-8859-1')) ?>
                    </h4>
                    <p class="text-muted small">Cliente Blockbuster</p>
                    <hr>
                    
                    <div class="p-3 rounded" style="background-color: #1f4f8b; color: white;">
                        <p class="mb-1 small">Tu Plan Actual:</p>
                        <h5 class="fw-bold mb-0">
                            <?= esc(mb_convert_encoding($miPlan['nombre_plan'] ?? 'No tienes un plan activo', 'UTF-8', 'ISO-8859-1')) ?>
                        </h5>
                        <p class="mb-0 small">Límite: <?= esc($miPlan['cantidad_limite_plan'] ?? 0) ?> rentas</p>
                    </div>
                    
                    <?php if (!empty($miPlan)): ?>
                        <button class="btn btn-dark w-100 mt-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPago">
                            <i class="fas fa-credit-card"></i> Realizar Pago ($<?= number_format($miPlan['precio_plan'] ?? 0, 2) ?>)
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary w-100 mt-3 fw-bold" disabled>
                            <i class="fas fa-ban"></i> Sin plan a pagar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            
            <h3 class="text-primary fw-bold mb-4"><i class="fas fa-history"></i> Mis Alquileres</h3>
            <div class="card border-0 shadow-sm mb-5">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #152238; color: white;">
                            <tr>
                                <th>Streaming</th>
                                <th>Fecha Renta</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($alquileres)): ?>
                                <?php foreach($alquileres as $alq): ?>
                                    <tr>
                                        <td class="fw-bold">
                                            <?= esc(mb_convert_encoding($alq['nombre_streaming'], 'UTF-8', 'ISO-8859-1')) ?>
                                        </td>
                                        <td><?= esc($alq['fecha_inicio_alquiler']) ?></td>
                                        <td><?= esc($alq['fecha_fin_alquiler']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($alq['estatus_alquiler'] == 1) ? 'success' : 'warning' ?>">
                                                <?= ($alq['estatus_alquiler'] == 1) ? 'Culminado' : 'En Proceso' ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">No tienes alquileres registrados todavía.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <h3 class="text-dark fw-bold mb-4"><i class="fas fa-file-invoice-dollar"></i> Historial de Pagos</h3>
            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Tarjeta</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($misPagos)): ?>
                                <?php foreach($misPagos as $p): ?>
                                    <tr>
                                        <td><?= esc($p['fecha_pago']) ?></td>
                                        <td>**** <?= esc(substr($p['numero_tarjeta'], -4)) ?></td>
                                        <td class="fw-bold">$<?= number_format($p['monto_pago'], 2) ?></td>
                                        <td>
                                            <?= ($p['estatus_pago'] == 1) ? '<span class="text-success"><i class="fas fa-check"></i> Autorizado</span>' : '<span class="text-muted">Pendiente</span>' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">Aún no tienes historial de pagos.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="modalPago" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('cliente/pagar') ?>" method="POST" class="modal-content" id="formPago">
            <?= csrf_field() ?>
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Simulación de Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Se realizará el cobro de <strong>$<?= number_format($miPlan['precio_plan'] ?? 0, 2) ?></strong> correspondiente a tu plan <strong><?= esc(mb_convert_encoding($miPlan['nombre_plan'] ?? 'Ninguno', 'UTF-8', 'ISO-8859-1')) ?></strong>.</p>
                <div class="mb-3">
                    <label class="form-label fw-bold">Número de Tarjeta (16 dígitos)</label>
                    <input type="text" name="tarjeta_pago" id="tarjeta_pago" class="form-control" placeholder="0000 0000 0000 0000" maxlength="16" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnPagar">Confirmar Pago</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('formPago').addEventListener('submit', function(e) {
        const inputTarjeta = document.getElementById('tarjeta_pago').value;
        if (inputTarjeta.length < 16) {
            e.preventDefault();
            alert('Por favor, ingresa los 16 dígitos de tu tarjeta.');
            return;
        }
        
        const btn = document.getElementById('btnPagar');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btn.style.backgroundColor = '#152238';
    });
</script>
<?= $this->endSection() ?>