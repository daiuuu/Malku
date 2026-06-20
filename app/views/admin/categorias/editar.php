<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/categorias">Categorías</a>
        <span>›</span>
        <span>Editar</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Editar categoría</h1>
            <p class="admin-page-subtitle"><?= htmlspecialchars($categoria['nombre']) ?></p>
        </div>
        <a href="<?= BASE_URL ?>/admin/categorias" class="btn-admin-secondary btn-admin-sm">← Volver</a>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/admin/categorias/actualizar" class="admin-form">

        <input type="hidden" name="id" value="<?= $categoria['id'] ?>">

        <div class="form-field">
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($categoria['nombre']) ?>">
        </div>

        <div class="form-field">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($categoria['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="form-field">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="activa" <?= $categoria['estado'] === 'activa' ? 'selected' : '' ?>>Activa</option>
                <option value="oculta" <?= $categoria['estado'] === 'oculta' ? 'selected' : '' ?>>Oculta</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-admin">Guardar cambios</button>
            <a href="<?= BASE_URL ?>/admin/categorias" class="btn-admin-secondary">Cancelar</a>
        </div>

    </form>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
