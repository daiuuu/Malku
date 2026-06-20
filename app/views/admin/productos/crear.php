<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/productos">Productos</a>
        <span>›</span>
        <span>Nuevo producto</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Nuevo producto</h1>
            <p class="admin-page-subtitle">Completá los datos del producto.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/productos" class="btn-admin-secondary btn-admin-sm">← Volver</a>
    </div>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/productos/guardar" enctype="multipart/form-data" class="admin-form">

        <div class="form-row">
            <div class="form-field">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej. Collar de plata">
            </div>
            <div class="form-field">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="0">Sin categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="precio">Precio (ARS) *</label>
                <input type="number" id="precio" name="precio" min="0" step="0.01" required placeholder="0">
            </div>
            <div class="form-field">
                <label for="stock">Stock inicial</label>
                <input type="number" id="stock" name="stock" min="0" value="0">
            </div>
        </div>

        <div class="form-field form-field--full">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" placeholder="Descripción del producto..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="materiales">Materiales</label>
                <input type="text" id="materiales" name="materiales" placeholder="Ej. Plata 925, piedra natural">
            </div>
            <div class="form-field">
                <label for="cuidados">Cuidados</label>
                <input type="text" id="cuidados" name="cuidados" placeholder="Ej. Evitar contacto con agua">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="estado">Estado</label>
                <select id="estado" name="estado">
                    <option value="activo">Activo</option>
                    <option value="oculto">Oculto</option>
                </select>
            </div>
            <div class="form-field" style="justify-content:flex-end;flex-direction:row;align-items:center;gap:0.6rem;padding-bottom:0.2rem">
                <input type="checkbox" id="destacado" name="destacado" value="1">
                <label for="destacado" style="text-transform:none;font-size:0.875rem;margin:0;cursor:pointer">Producto destacado</label>
            </div>
        </div>

        <div class="form-field">
            <label for="imagen">Imagen principal</label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp">
            <span class="form-hint">JPG, PNG o WebP. Recomendado: 800×800px.</span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-admin">Crear producto</button>
            <a href="<?= BASE_URL ?>/admin/productos" class="btn-admin-secondary">Cancelar</a>
        </div>

    </form>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
