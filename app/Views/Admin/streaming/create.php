<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Crear Streaming</h2>
<form action="/admin/streaming/store" method="post">
    <label>Nombre</label>
    <input type="text" name="nombre" required>

    <label>Duración</label>
    <input type="text" name="duracion" required>

    <label>Temporadas</label>
    <input type="number" name="temporadas" required>

    <label>Carátula</label>
    <input type="text" name="caratula" required>

    <label>Género</label>
    <select name="id_genero" required>
        <?php foreach ($generos as $genero): ?>
        <option value="<?= $genero['id_genero'] ?>"><?= esc($genero['nombre_genero']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Clasificación</label>
    <input type="text" name="clasificacion" required>

    <label>Estatus</label>
    <select name="estatus">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>

    <button type="submit">Guardar</button>
</form>
<?= $this->endSection() ?>
