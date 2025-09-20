<h2>📚 Reporte de Libros</h2>
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
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('reportes/libros_pdf') ?>" class="btn btn-success mt-3">📄 Exportar a PDF</a>
