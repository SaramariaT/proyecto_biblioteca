<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<h2 class="mb-4">Registrar Préstamo de Libros</h2>

<?php
    // Calcular fecha de devolución por defecto (7 días después de hoy)
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

    <!-- Ejemplar -->
    <div class="col-md-6">
        <label for="id_ejemplar" class="form-label">Ejemplar:</label>
        <?php if (!empty($ejemplares)): ?>
            <select name="id_ejemplar" id="id_ejemplar" class="form-select" required>
                <?php foreach ($ejemplares as $e): ?>
                    <option value="<?= esc($e['id']) ?>">
                        <?= esc($e['codigo_ejemplar']) ?> - <?= esc($e['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <div class="alert alert-warning">⚠️ No hay ejemplares disponibles para préstamo.</div>
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
    // Ajustar fecha mínima y sugerida de devolución al cambiar la fecha de préstamo
    document.getElementById('fecha_prestamo').addEventListener('change', function() {
        const fechaPrestamo = this.value;
        const fechaDevolucionInput = document.getElementById('fecha_devolucion');

        // Calcular fecha de devolución por defecto (7 días después)
        const fecha = new Date(fechaPrestamo);
        fecha.setDate(fecha.getDate() + 7);
        const fechaFormateada = fecha.toISOString().split('T')[0];

        fechaDevolucionInput.min = fechaPrestamo;
        fechaDevolucionInput.value = fechaFormateada;
    });
</script>

<?= $this->endSection() ?>
