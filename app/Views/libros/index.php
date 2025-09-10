<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Listado de Libros</h2>

<div class="mb-3 d-flex gap-2">
    <a href="<?= base_url('libros/create') ?>" class="btn btn-primary">➕ Agregar Libro</a>
    <a href="<?= base_url('reportes/libros_estado_pdf') ?>" class="btn btn-outline-info">📘 Reporte Detallado</a>
</div>

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
        <th>Acciones</th>
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
                <a href="<?= base_url('libros/edit/'.$libro['id']) ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="<?= base_url('ejemplares/create/' . $libro['id']) ?>" class="btn btn-info btn-sm">Agregar ejemplar</a>
                <a href="<?= base_url('ejemplares/ver/' . $libro['id']) ?>" class="btn btn-info">Ver ejemplares</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
