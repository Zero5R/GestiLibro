<?php

// Simple single-file mockup of a library user interface (no DB)
// Save as gestorbiblioteca_usuario.php and run with: php -S localhost:8000

$users = [
    'user@example.com' => [
        'password' => 'password',
        'name' => 'Juan Lector'
    ]
];

// Initialize sample books (stored in session so state persists during the session)
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [
        1 => ['title'=>'Cien años de soledad','author'=>'Gabriel García Márquez','year'=>1967,'available'=>true],
        2 => ['title'=>'El Principito','author'=>'Antoine de Saint-Exupéry','year'=>1943,'available'=>true],
        3 => ['title'=>'1984','author'=>'George Orwell','year'=>1949,'available'=>true],
        4 => ['title'=>'Introducción a PHP','author'=>'María Dev','year'=>2020,'available'=>true],
        5 => ['title'=>'Algoritmos y Estructuras','author'=>'J. Algo','year'=>2018,'available'=>true]
    ];
}

if (!isset($_SESSION['loans'])) {
    $_SESSION['loans'] = [];
}

// Simple router
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    if (isset($users[$email]) && $users[$email]['password'] === $pass) {
        // login success
        $_SESSION['user'] = ['email'=>$email, 'name'=>$users[$email]['name']];
        header('Location: ?page=dashboard');
        exit;
    } else {
        $error = 'Credenciales incorrectas';
        $page = 'login';
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ?page=login');
    exit;
}

// Require login for pages other than login
if ($page !== 'login' && !isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}

// Handle loan request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'request_loan') {
    $bookId = (int)$_POST['book_id'];
    // check availability
    if (isset($_SESSION['books'][$bookId]) && $_SESSION['books'][$bookId]['available']) {
        // mark unavailable and add loan
        $_SESSION['books'][$bookId]['available'] = false;
        $loanId = uniqid();
        $_SESSION['loans'][$loanId] = [
            'id' => $loanId,
            'book_id' => $bookId,
            'title' => $_SESSION['books'][$bookId]['title'],
            'date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+14 days')),
            'status' => 'En curso'
        ];
        $message = 'Préstamo solicitado correctamente.';
    } else {
        $message = 'El libro no está disponible.';
    }
    $page = 'books';
}

// Handle return (simple)
if (isset($_GET['action']) && $_GET['action'] === 'return' && isset($_GET['loan'])) {
    $loan = $_GET['loan'];
    if (isset($_SESSION['loans'][$loan])) {
        $bookId = $_SESSION['loans'][$loan]['book_id'];
        // mark available and update loan
        $_SESSION['books'][$bookId]['available'] = true;
        $_SESSION['loans'][$loan]['status'] = 'Devuelto';
        $_SESSION['loans'][$loan]['returned_date'] = date('Y-m-d');
    }
    header('Location: ?page=my_loans');
    exit;
}

// Small helper to render header
function render_header() {
    $name = htmlspecialchars($_SESSION['user']['name']);
    echo "<header class='top'><div class='container'><h1>GestorBiblio</h1><nav>Bienvenido, $name | <a href='?action=logout'>Salir</a></nav></div></header>";
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>GestorBiblio - Usuario</title>
    <style>
        :root{--accent:#7c4dff;--muted:#f5f5f7;--card:#fff}
        body{font-family:Inter,Segoe UI,Arial;margin:0;background:#f0f0f2;color:#222}
        .container{max-width:1100px;margin:0 auto;padding:18px}
        .top{background:linear-gradient(90deg,#fff,#fff);box-shadow:0 1px 0 rgba(0,0,0,0.06)}
        .top .container{display:flex;justify-content:space-between;align-items:center}
        h1{margin:0;font-size:18px;color:#333}
        nav a{color:var(--accent);text-decoration:none;margin-left:8px}
        .grid{display:grid;grid-template-columns:250px 1fr;gap:18px;padding:18px}
        .sidebar{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(15,15,15,0.04)}
        .card{background:var(--card);padding:18px;border-radius:12px;box-shadow:0 6px 18px rgba(15,15,15,0.04)}
        .menu a{display:block;padding:8px 0;color:#555;text-decoration:none}
        .stats{display:flex;gap:12px}
        .stat{flex:1;padding:14px;border-radius:10px;background:linear-gradient(90deg,#fff,#fbfbff);text-align:center}
        table{width:100%;border-collapse:collapse}
        th,td{padding:8px;border-bottom:1px solid #eee;text-align:left}
        .btn{display:inline-block;padding:8px 12px;border-radius:8px;background:var(--accent);color:#fff;text-decoration:none}
        .btn[disabled]{opacity:0.5;pointer-events:none}
        .small{font-size:13px;color:#666}
        .message{padding:10px;background:#e6fff5;border:1px solid #bfe6d0;color:#064;border-radius:8px;margin-bottom:12px}
        .centered{display:flex;align-items:center;justify-content:center;height:70vh}
        .login-card{width:360px;background:var(--card);padding:30px;border-radius:12px;box-shadow:0 12px 30px rgba(0,0,0,0.08)}
        input[type='text'],input[type='password']{width:100%;padding:9px;border-radius:8px;border:1px solid #e6e6ea;margin-bottom:10px}
    </style>
</head>
<body>

<?php if ($page === 'login'): ?>
    <div class="centered">
        <div class="login-card">
            <h2 style="margin-top:0">Iniciar sesión</h2>
            <?php if (isset($error)): ?><div class="message" style="background:#ffeaea;color:#700;border-color:#f1b0b0"><?php echo $error ?></div><?php endif; ?>
            <form method="post">
                <input type="hidden" name="action" value="login">
                <label>Email</label>
                <input type="text" name="email" placeholder="user@example.com" required>
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="password" required>
                <button class="btn" type="submit">Entrar</button>
            </form>
            <p class="small">Usuario demo: <strong>user@example.com</strong> / password</p>
        </div>
    </div>
<?php else: ?>
    <?php render_header(); ?>
    <div class="grid container">
        <aside class="sidebar">
            <h3>Menú</h3>
            <div class="menu">
                <a href="?page=dashboard">Inicio</a>
                <a href="?page=books">Libros</a>
                <a href="?page=my_loans">Mis préstamos</a>
                <a href="?page=history">Historial</a>
                <a href="?page=profile">Perfil</a>
            </div>
        </aside>
        <main>
            <?php if (isset($message)): ?><div class="message"><?php echo htmlspecialchars($message) ?></div><?php endif; ?>

            <?php if ($page === 'dashboard'): ?>
                <div class="card">
                    <h2>Dashboard</h2>
                    <div class="stats" style="margin-top:12px">
                        <div class="stat">
                            <div class="small">Libros disponibles</div>
                            <div style="font-size:20px;font-weight:700"><?php
                                $available = 0; foreach($_SESSION['books'] as $b) if($b['available']) $available++;
                                echo $available;
                            ?></div>
                        </div>
                        <div class="stat">
                            <div class="small">Préstamos activos</div>
                            <div style="font-size:20px;font-weight:700"><?php
                                $active = 0; foreach($_SESSION['loans'] as $l) if($l['status']==='En curso') $active++;
                                echo $active;
                            ?></div>
                        </div>
                        <div class="stat">
                            <div class="small">Historial total</div>
                            <div style="font-size:20px;font-weight:700"><?php echo count($_SESSION['loans']); ?></div>
                        </div>
                    </div>
                </div>

            <?php elseif ($page === 'books'): ?>
                <div class="card">
                    <h2>Explorar libros</h2>
                    <form method="get" style="margin-bottom:12px">
                        <input type="hidden" name="page" value="books">
                        <input type="text" name="q" placeholder="Buscar por título o autor" style="width:60%;padding:8px;border-radius:8px;border:1px solid #eee">
                        <button class="btn" style="margin-left:6px">Buscar</button>
                    </form>
                    <?php
                        $q = trim($_GET['q'] ?? '');
                        echo "<table><thead><tr><th>Título</th><th>Autor</th><th>Año</th><th>Disponibilidad</th><th></th></tr></thead><tbody>";
                        foreach($_SESSION['books'] as $id => $book) {
                            if ($q !== '' && stripos($book['title'] . ' ' . $book['author'], $q) === false) continue;
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($book['title']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['author']) . "</td>";
                            echo "<td>" . htmlspecialchars($book['year']) . "</td>";
                            echo "<td>" . ($book['available'] ? '<span class="small">Disponible</span>' : '<span class="small">No disponible</span>') . "</td>";
                            echo "<td>";
                            // if ($book['available']) {
                            //     //echo "<form method="post" style="display:inline">n";
                            //     echo "<input type="hidden" name="action" value="request_loan">n";
                            //     echo "<input type="hidden" name="book_id" value="". (int)$id ."">n";
                            //     echo "<button class="btn" type="submit">Solicitar préstamo</button>n";
                            //     echo "</form>";
                            // } else {
                            //     echo "<button class="btn" disabled>Solicitar préstamo</button>";
                            // }
                            echo "</td></tr>";
                        }
                        echo "</tbody></table>";
                    ?>
                </div>

            <?php elseif ($page === 'my_loans'): ?>
                <div class="card">
                    <h2>Mis préstamos</h2>
                    <?php if (empty($_SESSION['loans'])): ?>
                        <p class="small">No tienes préstamos activos.</p>
                    <?php else: ?>
                        <table>
                            <thead><tr><th>Título</th><th>Fecha</th><th>Vence</th><th>Estado</th><th>Acción</th></tr></thead>
                            <tbody>
                                <?php foreach($_SESSION['loans'] as $loan): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($loan['title']) ?></td>
                                        <td><?php echo htmlspecialchars($loan['date']) ?></td>
                                        <td><?php echo htmlspecialchars($loan['due_date']) ?></td>
                                        <td><?php echo htmlspecialchars($loan['status']) ?></td>
                                        <td>
                                            <?php if ($loan['status'] === 'En curso'): ?>
                                                <a class="btn" href="?action=return&loan=<?php echo urlencode($loan['id']) ?>">Devolver</a>
                                            <?php else: ?>
                                                <span class="small">--</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>

            <?php elseif ($page === 'history'): ?>
                <div class="card">
                    <h2>Historial</h2>
                    <p class="small">Listar todos los préstamos (incluidos devueltos).</p>
                    <table>
                        <thead><tr><th>Título</th><th>Inicio</th><th>Fin</th><th>Estado</th></tr></thead>
                        <tbody>
                            <?php foreach($_SESSION['loans'] as $loan): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($loan['title']) ?></td>
                                    <td><?php echo htmlspecialchars($loan['date']) ?></td>
                                    <td><?php echo htmlspecialchars($loan['returned_date'] ?? '-') ?></td>
                                    <td><?php echo htmlspecialchars($loan['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($page === 'profile'): ?>
                <div class="card">
                    <h2>Perfil</h2>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['user']['name']) ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']) ?></p>
                    <p class="small">(Funcionalidad de editar perfil no implementada en este mockup)</p>
                </div>

            <?php else: ?>
                <div class="card"><p>Página no encontrada.</p></div>
            <?php endif; ?>
        </main>
    </div>
<?php endif; ?>

</body>
</html>
