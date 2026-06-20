<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Productos</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Productos</h1>
            <p class="admin-page-subtitle"><?= count($productos) ?> productos en el catálogo.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/productos/crear" class="btn-admin btn-admin-sm">+ Nuevo producto</a>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <?php if (empty($productos)): ?>
    <div class="admin-empty">
        <p>No hay productos cargados todavía.</p>
        <a href="<?= BASE_URL ?>/admin/productos/crear" class="btn-admin">Crear primer producto</a>
    </div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td style="color:#8e8a82"><?= $p['id'] ?></td>
                <td>
                    <?php if (!empty($p['imagen_principal'])): ?>
                    <img src="<?= htmlspecialchars($p['imagen_principal']) ?>" alt="" style="width:36px;height:36px;object-fit:cover;border-radius:4px;margin-right:0.6rem;vertical-align:middle;">
                    <?php endif; ?>
                    <strong><?= htmlspecialchars($p['nombre']) ?></strong>
                    <?php if ($p['destacado']): ?><span class="badge badge--activo" style="margin-left:0.4rem">Destacado</span><?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['categoria_nombre'] ?? '—') ?></td>
                <td>$<?= number_format($p['precio'], 0, ',', '.') ?></td>
                <td>
                    <?php
                    $s = (int)$p['stock'];
                    if ($s === 0)      echo '<span class="stock-dot stock-dot--out">'      . $s . '</span>';
                    elseif ($s <= 3)   echo '<span class="stock-dot stock-dot--critical">' . $s . '</span>';
                    elseif ($s <= 8)   echo '<span class="stock-dot stock-dot--low">'      . $s . '</span>';
                    else               echo '<span class="stock-dot stock-dot--ok">'       . $s . '</span>';
                    ?>
                </td>
                <td><span class="badge badge--<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                <td>
                    <div class="table-actions">
                        <a href="<?= BASE_URL ?>/admin/productos/editar/<?= $p['id'] ?>" class="btn-admin-secondary btn-admin-sm">Editar</a>
                        <button class="btn-admin-danger btn-admin-sm" onclick="confirmarEliminar(<?= $p['id'] ?>, '<?= addslashes($p['nombre']) ?>')">Ocultar</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>
</main>

<div class="modal-overlay" id="modal-eliminar">
    <div class="modal">
        <h3>¿Ocultar producto?</h3>
        <p id="modal-msg">El producto quedará oculto del catálogo.</p>
        <form method="POST" action="<?= BASE_URL ?>/admin/productos/eliminar">
            <input type="hidden" name="id" id="modal-id">
            <div class="modal-actions">
                <button type="button" class="btn-admin-secondary" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-admin-danger">Ocultar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
