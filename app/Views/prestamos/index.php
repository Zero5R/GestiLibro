<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php
    $user1 = $user->getUser();
?> 
<div class="container ">
    <h4 class="fw-bold mb-3"><i class="fa-solid fa-users me-2"></i> Gestión de Préstamos</h4>

    <?php if ($librosDisponibles && $user1['id_rol'] ==1 ): ?>
        <div class="mb-4">
            <a href="<?= site_url('prestamos/create') ?>" class="btn btn-success">
                <i class="fa-solid fa-handshake me-2"></i> Nuevo Préstamo
            </a>
        </div>
    <?php elseif ($user1['id_rol']==1): ?>
        <div class="alert alert-warning" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            No es posible crear prestamos sin libros disponibles
        </div>
    <?php endif; ?>
    </div>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prestamos)): ?>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        <td><?= esc($prestamo['id_prestamo']) ?></td>
                        <td><?= esc($prestamo['nombre_usuario']) ?></td>
                        <td><?= esc($prestamo['titulo_libro']) ?></td>
                        <td><?= esc($prestamo['fecha_prestamo']) ?></td>
                        <td><?= esc($prestamo['fecha_devolucion'] ?? '-') ?></td>
                        <td>
                            <?php if ($prestamo['estado'] === 'prestado'): ?>
                                <span class="badge bg-warning text-dark">Prestado</span>
                            <?php elseif ($prestamo['estado'] === 'devuelto'): ?>
                                <span class="badge bg-success">Devuelto</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Atrasado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= site_url('prestamos/edit/' . $prestamo['id_prestamo']) ?>" 
                               class="btn btn-sm btn-info">
                               <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= site_url('prestamos/delete/' . $prestamo['id_prestamo']) ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Seguro que deseas eliminar este préstamo?')">
                               <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay préstamos registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
