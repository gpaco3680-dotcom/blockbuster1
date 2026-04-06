<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="mb-4">
        <h2>Dashboard Administrativo</h2>
        <p class="text-muted">Bienvenido al panel de administración. Desde aquí puedes gestionar usuarios, géneros, planes y contenido streaming.</p>
    </div>

    <div class="row gy-4">
        <div class="col-md-6 col-xl-3">
            <div class="card p-4">
                <h5 class="mb-3">Usuarios registrados</h5>
                <p class="display-6 fw-bold"><?= esc($totalUsuarios) ?></p>
                <a href="/admin/usuarios" class="btn btn-primary btn-sm mt-3">Ver usuarios</a>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card p-4">
                <h5 class="mb-3">Géneros disponibles</h5>
                <p class="display-6 fw-bold"><?= esc($totalGeneros) ?></p>
                <a href="/admin/generos" class="btn btn-primary btn-sm mt-3">Ver géneros</a>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card p-4">
                <h5 class="mb-3">Planes activos</h5>
                <p class="display-6 fw-bold"><?= esc($totalPlanes) ?></p>
                <a href="/admin/planes" class="btn btn-primary btn-sm mt-3">Ver planes</a>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card p-4">
                <h5 class="mb-3">Contenidos streaming</h5>
                <p class="display-6 fw-bold"><?= esc($totalStreaming) ?></p>
                <a href="/admin/streaming" class="btn btn-primary btn-sm mt-3">Ver streaming</a>
            </div>
        </div>
    </div>

    <div class="mt-5 card p-4">
        <h4>Accesos rápidos</h4>
        <div class="d-flex flex-wrap gap-3 mt-3">
            <a href="/admin/usuarios" class="btn btn-outline-primary">Usuarios</a>
            <a href="/admin/generos" class="btn btn-outline-primary">Géneros</a>
            <a href="/admin/planes" class="btn btn-outline-primary">Planes</a>
            <a href="/admin/streaming" class="btn btn-outline-primary">Streaming</a>
            <a href="/admin/change-password" class="btn btn-outline-secondary">Cambiar contraseña</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
