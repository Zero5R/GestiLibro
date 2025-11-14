<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Editar Categoría</h2>

<?php if(session('errors')): ?>
<div class="alert alert-danger">
    <ul>
        <?php foreach(session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= base_url('categorias/update/'.$categoria['id_categoria']) ?>" method="post">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= old('nombre', $categoria['nombre']) ?>" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"><?= old('descripcion', $categoria['descripcion']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-success">
        <i class="fa-solid fa-save"></i> Actualizar
    </button>

    <a href="<?= site_url('categorias') ?>" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Cancelar
    </a>
</form>

<?= $this->endSection() ?>
