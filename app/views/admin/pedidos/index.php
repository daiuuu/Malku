<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Pedidos</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Pedidos</h1>
            <p class="admin-page-subtitle"><?= count($pedidos) ?> pedidos en total.</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (empty($pedidos)): ?>
    <div class="admin-empty">
        <p>No hay pedidos todavía.</p>
    </div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><a href="<?= BASE_URL ?>/admin/pedidos/<?= $p['id'] ?>" style="font-weight:500">#<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?></a></td>
                <td><?= htmlspecialchars(($p['nombre'] ?? '') . ' ' . ($p['apellido'] ?? '')) ?></td>
                <td style="font-size:0.8rem;color:#8e8a82"><?= htmlspecialchars($p['email'] ?? '—') ?></td>
                <td>$<?= number_format($p['total'] ?? 0, 0, ',', '.') ?></td>
                <td><span class="badge badge--<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                <td style="font-size:0.8rem;color:#8e8a82"><?= date('d/m/Y', strtotime($p['fecha_pedido'])) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/admin/pedidos/<?= $p['id'] ?>" class="btn-admin-secondary btn-admin-sm">Ver detalle</a>
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
