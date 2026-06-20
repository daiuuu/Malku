<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/categorias">Categorías</a>
        <span>›</span>
        <span>Nueva</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Nueva categoría</h1>
            <p class="admin-page-subtitle">Completá los datos para crear una categoría.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/categorias" class="btn-admin-secondary btn-admin-sm">← Volver</a>
    </div>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/categorias/guardar" class="admin-form">

        <div class="form-field">
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Collares">
        </div>

        <div class="form-field">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción breve de la categoría..."></textarea>
        </div>

        <div class="form-field">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="activa">Activa</option>
                <option value="oculta">Oculta</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-admin">Crear categoría</button>
            <a href="<?= BASE_URL ?>/admin/categorias" class="btn-admin-secondary">Cancelar</a>
        </div>

    </form>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
