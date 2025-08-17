<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar Usuario de Biblioteca</h2>

<form action="<?= base_url('usuarios-biblioteca/update/' . $usuario['id']) ?>" method="post">
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= esc($usuario['nombre']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Carné</label>
        <input type="text" name="carne" class="form-control" value="<?= esc($usuario['carne']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="correo" class="form-control" value="<?= esc($usuario['correo']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="rol" class="form-select">
            <option value="Alumno" <?= $usuario['rol'] === 'Alumno' ? 'selected' : '' ?>>Alumno</option>
            <option value="Bibliotecario" <?= $usuario['rol'] === 'Bibliotecario' ? 'selected' : '' ?>>Bibliotecario</option>
            <option value="Admin" <?= $usuario['rol'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="<?= base_url('usuarios-biblioteca') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>
