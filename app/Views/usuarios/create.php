<?= $this->extend('layouts/main') ?>
<?php helper('form'); ?>

<?= $this->section('content') ?>

<style>
    .form-wrapper {
        max-width: 800px;              /* Más ancho */
        margin: 0 auto;                /* Centrado */
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .title-section {
        text-align: center;
        margin-bottom: 25px;
    }
</style>

<div class="container">

    <div class="title-section">
        <h3 class="fw-bold">
            <i class="fa-solid fa-user-plus me-2"></i> Nuevo Usuario
        </h3>
    </div>

    <div class="form-wrapper">

        <form action="<?= site_url('usuarios/store') ?>" method="post">

            <!-- Nombre -->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" value="<?= old('nombre') ?>" class="form-control">
                <div class="text-danger"><?= validation_show_error('nombre') ?></div>
            </div>

            <!-- Apellido -->
            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" value="<?= old('apellido') ?>" class="form-control">
                <div class="text-danger"><?= validation_show_error('apellido') ?></div>
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" value="<?= old('correo') ?>" class="form-control">
                <div class="text-danger"><?= validation_show_error('correo') ?></div>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="username" value="<?= old('username') ?>" class="form-control">
                <div class="text-danger"><?= validation_show_error('username') ?></div>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control">
                <div class="text-danger"><?= validation_show_error('contrasena') ?></div>
            </div>

            <!-- Rol -->
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="id_rol" class="form-select">
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['id_rol'] ?>" <?= old('id_rol') == $rol['id_rol'] ? 'selected' : '' ?>>
                            <?= esc($rol['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-danger"><?= validation_show_error('id_rol') ?></div>
            </div>

            <!-- Botones -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success px-4">Guardar</button>
                <a href="<?= site_url('usuarios') ?>" class="btn btn-secondary px-4">Cancelar</a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>
