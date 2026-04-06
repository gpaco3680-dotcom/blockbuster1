<?= $this->extend('Layouts/operador_layout') ?>

<?= $this->section('content') ?>
<h2>Validación de Pagos Pendientes</h2>

<table class="table">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Tarjeta (Simulación)</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pagos as $pago): ?>
        <tr>
            <td><?= $pago['nombre_usuario'] ?> <?= $pago['ap_usuario'] ?></td>
            <td>**** **** **** <?= substr($pago['tarjeta_pago'], -4) ?></td> <td>$<?= $pago['monto_pago'] ?></td>
            <td><?= $pago['fecha_registro_pago'] ?></td>
            <td>
                <form action="<?= base_url('operador/pagos/aprobar/'.$pago['id_pago']) ?>" method="POST">
                    <button type="submit" class="btn btn-success">Autorizar Acceso</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>