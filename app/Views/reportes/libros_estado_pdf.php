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
        .vigente { background-color: #dff0d8; }
        .retrasado { background-color: #f8b2b2; }
        .leyenda { font-size: 11px; margin-top: 15px; text-align: left; color: #555; }
    </style>
</head>
<body>
    <h1>Sistema de Biblioteca</h1>
    <h2>Reporte Detallado de Libros y Ejemplares</h2>
    <div class="fecha">Generado el: <?= date('d/m/Y H:i') ?></div>

    <table>
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
                <th>Ejemplar</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
                <?php
                    $clase = '';
                    // Determinar clase y estado
                    if (isset($libro['retraso']) && intval($libro['retraso']) === 1) {
                        $clase = 'retrasado';
                        $estadoTexto = 'Prestado';
                    } elseif (!empty($libro['nombre_usuario'])) {
                        $clase = 'vigente';
                        $estadoTexto = 'Prestado';
                    } else {
                        $estadoTexto = 'Disponible';
                    }
                ?>
                <tr class="<?= $clase ?>">
                    <td><?= $libro['codigo'] ?></td>
                    <td><?= $libro['titulo'] ?></td>
                    <td><?= $libro['autor'] ?></td>
                    <td><?= $libro['genero'] ?></td>
                    <td><?= $libro['paginas'] ?></td>
                    <td><?= $libro['numero_ejemplar'] ?></td>
                    <td><?= $libro['total_ejemplares'] ?></td>
                    <td><?= $libro['nivel'] ?></td>
                    <td><?= $libro['codigo_ejemplar'] ?></td>
                    <td><?= $estadoTexto ?></td>
                    <td><?= !empty($libro['nombre_usuario']) ? $libro['nombre_usuario'] : '—' ?></td>
                    <td><?= !empty($libro['fecha_prestamo']) ? date('d/m/Y', strtotime($libro['fecha_prestamo'])) : '—' ?></td>
                    <td><?= !empty($libro['fecha_devolucion']) ? date('d/m/Y', strtotime($libro['fecha_devolucion'])) : '—' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="leyenda">
        <strong>Nota:</strong> Las filas en <span style="color: #a94442;">rojo</span> indican préstamos vencidos.
    </div>
</body>
</html>
