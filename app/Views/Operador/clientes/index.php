<?= $this->extend('Layouts/operador_layout') ?>

<?= $this->section('content') ?>
<h2>Clientes</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Estatus</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
    <tr>
        <td><?= $cliente['id_usuario'] ?></td>
        <td><?= esc($cliente['nombre_usuario'] . ' ' . $cliente['ap_usuario']) ?></td>
        <td><?= esc($cliente['email_usuario']) ?></td>
        <td><?= $cliente['estatus_usuario'] ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <a href="/operador/clientes/aprobar/<?= $cliente['id_usuario'] ?>">Aprobar</a>
            <a href="/operador/clientes/rechazar/<?= $cliente['id_usuario'] ?>">Rechazar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?= $this->endSection() ?>
