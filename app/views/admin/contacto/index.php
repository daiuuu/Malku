<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Mensajes</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Mensajes de contacto</h1>
            <p class="admin-page-subtitle"><?= count($mensajes) ?> mensajes recibidos.</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (empty($mensajes)): ?>
    <div class="admin-empty"><p>No hay mensajes todavía.</p></div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($mensajes as $m): ?>
            <tr>
                <td><strong><?= htmlspecialchars($m['nombre'] ?? '—') ?></strong></td>
                <td style="font-size:0.8rem"><?= htmlspecialchars($m['email'] ?? '—') ?></td>
                <td><?= htmlspecialchars($m['asunto'] ?? '—') ?></td>
                <td style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:0.82rem;color:#8e8a82">
                    <?= htmlspecialchars($m['mensaje'] ?? '') ?>
                </td>
                <td><span class="badge badge--<?= $m['estado'] ?? 'pendiente' ?>"><?= ucfirst($m['estado'] ?? 'pendiente') ?></span></td>
                <td style="font-size:0.8rem;color:#8e8a82">
                    <?= isset($m['fecha_creacion']) ? date('d/m/Y', strtotime($m['fecha_creacion'])) : '—' ?>
                </td>
                <td>
                    <form method="POST" action="<?= BASE_URL ?>/admin/contacto/cambiar-estado">
                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                        <div style="display:flex;gap:0.4rem;align-items:center">
                            <select name="estado" style="font-size:0.75rem;padding:0.3rem 0.5rem;border:1px solid rgba(0,0,0,.12);border-radius:4px;font-family:inherit">
                                <option value="pendiente"   <?= ($m['estado'] ?? '') === 'pendiente'   ? 'selected' : '' ?>>Pendiente</option>
                                <option value="leido"       <?= ($m['estado'] ?? '') === 'leido'       ? 'selected' : '' ?>>Leído</option>
                                <option value="respondido"  <?= ($m['estado'] ?? '') === 'respondido'  ? 'selected' : '' ?>>Respondido</option>
                            </select>
                            <button type="submit" class="btn-admin-secondary btn-admin-sm">OK</button>
                        </div>
                    </form>
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
