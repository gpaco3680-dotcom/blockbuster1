<?= $this->extend('Layouts/admin_layout') ?>

<?= $this->section('content') ?>
<h2>Planes</h2>
<a href="/admin/planes/create">Crear Plan</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Límite</th>
        <th>Estatus</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($planes as $plan): ?>
    <tr>
        <td><?= $plan['id_plan'] ?></td>
        <td><?= esc($plan['nombre_plan']) ?></td>
        <td><?= esc($plan['precio_plan']) ?></td>
        <td><?= esc($plan['cantidad_limite_plan']) ?></td>
        <td><?= $plan['estatus_plan'] ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <a href="/admin/planes/edit/<?= $plan['id_plan'] ?>">Editar</a>
            <a href="/admin/planes/delete/<?= $plan['id_plan'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>
