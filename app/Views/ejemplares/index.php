<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Ejemplares de: <?= esc($libro['titulo']) ?></h2>
<a href="<?= base_url('libros') ?>" class="btn btn-secondary mb-3">← Regresar a Libros</a>
<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('mensaje') ?>
    </div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ejemplares as $e): ?>
            <tr>
                <td><?= esc($e['codigo_ejemplar']) ?></td>
                <td><?= esc($e['estado']) ?></td>
                <td>
                    <a href="<?= base_url('ejemplares/delete/' . $e['id']) ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
