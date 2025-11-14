<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container">

    <h4 class="fw-bold mb-3">
        <i class="fa-solid fa-pen-to-square me-2"></i> Editar Tarea
    </h4>

    <!-- MENSAJES -->
    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
    <?php endif; ?>

    <div class="card p-4 shadow-sm">
        <form action="<?= site_url('tareas/update/' . $tarea['id_tarea']) ?>" method="post">

            <div class="row mb-3">
                <!-- Usuario -->
                <div class="col-md-6">
                    <label class="form-label">Usuario Asignado</label>
                    <select name="id_usuario" class="form-select">
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id_usuario'] ?>"
                                <?= old('id_usuario', $tarea['id_usuario']) == $u['id_usuario'] ? 'selected' : '' ?>>
                                <?= esc($u['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Título -->
                <div class="col-md-6">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control"
                           value="<?= old('titulo', $tarea['titulo']) ?>">
                </div>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3"><?= old('descripcion', $tarea['descripcion']) ?></textarea>
            </div>

            <div class="row mb-3">
                <!-- Fecha Vencimiento -->
                <div class="col-md-4">
                    <label class="form-label">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="form-control"
                           value="<?= old('fecha_vencimiento', $tarea['fecha_vencimiento']) ?>">
                </div>

                <!-- Prioridad -->
                <div class="col-md-4">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select">
                        <option value="baja" <?= old('prioridad', $tarea['prioridad']) == 'baja' ? 'selected' : '' ?>>Baja</option>
                        <option value="media" <?= old('prioridad', $tarea['prioridad']) == 'media' ? 'selected' : '' ?>>Media</option>
                        <option value="alta" <?= old('prioridad', $tarea['prioridad']) == 'alta' ? 'selected' : '' ?>>Alta</option>
                    </select>
                </div>

                <!-- Estado -->
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="pendiente" <?= old('estado', $tarea['estado']) == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="en progreso" <?= old('estado', $tarea['estado']) == 'en progreso' ? 'selected' : '' ?>>En Progreso</option>
                        <option value="completada" <?= old('estado', $tarea['estado']) == 'completada' ? 'selected' : '' ?>>Completada</option>
                    </select>
                </div>
            </div>

            <div class="text-end">
                <a href="<?= site_url('tareas') ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save"></i> Actualizar
                </button>
            </div>

        </form>
    </div>

</div>
<?= $this->endSection() ?>
