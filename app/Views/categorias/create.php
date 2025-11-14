<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Añadir Categoría</h2>

<?php if(session('errors')): ?>
<div class="alert alert-danger">
    <ul>
        <?php foreach(session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= base_url('categorias/store') ?>" method="post">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= old('nombre') ?>" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"><?= old('descripcion') ?></textarea>
    </div>

    <button type="submit" class="btn btn-success mt-2">Guardar</button>
</form>

<?= $this->endSection() ?>
