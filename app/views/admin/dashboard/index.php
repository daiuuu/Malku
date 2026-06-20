<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-dashboard">

    <div class="admin-container">

        <div class="admin-header-section">

            <span class="admin-label">Panel Administrativo</span>

            <h1 class="admin-title">
                Bienvenida, <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?>.
            </h1>

            <p class="admin-subtitle">
                Gestioná tu tienda desde acá. Las secciones del panel<br>
                estarán disponibles próximamente.
            </p>

        </div>

        <div class="admin-notice">

            <p>Panel en construcción — los módulos de productos, pedidos y usuarios están en desarrollo.</p>

        </div>

        <div class="admin-actions">

            <a href="<?= BASE_URL; ?>/logout" class="btn-admin-logout">
                Cerrar sesión
            </a>

            <a href="<?= BASE_URL; ?>/" class="btn-admin-home">
                Ver tienda
            </a>

        </div>

    </div>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
