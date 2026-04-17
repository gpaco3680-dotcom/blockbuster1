<?= $this->extend($layout_a_usar) ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header text-white text-center py-4" style="background-color: #152238; border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i> Mis Datos Personales</h4>
                </div>
                
                <div class="card-body p-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <form action="<?= base_url('mi_perfil/actualizar') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <?php 
                                    $foto = !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'default.png'; 
                                ?>
                                <img src="<?= base_url('uploads/perfiles/'.$foto) ?>" id="imgPreview" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #1f4f8b;">
                                <label for="foto_perfil" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="foto_perfil" id="foto_perfil" class="d-none" accept="image/*" onchange="preview(this)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" value="<?= esc($usuario['nombre_usuario']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" value="<?= esc($usuario['email_usuario']) ?>" required>
                        </div>

                        <div class="alert alert-light py-2 shadow-sm border text-center">
                            <small class="text-muted"><i class="fas fa-info-circle"></i> Deja la contraseña en blanco para no cambiarla.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-lg text-white fw-bold shadow-sm" style="background-color: #1f4f8b;">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function preview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?= $this->endSection() ?>