<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Crear Plan</h2>
<form action="/admin/planes/store" method="post">
    <label>Nombre</label>
    <input type="text" name="nombre" required>

    <label>Precio</label>
    <input type="number" name="precio" step="0.01" required>

    <label>Límite</label>
    <input type="number" name="limite" required>

    <label>Estatus</label>
    <select name="estatus">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>

    <button type="submit">Guardar</button>
</form>
<?= $this->endSection() ?>
