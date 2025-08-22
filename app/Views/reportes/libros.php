<h2>📚 Reporte de Libros</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Año</th>
            <th>Stock</th>
            <th>Categoría</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($libros as $libro): ?>
        <tr>
            <td><?= $libro['titulo'] ?></td>
            <td><?= $libro['autor'] ?></td>
            <td><?= $libro['editorial'] ?></td>
            <td><?= $libro['anio'] ?></td>
            <td><?= $libro['stock'] ?></td>
            <td><?= $libro['categoria'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= base_url('reportes/libros_pdf') ?>" class="btn btn-success mt-3">📄 Exportar a PDF</a>
