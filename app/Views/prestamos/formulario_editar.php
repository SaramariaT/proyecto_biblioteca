<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>✏️ Editar Préstamo</h2>

<form action="<?= base_url('prestamos/actualizar/' . esc($prestamo['id'])) ?>" method="post" class="mt-4">

    <!-- Usuario -->
    <div class="mb-3">
        <label for="id_usuario" class="form-label">Usuario</label>
        <select name="id_usuario" id="id_usuario" class="form-select" required>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= esc($u['id']) ?>" <?= $u['id'] == $prestamo['id_usuario'] ? 'selected' : '' ?>>
                    <?= esc($u['nombre']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Libro -->
    <div class="mb-3">
        <label for="id_libro" class="form-label">Libro</label>
        <select name="id_libro" id="id_libro" class="form-select" required>
            <?php foreach ($libros as $libro): ?>
                <option value="<?= esc($libro['id']) ?>" <?= $libro['id'] == $prestamo['id_libro'] ? 'selected' : '' ?>>
                    <?= esc($libro['codigo']) ?> - <?= esc($libro['titulo']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Fechas -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="fecha_prestamo" class="form-label">Fecha de Préstamo</label>
            <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control"
                   value="<?= esc($prestamo['fecha_prestamo']) ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="fecha_devolucion" class="form-label">Fecha Esperada de Devolución</label>
            <input type="date" name="fecha_devolucion" id="fecha_devolucion" class="form-control"
                   value="<?= esc($prestamo['fecha_devolucion']) ?>" required>
        </div>
    </div>

    <!-- Fecha real de devolución -->
    <div class="mb-3">
        <label for="fecha_real_devolucion" class="form-label">Fecha Real de Devolución</label>
        <input type="date" name="fecha_real_devolucion" id="fecha_real_devolucion" class="form-control"
               value="<?= esc($prestamo['fecha_real_devolucion']) ?>">
    </div>

    <!-- Estado -->
    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select">
            <option value="Prestado" <?= $prestamo['estado'] === 'Prestado' ? 'selected' : '' ?>>Prestado</option>
            <option value="Devuelto" <?= $prestamo['estado'] === 'Devuelto' ? 'selected' : '' ?>>Devuelto</option>
            <option value="Retrasado" <?= $prestamo['estado'] === 'Retrasado' ? 'selected' : '' ?>>Retrasado</option>
        </select>
    </div>

    <!-- Retraso -->
    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="retraso" id="retraso" value="1"
               <?= $prestamo['retraso'] == '1' ? 'checked' : '' ?>>
        <label class="form-check-label" for="retraso">
            Marcar como devuelto con retraso
        </label>
    </div>

    <!-- Botones -->
    <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
    <a href="<?= base_url('prestamos') ?>" class="btn btn-secondary ms-2">↩️ Cancelar</a>
</form>

<script>
    document.getElementById('fecha_prestamo').addEventListener('change', function() {
        document.getElementById('fecha_devolucion').min = this.value;
    });
</script>

<?= $this->endSection() ?>
