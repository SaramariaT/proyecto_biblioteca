<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Agregar ejemplar</h2>

<form action="<?= base_url('ejemplares/store') ?>" method="post">
    <input type="hidden" name="id_libro" value="<?= $id_libro ?>">

    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select">
            <option value="Disponible">Disponible</option>
            <option value="Prestado">Prestado</option>
            <option value="Reservado">Reservado</option>
            <option value="Dañado">Dañado</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="<?= base_url('ejemplares/ver/' . $id_libro) ?>" class="btn btn-secondary">Cancelar</a>
</form>


<?= $this->endSection() ?>
