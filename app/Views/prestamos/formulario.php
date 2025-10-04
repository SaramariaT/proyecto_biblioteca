<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<h2 class="mb-4">Registrar Préstamo de Libros</h2>

<?php
    $fechaPrestamoDefault = date('Y-m-d');
    $fechaDevolucionDefault = date('Y-m-d', strtotime('+7 days'));
?>

<form method="POST" action="<?= base_url('prestamos/guardar') ?>" class="row g-3">

    <!-- Usuario -->
    <div class="col-md-6">
        <label for="id_usuario" class="form-label">Usuario:</label>
        <?php if (!empty($usuarios)): ?>
            <select name="id_usuario" id="id_usuario" class="form-select" required>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= esc($u['id']) ?>"><?= esc($u['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <div class="alert alert-warning">⚠️ No hay usuarios registrados.</div>
        <?php endif; ?>
    </div>

    <!-- Libro -->
    <div class="col-md-6">
        <label for="id_libro" class="form-label">Libro:</label>
        <?php if (!empty($libros)): ?>
            <select name="id_libro" id="id_libro" class="form-select" required>
                <?php foreach ($libros as $libro): ?>
                    <option value="<?= esc($libro['id']) ?>">
                        <?= esc($libro['codigo']) ?> - <?= esc($libro['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <div class="alert alert-warning">⚠️ No hay libros disponibles para préstamo.</div>
        <?php endif; ?>
    </div>

    <!-- Fecha préstamo -->
    <div class="col-md-6">
        <label for="fecha_prestamo" class="form-label">Fecha préstamo:</label>
        <input type="date" name="fecha_prestamo" id="fecha_prestamo" 
               class="form-control" 
               value="<?= $fechaPrestamoDefault ?>" 
               min="<?= $fechaPrestamoDefault ?>" required>
    </div>

    <!-- Fecha devolución -->
    <div class="col-md-6">
        <label for="fecha_devolucion" class="form-label">Fecha devolución:</label>
        <input type="date" name="fecha_devolucion" id="fecha_devolucion" 
               class="form-control" 
               value="<?= $fechaDevolucionDefault ?>" 
               min="<?= $fechaPrestamoDefault ?>" required>
    </div>

    <!-- Botones -->
    <div class="col-12">
        <button type="submit" class="btn btn-primary">📄 Registrar préstamo</button>
        <a href="<?= base_url('prestamos') ?>" class="btn btn-secondary ms-2">↩️ Volver al listado</a>
    </div>
</form>

<script>
    document.getElementById('fecha_prestamo').addEventListener('change', function() {
        const fechaPrestamo = this.value;
        const fechaDevolucionInput = document.getElementById('fecha_devolucion');

        const fecha = new Date(fechaPrestamo);
        fecha.setDate(fecha.getDate() + 7);
        const fechaFormateada = fecha.toISOString().split('T')[0];

        fechaDevolucionInput.min = fechaPrestamo;
        fechaDevolucionInput.value = fechaFormateada;
    });
</script>

<?= $this->endSection() ?>
