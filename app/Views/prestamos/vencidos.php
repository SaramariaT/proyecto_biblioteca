<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<h2 class="mb-4 text-danger">📛 Préstamos Vencidos</h2>

<a href="<?= base_url('prestamos') ?>" class="btn btn-outline-secondary mb-3">← Volver al listado completo</a>

<?php if (!empty($prestamos)): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['usuario']) ?></td>
                <td><?= htmlspecialchars($p['libro'] . ' (' . $p['ejemplar'] . ')') ?></td>
                <td><?= $p['fecha_prestamo'] ?></td>
                <td><?= $p['fecha_devolucion'] ?></td>
                <td><span class="badge bg-danger">Vencido</span></td>
                <td>
                    <a href="<?= base_url('prestamos/devolver/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary">Marcar como devuelto</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No hay préstamos vencidos actualmente.</div>
<?php endif; ?>
<?= $this->endSection() ?>
