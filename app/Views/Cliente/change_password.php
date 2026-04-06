<?= $this->extend('Layouts/public_layout') ?>

<?= $this->section('content') ?>
<div class="section-header mb-4">
    <h2 class="section-title">Cambiar Contraseña</h2>
    <p class="text-muted">Actualiza tu contraseña para mantener tu cuenta segura.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('cliente/change-password') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña Actual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>