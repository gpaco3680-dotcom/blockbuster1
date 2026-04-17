<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4" style="background-color: #f8faff;">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php 
                            // Buscamos la foto guardada en la sesión (que actualizamos en el controlador)
                            $fotoPerfil = session()->get('foto_perfil'); 
                        ?>
                        
                        <?php if (!empty($fotoPerfil) && $fotoPerfil !== 'default.png'): ?>
                            <img src="<?= base_url('uploads/perfiles/' . $fotoPerfil) ?>" 
                                 class="rounded-circle shadow-sm border border-3 border-primary" 
                                 style="width: 100px; height: 100px; object-fit: cover;" 
                                 alt="Foto de perfil">
                        <?php else: ?>
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        <?php endif; ?>
                    </div>

                    <h4 class="fw-bold text-dark">
                        <?= esc(session()->get('nombre') ?? 'Usuario') ?>
                    </h4>
                    <p class="text-muted small mb-2">Cliente Blockbuster</p>
                    
                    <a href="<?= base_url('mi_perfil/editar') ?>" class="btn btn-sm btn-outline-primary fw-bold mb-3">
                        <i class="fas fa-user-cog me-1"></i> Editar Mis Datos
                    </a>
                    
                    <hr>
                    
                    <div class="p-3 rounded" style="background-color: #1f4f8b; color: white;">
                        <?php if (!empty($miPlan)): ?>
                            <p class="mb-1 small text-uppercase" style="letter-spacing: 1px; opacity: 0.8;">Tu Plan Actual:</p>
                            <h4 class="fw-bold mb-1" style="color: #FFCC00;">
                                <?= esc($miPlan['nombre_plan'] ?? 'No tienes un plan activo') ?>
                            </h4>
                            <p class="mb-1 small">
                                <i class="fas fa-ticket-alt me-1"></i> Límite: <?= esc($miPlan['cantidad_limite_plan'] ?? 0) ?> rentas
                            </p>
                            
                            <?php if (!empty($miPlan['fecha_fin_plan'])): ?>
                                <p class="mb-3 small fw-bold" style="color: #ffcccc;">
                                    <i class="fas fa-calendar-times me-1"></i> Vence: <?= date('d/m/Y', strtotime($miPlan['fecha_fin_plan'])) ?>
                                </p>
                            <?php endif; ?>

                            <hr style="border-color: rgba(255,255,255,0.2);">
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('cliente/planes') ?>" class="btn btn-sm fw-bold shadow-sm" style="background-color: #FFCC00; color: #152238;">
                                    <i class="fas fa-sync-alt"></i> Cambiar Plan
                                </a>
                                <a href="<?= base_url('cliente/cancelar_plan') ?>" 
                                class="btn btn-sm btn-outline-light small" 
                                style="border-color: rgba(255,255,255,0.3);"
                                onclick="return confirm('¿Estás seguro de cancelar tu plan? Perderás el acceso a rentas.')">
                                    Cancelar suscripción
                                </a>
                            </div>

                        <?php else: ?>
                            <p class="mb-1 small text-uppercase" style="letter-spacing: 1px; opacity: 0.8;">Estado del Servicio:</p>
                            <h4 class="fw-bold mb-3" style="color: #ffcccc;">Suscripción Cancelada</h4>
                            <div class="d-grid gap-2">
                                <a href="<?= base_url('cliente/planes') ?>" class="btn btn-lg fw-bold shadow-sm" style="background-color: #FFCC00; color: #152238;">
                                    <i class="fas fa-redo"></i> RENOVAR PLAN
                                </a>
                            </div>
                        <?php endif; ?>
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
            <?php 
                $rentasTotales = count($alquileres);
                $limitePlan = $miPlan['cantidad_limite_plan'] ?? 0;
                if (!empty($miPlan) && $rentasTotales >= $limitePlan && $limitePlan > 0): 
            ?>
                <div class="alert alert-warning border-0 shadow-sm mb-4 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading fw-bold mb-1">¡Límite de rentas alcanzado!</h5>
                            <span>Has utilizado tus <strong><?= $limitePlan ?></strong> rentas permitidas. Para alquilar más contenido, por favor <a href="<?= base_url('cliente/planes') ?>" class="fw-bold text-dark">mejora tu plan aquí</a>.</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

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
                                <th class="text-center">Acción</th> </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($alquileres)): ?>
                                <?php foreach($alquileres as $alq): ?>
                                    <tr>
                                        <td class="fw-bold"><?= esc($alq['nombre_streaming']) ?></td>
                                        <td><?= esc($alq['fecha_inicio_alquiler']) ?></td>
                                        <td><?= esc($alq['fecha_fin_alquiler']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= ($alq['estatus_alquiler'] == 1) ? 'success' : 'warning' ?>">
                                                <?= ($alq['estatus_alquiler'] == 1) ? 'Culminado' : 'En Proceso' ?>
                                            </span>
                                        </td>
                                        <td class="text-center"> 
                                            <?php if($alq['estatus_alquiler'] == 0): ?>
                                                <a href="<?= base_url('cliente/regresar_pelicula/'.$alq['id_alquiler']) ?>" 
                                                   class="btn btn-sm btn-outline-danger fw-bold"
                                                   onclick="return confirm('¿Confirmas que deseas devolver esta película?')">
                                                     <i class="fas fa-undo"></i> Devolver
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small italic">Entregado</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted py-3">No tienes alquileres registrados todavía.</td></tr>
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
                                        <td><?= date('d/m/Y', strtotime($p['fecha_registro_pago'])) ?></td>
                                        <td>**** <?= esc(substr($p['tarjeta_pago'], -4)) ?></td>
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
<?= $this->endSection() ?>