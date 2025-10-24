<?php $user = $authUser ?? null; ?>

<div class="sidebar d-flex flex-column justify-content-between p-3"
    style="width: 260px; background-color: #fff4e6; min-height: 100vh;">
    <div>
        <h4 class="fw-bold mb-4 text-center "><i class="fa-solid fa-book me-2"></i><?php echo APP_NAME ?></h4>
        <div class="text-center mb-4">
            <img src="public\images\usuario.jpg" class="rounded-circle mb-2" alt="User">
            <h6 class="m-0"><?= esc($user['nombreCompleto'] ?? $user['nombreCompleto'] ?? 'Invitado') ?></h6>
            <small class="text-warning"><?= esc(session('user')['rol'] ?? 'Admin') ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="<?= site_url('dashboard') ?>"
                    class="nav-link d-flex align-items-center"><i class="fa-solid fa-house me-2"></i>
                    <span>Home</span></a></li>
            <li class="nav-item mb-2"><a href="<?= base_url('usuarios') ?>"
                    class="nav-link d-flex align-items-center"><i class="fa-solid fa-user me-2"></i>
                    <span>Usuarios</span></a>

        <li class="nav-item mb-2">
    <a href="<?= site_url('roles') ?>" class="nav-link">
        <i class="fa-solid fa-user-gear me-2"></i> Roles
    </a>
</li>


            <li class="nav-item mb-2"><a href="<?= site_url('libros') ?>" class="nav-link"><i
                        class="fa-solid fa-book-open me-2"></i> Libros</a></li>
            <li class="nav-item mb-2"><a href="<?= site_url('categorias') ?>" class="nav-link"><i
                        class="fa-solid fa-tags me-2"></i> Categorías</a></li>
            <li class="nav-item mb-2"><a href="<?= site_url('prestamos') ?>" class="nav-link"><i
                        class="fa-solid fa-handshake me-2"></i> Préstamos</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url('auditoria') ?>"><i 
                        class="fa-solid fa-shield-halved me-2"></i> Auditoría</a></li>
            <li class="nav-item mb-2"><a href="<?= site_url('tareas') ?>"
                    class="nav-link d-flex align-items-center text-dark"><i
                        class="fa-solid fa-list-check me-2"></i><span>Gestión de Tareas</span></a>
        </ul>
    </div>
    <a href="<?= site_url('logout') ?>" class="nav-link text-danger mt-auto"><i
            class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a>
</div>