<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Categorías</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Categorías</h1>
            <p class="admin-page-subtitle"><?= count($categorias) ?> categorías registradas.</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/categorias/crear" class="btn-admin btn-admin-sm">+ Nueva categoría</a>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (!empty($_SESSION['admin_error'])): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($_SESSION['admin_error']) ?></div>
    <?php unset($_SESSION['admin_error']); endif; ?>

    <?php if (empty($categorias)): ?>
    <div class="admin-empty">
        <p>No hay categorías creadas todavía.</p>
        <a href="<?= BASE_URL ?>/admin/categorias/crear" class="btn-admin">Crear primera categoría</a>
    </div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Productos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($categorias as $c): ?>
            <tr>
                <td style="color:#8e8a82"><?= $c['id'] ?></td>
                <td><strong><?= htmlspecialchars($c['nombre']) ?></strong></td>
                <td style="color:#8e8a82;font-size:0.8rem"><?= htmlspecialchars($c['slug']) ?></td>
                <td><?= (int)($c['total_productos'] ?? 0) ?></td>
                <td><span class="badge badge--<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
                <td>
                    <div class="table-actions">
                        <a href="<?= BASE_URL ?>/admin/categorias/editar/<?= $c['id'] ?>" class="btn-admin-secondary btn-admin-sm">Editar</a>
                        <button class="btn-admin-danger btn-admin-sm" onclick="confirmarEliminar(<?= $c['id'] ?>, '<?= addslashes($c['nombre']) ?>')">Ocultar</button>
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
        <h3>¿Ocultar categoría?</h3>
        <p id="modal-msg"></p>
        <form method="POST" action="<?= BASE_URL ?>/admin/categorias/eliminar" id="form-eliminar">
            <input type="hidden" name="id" id="modal-id">
            <div class="modal-actions">
                <button type="button" class="btn-admin-secondary" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-admin-danger">Ocultar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
