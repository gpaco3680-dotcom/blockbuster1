<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5 mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary"><i class="fas fa-ticket-alt"></i> Cambia tu Membresía</h2>
        <p class="text-muted">Elige el plan que mejor se adapte a tu nivel de entretenimiento.</p>
    </div>

    <div class="row justify-content-center">
        <?php if(!empty($planes)): ?>
            <?php foreach($planes as $plan): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 text-center border-0" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-header text-white fw-bold py-3" style="background-color: #152238; font-size: 1.2rem;">
                            <?= esc(mb_convert_encoding($plan['nombre_plan'], 'UTF-8', 'ISO-8859-1')) ?>
                        </div>
                        <div class="card-body bg-light">
                            <h2 class="card-title fw-bold text-primary mt-2">
                                $<?= number_format($plan['precio_plan'], 2) ?> <small class="text-muted fs-6">/ mes</small>
                            </h2>
                            <p class="card-text mt-4 mb-4" style="font-size: 1.1rem;">
                                <i class="fas fa-film text-warning me-2"></i> Límite de <strong><?= esc($plan['cantidad_limite_plan']) ?> rentas</strong>
                            </p>
                            
                            <form action="<?= base_url('cliente/procesar_cambio_plan') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_plan" value="<?= $plan['id_plan'] ?>">
                                <button type="submit" class="btn fw-bold w-100 py-2" style="background-color: #FFCC00; color: #152238;">
                                    ¡Elegir este Plan!
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-danger">Actualmente no hay planes disponibles.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="<?= base_url('cliente/perfil') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Cancelar y volver a mi perfil
        </a>
    </div>
</div>
<?= $this->endSection() ?>