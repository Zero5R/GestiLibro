<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>


<div class="container ">
    <h4 class="fw-bold mb-3"><i class="fa-solid fa-book me-2 "></i> Gestión de Libros</h4>

<div class="mb-4">
    <a href="<?= site_url('libros/create') ?>" class="btn btn-success">
        <i class="fa-solid fa-book-medical me-2"></i> Nuevo Libro
    </a>
</div>


    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Editorial</th>
                <th>Año</th>
                <th>Categoría</th>
                <th>Disponibilidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($libros)): ?>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?= esc($libro['id_libro']) ?></td>
                        <td><?= esc($libro['titulo']) ?></td>
                        <td><?= esc($libro['autor']) ?></td>
                        <td><?= esc($libro['editorial']) ?></td>
                        <td><?= esc($libro['anio']) ?></td>
                        <td><?= esc($libro['nombre_categoria'] ?? 'Sin categoría') ?></td>
                        <td>
                            <?php if ($libro['disponibilidad'] == 'disponible'): ?>
                                <span class="badge bg-success">Disponible</span>
                            <?php elseif($libro['disponibilidad'] == 'no_disponible'): ?>
                                <span class="badge bg-secondary">No disponible</span>
                            <?php elseif($libro['disponibilidad'] == 'prestado'): ?>
                                <span class="badge bg-warning text-dark">Prestado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= site_url('libros/edit/' . $libro['id_libro']) ?>" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= site_url('libros/delete/' . $libro['id_libro']) ?>" 
                               onclick="return confirm('¿Seguro que deseas eliminar este libro?')"
                               class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay libros registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
