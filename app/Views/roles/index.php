<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="fw-bold mb-3"><i class="fa-solid fa-user-gear me-2"></i> Gestión de Roles</h4>

    <a href="<?= site_url('roles/create') ?>" class="btn btn-success mb-3">
        <i class="fa-solid fa-square-plus me-2"></i> Nuevo Rol
    </a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th style="width: 120px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($roles)): ?>
                <?php foreach($roles as $rol): ?>
                    <tr>
                        <td><?= $rol['id_rol'] ?></td>
                        <td><?= esc($rol['nombre']) ?></td>
                        <td>
                            <a href="<?= site_url('roles/edit/'.$rol['id_rol']) ?>" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= site_url('roles/delete/'.$rol['id_rol']) ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Seguro que deseas eliminar este rol?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No hay roles registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
