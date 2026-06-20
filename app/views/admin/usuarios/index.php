<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Usuarios</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Usuarios</h1>
            <p class="admin-page-subtitle"><?= count($usuarios) ?> usuarios registrados.</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (empty($usuarios)): ?>
    <div class="admin-empty"><p>No hay usuarios registrados.</p></div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td style="color:#8e8a82"><?= $u['id'] ?></td>
                <td><strong><?= htmlspecialchars(($u['nombre'] ?? '') . ' ' . ($u['apellido'] ?? '')) ?></strong></td>
                <td style="font-size:0.8rem"><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <span class="badge <?= $u['rol'] === 'admin' ? 'badge--activo' : 'badge--pendiente' ?>">
                        <?= ucfirst($u['rol']) ?>
                    </span>
                </td>
                <td>
                    <span class="badge badge--<?= $u['estado'] ?? 'activo' ?>">
                        <?= ucfirst($u['estado'] ?? 'activo') ?>
                    </span>
                </td>
                <td style="font-size:0.8rem;color:#8e8a82">
                    <?= isset($u['fecha_registro']) ? date('d/m/Y', strtotime($u['fecha_registro'])) : '—' ?>
                </td>
                <td>
                    <?php if ($u['id'] != $_SESSION['usuario']['id']): ?>
                    <div class="table-actions">

                        <form method="POST" action="<?= BASE_URL ?>/admin/usuarios/cambiar-rol" style="display:inline">
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="rol" value="<?= $u['rol'] === 'admin' ? 'cliente' : 'admin' ?>">
                            <button type="submit" class="btn-admin-secondary btn-admin-sm">
                                <?= $u['rol'] === 'admin' ? 'Quitar admin' : 'Hacer admin' ?>
                            </button>
                        </form>

                        <form method="POST" action="<?= BASE_URL ?>/admin/usuarios/cambiar-estado" style="display:inline">
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="estado" value="<?= ($u['estado'] ?? 'activo') === 'activo' ? 'bloqueado' : 'activo' ?>">
                            <button type="submit" class="btn-admin-danger btn-admin-sm">
                                <?= ($u['estado'] ?? 'activo') === 'activo' ? 'Bloquear' : 'Activar' ?>
                            </button>
                        </form>

                    </div>
                    <?php else: ?>
                    <span style="font-size:0.75rem;color:#8e8a82">Tú</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
