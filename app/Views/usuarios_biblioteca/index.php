<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Usuarios de Biblioteca</h2>

<!-- ➕ Botón de agregar usuario arriba -->
<a href="<?= base_url('usuarios-biblioteca/create') ?>" class="btn btn-primary mb-3">+ Agregar Usuario</a>

<!-- 🔍 Buscador horizontal con columnas -->
<form method="get" action="<?= base_url('usuarios-biblioteca') ?>" class="mb-3">
    <div class="row g-2">
        <div class="col-md-6 col-lg-8">
            <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre, carné, correo o rol" value="<?= esc($busqueda ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Buscar</button>
        </div>
        <div class="col-auto">
            <a href="<?= base_url('usuarios-biblioteca') ?>" class="btn btn-secondary">Limpiar</a>
        </div>
    </div>
</form>

<!-- ✅ Mensaje flash -->
<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success">
        <strong>Éxito:</strong> <?= esc(session()->getFlashdata('mensaje')) ?>
    </div>
<?php endif; ?>

<!-- 📋 Tabla de usuarios -->
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
