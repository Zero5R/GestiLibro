<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column justify-content-between p-3">
            <?= $this->include('layouts/sidebar') ?>
        </div>

        <!-- Content -->
        <div class="content flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold">Listado de libros</h5>
                <a href="#" class="btn btn-primary btn-sm" style="background-color:#a36cf0;border:none;">
                    <i class="fa-solid fa-plus me-2"></i>Añadir Libro
                </a>
            </div>

            <div class="table-responsive bg-white rounded shadow-sm p-3">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Editorial</th>
                            <th>Año</th>
                            <th>Disponibilidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($libros)): ?>
                            <?php foreach ($libros as $libro): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40" class="rounded-circle me-2">
                                            <?= esc($libro['titulo']) ?>
                                        </div>
                                    </td>
                                    <td><?= esc($libro['autor']) ?></td>
                                    <td><?= esc($libro['editorial']) ?></td>
                                    <td><?= esc($libro['anio']) ?></td>
                                    <td>
                                        <?php if ($libro['disponibilidad']): ?>
                                            <span class="badge bg-success">Disponible</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No disponible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="#" class="text-warning me-2"><i class="fa-solid fa-pen"></i></a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay libros registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>