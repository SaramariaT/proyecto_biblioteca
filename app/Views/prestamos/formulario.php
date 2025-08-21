<?= $this->extend('layouts/panel') ?>

<?= $this->section('content') ?>
<h2 class="mb-4">Registrar Préstamo de Libros</h2>

<form method="POST" action="<?= base_url('prestamos/guardar') ?>" class="row g-3">
    <div class="col-md-6">
        <label for="id_usuario" class="form-label">Usuario:</label>
        <select name="id_usuario" id="id_usuario" class="form-select" required>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="id_ejemplar" class="form-label">Ejemplar:</label>
        <select name="id_ejemplar" id="id_ejemplar" class="form-select" required>
            <?php foreach ($ejemplares as $e): ?>
                <option value="<?= $e['id'] ?>">
                    <?= htmlspecialchars($e['codigo_ejemplar'] . ' - ' . $e['titulo']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="fecha_prestamo" class="form-label">Fecha préstamo:</label>
        <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control" value="<?= date('Y-m-d') ?>" required>
    </div>

    <div class="col-md-6">
        <label for="fecha_devolucion" class="form-label">Fecha devolución:</label>
        <input type="date" name="fecha_devolucion" id="fecha_devolucion" class="form-control" required>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">📄 Registrar préstamo</button>
        <a href="<?= base_url('prestamos') ?>" class="btn btn-secondary ms-2">↩️ Volver al listado</a>
    </div>
</form>
<?= $this->endSection() ?>
