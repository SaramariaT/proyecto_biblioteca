<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif ?>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
<?php endif ?>

<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Listado de Préstamos de Libros</h2>

<a href="<?= base_url('prestamos/nuevo') ?>" class="btn btn-success mb-3">📄 Registrar nuevo préstamo</a>

<?php if (!empty($prestamos)): ?>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Detalle</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestamos as $p): ?>
            <tr>
                <td><?= esc($p['usuario']) ?></td>
                <td><?= esc($p['codigo_libro']) ?> - <?= esc($p['libro']) ?></td>
                <td><?= date('d/m/Y', strtotime($p['fecha_prestamo'])) ?></td>
                <td><?= date('d/m/Y', strtotime($p['fecha_devolucion'])) ?></td>

                <!-- Estado -->
                <td>
                    <?php if ($p['estado'] === 'Devuelto'): ?>
                        <span class="badge bg-success">Devuelto</span>
                    <?php elseif ($p['estado'] === 'Prestado'): ?>
                        <?php if (date('Y-m-d') > $p['fecha_devolucion']): ?>
                            <span class="badge bg-danger">Vencido</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Prestado</span>
                        <?php endif ?>
                    <?php elseif ($p['estado'] === 'Retrasado'): ?>
                        <span class="badge bg-danger">Retrasado</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Desconocido</span>
                    <?php endif ?>
                </td>

                <!-- Detalle -->
                <td>
                    <?php if ($p['estado'] === 'Devuelto'): ?>
                        <?php if (!empty($p['retraso']) && $p['retraso']): ?>
                            <span class="badge bg-danger">Con retraso</span>
                        <?php else: ?>
                            <span class="badge bg-primary">A tiempo</span>
                        <?php endif ?>
                    <?php elseif ($p['estado'] === 'Prestado'): ?>
                        <?php if (date('Y-m-d') > $p['fecha_devolucion']): ?>
                            <span class="badge bg-danger">⚠️ Devolución pendiente</span>
                        <?php else: ?>
                            <span class="badge bg-info text-dark">En curso</span>
                        <?php endif ?>
                    <?php elseif (!empty($p['progreso']) && $p['progreso'] === 'completado'): ?>
                        <span class="badge bg-success">Completado</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Sin progreso</span>
                    <?php endif ?>
                </td>

                <!-- Acciones -->
                <td>
                    <a href="<?= base_url('prestamos/editar/' . $p['id']) ?>" class="btn btn-sm btn-outline-secondary">✏️ Editar</a>
                    <?php if ($p['estado'] === 'Prestado'): ?>
                        <a href="<?= base_url('prestamos/devolver/' . $p['id']) ?>" 
                           class="btn btn-sm btn-outline-success"
                           onclick="return confirm('¿Marcar este préstamo como devuelto?')">
                            ✅ Devolver
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No hay préstamos registrados.</div>
<?php endif; ?>

<?= $this->endSection() ?>
