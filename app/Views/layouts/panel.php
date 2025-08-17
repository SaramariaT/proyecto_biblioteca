<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <nav class="col-md-2 bg-light sidebar py-4">
                <h4 class="text-center">Menú</h4>
                <ul class="nav flex-column px-3">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('libros') ?>">📚 Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('usuarios') ?>">👤 Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="<?= base_url('login/salir') ?>">🔒 Cerrar sesión</a></li>
                </ul>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 py-4">
                <h2>Bienvenido <?= session('usuario') ?></h2>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
</body>
</html>
