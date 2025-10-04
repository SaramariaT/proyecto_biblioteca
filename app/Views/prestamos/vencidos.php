<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<h2 class="mb-4 text-danger">📛 Préstamos Vencidos</h2>

<a href="<?= base_url('prestamos') ?>" class="btn btn-outline-secondary mb-3">← Volver al listado completo</a>

<?php if (!empty($prestamos)): ?>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Días de retraso</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $p): ?>
            <?php 
                $fechaDev = new DateTime($p['fecha_devolucion']);
                $hoy = new DateTime();
                $diasRetraso = ($hoy > $fechaDev) ? $fechaDev->diff($hoy)->days : 0;
            ?>
            <tr>
                <td><?= esc($p['usuario']) ?></td>
                <td><?= esc($p['codigo_libro']) ?> - <?= esc($p['libro']) ?></td>
                <td><?= date('d/m/Y', strtotime($p['fecha_prestamo'])) ?></td>
                <td><?= date('d/m/Y', strtotime($p['fecha_devolucion'])) ?></td>
                <td class="text-center"><?= $diasRetraso ?></td>
                <td>
                    <span class="badge bg-danger">
                        Vencido <?= $diasRetraso ?> día<?= $diasRetraso !== 1 ? 's' : '' ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('prestamos/devolver/' . $p['id']) ?>" 
                       class="btn btn-sm btn-outline-success"
                       onclick="return confirm('¿Marcar este préstamo como devuelto?')">
                        ✅ Devolver
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No hay préstamos vencidos actualmente.</div>
<?php endif; ?>
<?= $this->endSection() ?>
