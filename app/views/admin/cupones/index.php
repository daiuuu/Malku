<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Cupones</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Cupones de descuento</h1>
            <p class="admin-page-subtitle">Gestión de cupones y promociones.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-empty" style="padding:4rem 2rem">
            <p>
                El módulo de cupones estará disponible próximamente.<br>
                Requiere crear la tabla <code style="background:#f1f0ed;padding:0.1rem 0.4rem;border-radius:3px;font-size:0.82rem">cupones</code> en la base de datos.
            </p>
            <a href="<?= BASE_URL ?>/admin" class="btn-admin-secondary">Volver al dashboard</a>
        </div>
    </div>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
