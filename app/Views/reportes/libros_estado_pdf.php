<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Detallado de Libros</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1, h2 { text-align: center; margin-bottom: 10px; }
        .fecha { text-align: right; font-size: 11px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f2f2f2; }
        .vigente { background-color: #dff0d8; } /* verde claro para préstamos activos */
    </style>
</head>
<body>
    <h1>Sistema de Biblioteca</h1>
    <h2>Reporte Detallado de Libros y Ejemplares</h2>
    <div class="fecha">Generado el: <?= date('d/m/Y H:i') ?></div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Año</th>
                <th>Categoría</th>
                <th>Ejemplar</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
            <tr class="<?= !empty($libro['nombre_usuario']) ? 'vigente' : '' ?>">
                <td><?= $libro['titulo'] ?></td>
                <td><?= $libro['autor'] ?></td>
                <td><?= $libro['editorial'] ?></td>
                <td><?= $libro['anio_publicacion'] ?></td>
                <td><?= $libro['nom_categoria'] ?></td>
                <td><?= $libro['codigo_ejemplar'] ?></td>
                <td><?= $libro['estado'] ?></td>
                <td><?= !empty($libro['nombre_usuario']) ? $libro['nombre_usuario'] : '—' ?></td>
                <td><?= !empty($libro['fecha_prestamo']) ? date('d/m/Y', strtotime($libro['fecha_prestamo'])) : '—' ?></td>
                <td><?= !empty($libro['fecha_devolucion']) ? date('d/m/Y', strtotime($libro['fecha_devolucion'])) : '—' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
