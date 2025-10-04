<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar libro</h2>

<form action="<?= base_url('libros/update/' . $libro['id']) ?>" method="post">
    <div class="mb-3">
        <label for="codigo" class="form-label">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="<?= esc($libro['codigo']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="<?= esc($libro['titulo']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" name="autor" id="autor" class="form-control" value="<?= esc($libro['autor']) ?>">
    </div>

    <div class="mb-3">
        <label for="genero" class="form-label">Género</label>
        <input type="text" name="genero" id="genero" class="form-control" value="<?= esc($libro['genero']) ?>">
    </div>

    <div class="mb-3">
        <label for="paginas" class="form-label">Páginas</label>
        <input type="number" name="paginas" id="paginas" class="form-control" value="<?= esc($libro['paginas']) ?>" min="1">
    </div>

    <div class="mb-3">
        <label for="numero_ejemplar" class="form-label">Número de ejemplar</label>
        <input type="number" name="numero_ejemplar" id="numero_ejemplar" class="form-control" value="<?= esc($libro['numero_ejemplar']) ?>" min="1">
    </div>

    <div class="mb-3">
        <label for="total_ejemplares" class="form-label">Total de ejemplares</label>
        <input type="number" name="total_ejemplares" id="total_ejemplares" class="form-control" value="<?= esc($libro['total_ejemplares']) ?>" min="1">
    </div>

    <div class="mb-3">
        <label for="nivel" class="form-label">Nivel</label>
        <input type="text" name="nivel" id="nivel" class="form-control" value="<?= esc($libro['nivel']) ?>">
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select" required>
            <option value="Disponible" <?= $libro['estado'] === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="Prestado" <?= $libro['estado'] === 'Prestado' ? 'selected' : '' ?>>Prestado</option>
        </select>
    </div>

    <!-- Botones alineados -->
    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="<?= base_url('libros') ?>" class="btn btn-secondary">Cancelar</a>
    </form>

    <form action="<?= base_url('libros/delete/' . $libro['id']) ?>" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro? Esta acción no se puede deshacer.');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger">🗑️ Eliminar libro</button>
    </form>
</div>

<?= $this->endSection() ?>
