<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 15px 15px 0 0;">
                    <h3 class="fw-bold mb-0">Activa tu suscripción</h3>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <p class="text-muted">Estás a un paso de disfrutar del mejor contenido.</p>
                        <div class="p-3 rounded mb-3" style="background-color: #f8faff; border: 2px dashed #1f4f8b;">
                            <span class="text-uppercase small fw-bold text-primary">Plan seleccionado</span>
                            <h2 class="fw-bold mb-0" style="color: #152238;"><?= esc($miPlan['nombre_plan']) ?></h2>
                            <h4 class="text-primary fw-bold">$<?= number_format($miPlan['precio_plan'], 2) ?></h4>
                        </div>
                    </div>

                    <form action="<?= base_url('cliente/pagar') ?>" method="POST" id="formPago">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Número de Tarjeta (16 dígitos)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                <input type="text" name="tarjeta_pago" id="tarjeta_pago" class="form-control form-control-lg" placeholder="0000 0000 0000 0000" maxlength="16" required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Vencimiento</label>
                                <input type="text" class="form-control" placeholder="MM/AA">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">CVV</label>
                                <input type="text" class="form-control" placeholder="123">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow" id="btnPagar">
                            <i class="fas fa-lock me-2"></i> CONFIRMAR Y PAGAR
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>