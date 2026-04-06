<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Editar Streaming</h2>
<form action="/admin/streaming/update/<?= $streaming['id_streaming'] ?>" method="post">
    <label>Nombre</label>
    <input type="text" name="nombre" value="<?= esc($streaming['nombre_streaming']) ?>" required>

    <label>Duración</label>
    <input type="text" name="duracion" value="<?= esc($streaming['duracion_streaming']) ?>" required>

    <label>Temporadas</label>
    <input type="number" name="temporadas" value="<?= esc($streaming['temporadas_streaming']) ?>" required>

    <label>Carátula</label>
    <input type="text" name="caratula" value="<?= esc($streaming['caratula_streaming']) ?>" required>

    <label>Género</label>
    <select name="id_genero" required>
        <?php foreach ($generos as $genero): ?>
        <option value="<?= $genero['id_genero'] ?>" <?= $genero['id_genero'] == $streaming['id_genero'] ? 'selected' : '' ?>><?= esc($genero['nombre_genero']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Clasificación</label>
    <input type="text" name="clasificacion" value="<?= esc($streaming['clasificacion_streaming']) ?>" required>

    <label>Estatus</label>
    <select name="estatus">
        <option value="1" <?= $streaming['estatus_streaming'] ? 'selected' : '' ?>>Activo</option>
        <option value="0" <?= !$streaming['estatus_streaming'] ? 'selected' : '' ?>>Inactivo</option>
    </select>

    <button type="submit">Actualizar</button>
</form>
<?= $this->endSection() ?>
