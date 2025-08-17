<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar libro</h2>

<form action="<?= base_url('libros/update/' . $libro['id']) ?>" method="post">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="<?= esc($libro['titulo']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" id="autor" class="form-control" value="<?= esc($libro['autor']) ?>">
    </div>

    <div class="mb-3">
        <label for="editorial" class="form-label">Editorial</label>
        <input type="text" name="editorial" id="editorial" class="form-control" value="<?= esc($libro['editorial']) ?>">
    </div>

    <div class="mb-3">
        <label for="anio_publicacion" class="form-label">Año de publicación</label>
        <input type="number" name="anio_publicacion" id="anio_publicacion" class="form-control" value="<?= esc($libro['anio_publicacion']) ?>" min="1000" max="<?= date('Y') ?>">
    </div>

    <div class="mb-3">
        <label for="precio_venta" class="form-label">Precio de venta</label>
        <input type="number" step="0.01" name="precio_venta" id="precio_venta" class="form-control" value="<?= esc($libro['precio_venta']) ?>">
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" name="stock" id="stock" class="form-control" value="<?= esc($libro['stock']) ?>" min="0">
    </div>

    <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select name="id_categoria" id="id_categoria" class="form-select">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= $libro['id_categoria'] == $categoria['id'] ? 'selected' : '' ?>>
                    <?= esc($categoria['nom_categoria']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="<?= base_url('libros') ?>" class="btn btn-secondary">Cancelar</a>
</form>

<?= $this->endSection() ?>
