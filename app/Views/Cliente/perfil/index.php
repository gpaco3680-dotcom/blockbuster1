<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="section-header mb-4">
    <h2 class="section-title">Mi Perfil</h2>
    <p class="text-muted">Revisa tu plan, tus alquileres activos y los beneficios disponibles para tu cuenta.</p>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card p-4">
            <h4 class="card-title">Resumen del plan</h4>
            <?php if (!empty($miPlan)): ?>
                <p class="card-text"><strong>Plan actual:</strong> <?= esc($miPlan['nombre_plan']) ?></p>
                <p class="card-text"><strong>Precio:</strong> $<?= esc($miPlan['precio_plan']) ?> / mes</p>
                <p class="card-text"><strong>Límite mensual:</strong> <?= esc($miPlan['cantidad_limite_plan']) ?> títulos</p>
                <p class="card-text"><strong>Estado:</strong> <span class="badge badge-primary">Activo</span></p>
            <?php else: ?>
                <p class="card-text text-danger">No tienes un plan asignado. Contacta a un operador para habilitar tu acceso.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card p-4">
            <h4 class="card-title">Beneficios disponibles</h4>
            <p class="card-text">Con tu plan actual podrás acceder a los mejores contenidos, rentar títulos rápidamente y recibir asistencia prioritaria del operador.</p>
            <ul class="list-unstyled">
                <li><span class="badge badge-outline me-2">✔</span> Acceso a catálogo completo</li>
                <li><span class="badge badge-outline me-2">✔</span> Rentas rápidas y seguras</li>
                <li><span class="badge badge-outline me-2">✔</span> Historial de alquileres</li>
            </ul>
        </div>
    </div>
</div>

<div class="card mt-4 p-4">
    <h4 class="card-title mb-3">Mis alquileres</h4>
    <?php if (!empty($alquileres)): ?>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Inicio</th>
                        <th>Vencimiento</th>
                        <th>Días restantes</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alquileres as $alquiler): ?>
                        <?php 
                            $fecha_fin = new \DateTime($alquiler['fecha_fin_alquiler']);
                            $hoy = new \DateTime();
                        ?>
                        <tr>
                            <td><?= esc($alquiler['nombre_streaming']) ?></td>
                            <td><?= esc($alquiler['fecha_inicio_alquiler']) ?></td>
                            <td><?= esc($alquiler['fecha_fin_alquiler']) ?></td>
                            <td>
                                <?php if ($hoy > $fecha_fin): ?>
                                    <span class="badge badge-accent">Expirado</span>
                                <?php else: ?>
                                    <?php $diff = $hoy->diff($fecha_fin); ?>
                                    <span class="badge badge-primary"><?= $diff->days ?> días</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($alquiler['estatus_alquiler']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Aún no tienes alquileres activos. Busca en el catálogo y renta tu próximo película o serie.</div>
    <?php endif; ?>
</div>

<div class="card mt-4 p-4">
    <h4 class="card-title mb-3">Simulación de pago</h4>
    <form action="<?= base_url('cliente/pagar') ?>" method="POST">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label" for="num_tarjeta">Número de tarjeta (Simulación)</label>
                <input type="text" name="num_tarjeta" id="num_tarjeta" class="form-control" placeholder="1234 5678 9012 3456" required>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="monto">Monto</label>
                <input type="number" name="monto" id="monto" class="form-control" value="<?= $miPlan['precio_plan'] ?? 0 ?>" readonly>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Simular pago</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>