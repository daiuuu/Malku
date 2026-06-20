<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/productos">Productos</a>
        <span>›</span>
        <span>Editar</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Editar producto</h1>
            <p class="admin-page-subtitle"><?= htmlspecialchars($producto['nombre']) ?></p>
        </div>
        <a href="<?= BASE_URL ?>/admin/productos" class="btn-admin-secondary btn-admin-sm">← Volver</a>
    </div>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/productos/actualizar" enctype="multipart/form-data" class="admin-form">

        <input type="hidden" name="id" value="<?= $producto['id'] ?>">

        <div class="form-row">
            <div class="form-field">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($producto['nombre']) ?>">
            </div>
            <div class="form-field">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="0">Sin categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nombre']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="precio">Precio (ARS) *</label>
                <input type="number" id="precio" name="precio" min="0" step="0.01" required value="<?= $producto['precio'] ?>">
            </div>
            <div class="form-field">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" min="0" value="<?= $producto['stock'] ?>">
            </div>
        </div>

        <div class="form-field form-field--full">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="materiales">Materiales</label>
                <input type="text" id="materiales" name="materiales" value="<?= htmlspecialchars($producto['materiales'] ?? '') ?>">
            </div>
            <div class="form-field">
                <label for="cuidados">Cuidados</label>
                <input type="text" id="cuidados" name="cuidados" value="<?= htmlspecialchars($producto['cuidados'] ?? '') ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <option value="activo"  <?= $producto['estado'] === 'activo'  ? 'selected' : '' ?>>Activo</option>
                    <option value="oculto"  <?= $producto['estado'] === 'oculto'  ? 'selected' : '' ?>>Oculto</option>
                    <option value="agotado" <?= $producto['estado'] === 'agotado' ? 'selected' : '' ?>>Agotado</option>
                </select>
            </div>
            <div class="form-field" style="justify-content:flex-end;flex-direction:row;align-items:center;gap:0.6rem;padding-bottom:0.2rem">
                <input type="checkbox" id="destacado" name="destacado" value="1" <?= $producto['destacado'] ? 'checked' : '' ?>>
                <label for="destacado" style="text-transform:none;font-size:0.875rem;margin:0;cursor:pointer">Producto destacado</label>
            </div>
        </div>

        <div class="form-field">
            <label>Imagen actual</label>
            <?php if (!empty($producto['imagen_principal'])): ?>
            <img src="<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:6px;margin-bottom:0.6rem;display:block">
            <?php else: ?>
            <p class="form-hint">Sin imagen cargada.</p>
            <?php endif; ?>
            <label for="imagen">Reemplazar imagen</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
            <span class="form-hint">Dejá vacío para mantener la imagen actual.</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-admin">Guardar cambios</button>
            <a href="<?= BASE_URL ?>/admin/productos" class="btn-admin-secondary">Cancelar</a>
        </div>

    </form>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
