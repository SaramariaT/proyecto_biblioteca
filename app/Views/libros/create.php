<?= $this->extend('layouts/panel') ?>
<?= $this->section('content') ?>

<h2>Agregar Libro</h2>
<form action="<?= base_url('libros/store') ?>" method="post" class="row g-3">

    <div class="col-md-6">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control">
    </div>

    <div class="col-md-6">
        <label for="editorial" class="form-label">Editorial</label>
        <input type="text" name="editorial" class="form-control">
    </div>

    <div class="col-md-3">
        <label for="anio_publicacion" class="form-label">Año de publicación</label>
        <input type="number" name="anio_publicacion" class="form-control" min="1900" max="2099">
    </div>

    <div class="col-md-3">
        <label for="precio_venta" class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio_venta" class="form-control">
    </div>

    <div class="col-md-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" min="0">
    </div>

    <div class="col-md-6">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select name="id_categoria" class="form-select" required>
            <option value="">Seleccionar categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['nom_categoria'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="<?= base_url('libros') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<?= $this->endSection() ?>
