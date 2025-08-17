<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Usuarios de Biblioteca</h2>
<a href="<?= base_url('usuarios-biblioteca/create') ?>" class="btn btn-primary mb-3">+ Agregar Usuario</a>

<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('mensaje') ?></div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Carné</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= esc($u['nombre']) ?></td>
            <td><?= esc($u['carne']) ?></td>
            <td><?= esc($u['correo']) ?></td>
            <td><?= esc($u['rol']) ?></td>
            <td>
                <a href="<?= base_url('usuarios-biblioteca/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="<?= base_url('usuarios-biblioteca/delete/' . $u['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
