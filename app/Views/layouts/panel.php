<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/estilos.css') ?>" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <nav class="col-md-2 bg-light sidebar py-4">
                <h4 class="text-center">Menú</h4>

                <h5 class="mt-4 px-3">Gestión Bibliotecaria</h5>
                <ul class="nav flex-column px-3">
                    <?php if (tienePermiso('ver', 'libros')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('libros') ?>">📚 Libros</a>
                        </li>
                    <?php endif; ?>

                    <?php if (tienePermiso('ver', 'usuarios')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('usuarios-biblioteca') ?>">👤 Usuarios</a>
                        </li>
                    <?php endif; ?>

                    <?php if (tienePermiso('ver', 'prestamos') || tienePermiso('ver_historial', 'prestamos')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('prestamos') ?>">📄 Préstamos de Libros</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <h5 class="mt-4 px-3">Cuenta</h5>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('login/salir') ?>">🔒 Cerrar sesión</a>
                    </li>
                </ul>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 py-4">
                <h2>Bienvenido, <?= esc(session()->get('nombre_usuario')) ?></h2>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
</body>
</html>
