<div class="sidebar d-flex flex-column justify-content-between p-3">
    <div>
        <h4 class="fw-bold mb-4"><i class="fa-solid fa-book me-2"></i><?php echo APP_NAME ?></h4>
        <div class="text-center mb-3">
            <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="User">
            <h6 class="m-0"><?= esc(session('user')['nombre'] ?? 'Invitado') ?></h6>
            <small class="text-warning"><?= esc(session('user')['rol'] ?? 'Admin') ?></small>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="<?= site_url('dashboard') ?>" class="nav-link"><i class="fa-solid fa-house me-2"></i> Home</a></li>
            <li class="nav-item mb-2"><a href="<?= site_url('libros') ?>" class="nav-link"><i class="fa-solid fa-book-open me-2"></i> Libros</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="fa-solid fa-user-graduate me-2"></i> Students</a></li>
        </ul>
    </div>
    <a href="<?= site_url('logout') ?>" class="nav-link text-danger mt-auto"><i class="fa-solid fa-right-from-bracket me-2"></i> Cerrar Sesión</a>
</div>
