<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Agregar Libro</h2>
<form action="<?= base_url('libros/store') ?>" method="post" class="row g-3">

    <div class="col-md-4">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control" required>
    </div>

    <div class="col-md-8">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control">
    </div>

    <div class="col-md-6">
        <label for="genero" class="form-label">Género</label>
        <input type="text" name="genero" class="form-control">
    </div>

    <div class="col-md-4">
        <label for="paginas" class="form-label">Páginas</label>
        <input type="number" name="paginas" class="form-control" min="1">
    </div>

    <div class="col-md-4">
        <label for="numero_ejemplar" class="form-label">Nº Ejemplar</label>
        <input type="number" name="numero_ejemplar" class="form-control" min="1" required>
    </div>

    <div class="col-md-4">
        <label for="total_ejemplares" class="form-label">Total Ejemplares</label>
        <input type="number" name="total_ejemplares" class="form-control" min="1" required>
    </div>

    <div class="col-md-6">
        <label for="nivel" class="form-label">Nivel</label>
        <input type="text" name="nivel" class="form-control">
    </div>

    <div class="col-md-6">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
            <option value="Disponible">Disponible</option>
            <option value="Prestado">Prestado</option>
        </select>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= base_url('libros') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?= $this->endSection() ?>
