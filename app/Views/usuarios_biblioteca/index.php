<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Usuarios de Biblioteca</h2>

<!-- ➕ Botón de agregar usuario arriba -->
<?php if (tienePermiso('crear', 'usuarios')): ?>
    <a href="<?= base_url('usuarios-biblioteca/create') ?>" class="btn btn-primary mb-3">+ Agregar Usuario</a>
<?php endif; ?>

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
            <?php if (session()->get('rol_usuario') !== 'Bibliotecario'): ?>
                <th>Rol</th>
            <?php endif; ?>
            <?php if (tienePermiso('ver_contraseña', 'usuarios')): ?>
                <th>Contraseña</th>
            <?php endif; ?>
            <?php if (tienePermiso('editar', 'usuarios') || tienePermiso('eliminar', 'usuarios')): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= esc($u['nombre']) ?></td>
            <td><?= esc($u['carne']) ?></td>
            <td><?= esc($u['correo']) ?></td>
            <?php if (session()->get('rol_usuario') !== 'Bibliotecario'): ?>
                <td><?= esc($u['rol']) ?></td>
            <?php endif; ?>
            <?php if (tienePermiso('ver_contraseña', 'usuarios')): ?>
                <td><?= esc($u['password'] ?? '••••••') ?></td>
            <?php endif; ?>
            <?php if (tienePermiso('editar', 'usuarios') || tienePermiso('eliminar', 'usuarios')): ?>
                <td>
                    <?php if (tienePermiso('editar', 'usuarios')): ?>
                        <a href="<?= base_url('usuarios-biblioteca/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                    <?php endif; ?>
                    <?php if (tienePermiso('eliminar', 'usuarios')): ?>
                        <a href="<?= base_url('usuarios-biblioteca/delete/' . $u['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
