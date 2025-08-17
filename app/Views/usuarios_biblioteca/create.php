<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Agregar Usuario de Biblioteca</h2>

<form action="<?= base_url('usuarios-biblioteca/store') ?>" method="post">
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Carné</label>
        <input type="text" name="carne" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Rol</label>
        <select name="rol" class="form-select">
            <option value="Alumno">Alumno</option>
            <option value="Bibliotecario">Bibliotecario</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="<?= base_url('usuarios-biblioteca') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>
