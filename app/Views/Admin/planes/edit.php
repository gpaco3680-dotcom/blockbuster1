<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Editar Plan</h2>
<form action="/admin/planes/update/<?= $plan['id_plan'] ?>" method="post">
    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= esc($plan['nombre_plan']) ?>" required>

    <label>Precio</label>
    <input type="number" name="precio" step="0.01" value="<?= esc($plan['precio_plan']) ?>" required>

    <label>Límite</label>
    <input type="number" name="limite" value="<?= esc($plan['cantidad_limite_plan']) ?>" required>

    <label>Estatus</label>
    <select name="estatus">
        <option value="1" <?= $plan['estatus_plan'] ? 'selected' : '' ?>>Activo</option>
        <option value="0" <?= !$plan['estatus_plan'] ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <button type="submit">Actualizar</button>
</form>
<?= $this->endSection() ?>
