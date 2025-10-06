<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Listado de Libros</h2>

<!-- ✅ Mensaje flash -->
<?php if (!empty($mensaje)) : ?>
    <div class="alert alert-success">
        <?= esc($mensaje) ?>
    </div>
<?php endif; ?>

<!-- 📚 Acciones -->
<?php if (tienePermiso('crear', 'libros')): ?>
<div class="mb-3 d-flex gap-2">
    <a href="<?= base_url('libros/create') ?>" class="btn btn-primary">➕ Agregar Libro</a>
    <a href="<?= base_url('reportes/libros_estado_pdf') ?>" class="btn btn-outline-info">📘 Reporte Detallado</a>
</div>
<?php endif; ?>

<!-- 🔍 Buscador debajo de los botones -->
<form method="get" action="<?= base_url('libros') ?>" class="mb-3 d-flex gap-2">
    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por título, autor o género" value="<?= esc($busqueda ?? '') ?>">
    <button type="submit" class="btn btn-success">Buscar</button>
    <a href="<?= base_url('libros') ?>" class="btn btn-secondary">Limpiar</a>
</form>

<!-- 📋 Tabla -->
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Código</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Género</th>
        <th>Páginas</th>
        <th>N° Ejemplar</th>
        <th>Total Ejemplares</th>
        <th>Nivel</th>
        <th>Estado</th>
        <?php if (tienePermiso('editar', 'libros')): ?>
            <th>Editar</th>
        <?php endif; ?>
    </tr>
    </thead>

    <tbody>
        <?php foreach ($libros as $libro): ?>
        <tr>
            <td><?= esc($libro['codigo']) ?></td>
            <td><?= esc($libro['titulo']) ?></td>
            <td><?= esc($libro['autor']) ?></td>
            <td><?= esc($libro['genero']) ?></td>
            <td><?= esc($libro['paginas']) ?></td>
            <td><?= esc($libro['numero_ejemplar']) ?></td>
            <td><?= esc($libro['total_ejemplares']) ?></td>
            <td><?= esc($libro['nivel']) ?></td>
            <td>
                <span class="badge <?= $libro['estado'] === 'Disponible' ? 'bg-success' : 'bg-danger' ?>">
                    <?= esc($libro['estado']) ?>
                </span>
            </td>
            <?php if (tienePermiso('editar', 'libros')): ?>
            <td>
                <a href="<?= base_url('libros/edit/'.$libro['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
