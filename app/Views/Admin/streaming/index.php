<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Streaming</h2>
<a href="/admin/streaming/create">Crear Contenido</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Duración</th>
        <th>Temporadas</th>
        <th>Clasificación</th>
        <th>Estatus</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($streaming as $item): ?>
    <tr>
        <td><?= $item['id_streaming'] ?></td>
        <td><?= esc($item['nombre_streaming']) ?></td>
        <td><?= esc($item['duracion_streaming']) ?></td>
        <td><?= esc($item['temporadas_streaming']) ?></td>
        <td><?= esc($item['clasificacion_streaming']) ?></td>
        <td><?= $item['estatus_streaming'] ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <a href="/admin/streaming/edit/<?= $item['id_streaming'] ?>">Editar</a>
            <a href="/admin/streaming/delete/<?= $item['id_streaming'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>
