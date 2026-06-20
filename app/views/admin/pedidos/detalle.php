<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/pedidos">Pedidos</a>
        <span>›</span>
        <span>#<?= str_pad($pedido['id'], 5, '0', STR_PAD_LEFT) ?></span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Pedido #<?= str_pad($pedido['id'], 5, '0', STR_PAD_LEFT) ?></h1>
            <p class="admin-page-subtitle">
                <?= date('d/m/Y \a \l\a\s H:i', strtotime($pedido['fecha_pedido'])) ?> —
                <span class="badge badge--<?= $pedido['estado'] ?>"><?= ucfirst($pedido['estado']) ?></span>
            </p>
        </div>
        <a href="<?= BASE_URL ?>/admin/pedidos" class="btn-admin-secondary btn-admin-sm">← Volver</a>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <div class="admin-grid">

        <!-- DETALLE DEL PEDIDO -->
        <div>
            <div class="admin-card" style="margin-bottom:1.5rem">
                <div class="admin-card__head">
                    <p class="admin-card__title">Productos</p>
                </div>
                <?php if (empty($detalle)): ?>
                <div class="admin-empty"><p>Sin detalle disponible.</p></div>
                <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Precio unit.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($detalle as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre_producto'] ?? $item['producto_id']) ?></td>
                        <td><?= (int)$item['cantidad'] ?></td>
                        <td>$<?= number_format($item['precio_unitario'] ?? 0, 0, ',', '.') ?></td>
                        <td>$<?= number_format(($item['precio_unitario'] ?? 0) * $item['cantidad'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="padding:1rem 1.5rem;border-top:1px solid rgba(0,0,0,.05);text-align:right">
                    <strong>Total: $<?= number_format($pedido['total'] ?? 0, 0, ',', '.') ?></strong>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- SIDEBAR PEDIDO -->
        <div style="display:flex;flex-direction:column;gap:1.5rem">

            <!-- CLIENTE -->
            <div class="admin-card">
                <div class="admin-card__head">
                    <p class="admin-card__title">Cliente</p>
                </div>
                <div style="padding:1.25rem 1.5rem;font-size:0.875rem;line-height:2">
                    <strong><?= htmlspecialchars(($pedido['nombre'] ?? '') . ' ' . ($pedido['apellido'] ?? '')) ?></strong><br>
                    <?= htmlspecialchars($pedido['email'] ?? '—') ?><br>
                    <?= htmlspecialchars($pedido['telefono'] ?? '—') ?>
                </div>
            </div>

            <!-- CAMBIAR ESTADO -->
            <div class="admin-card">
                <div class="admin-card__head">
                    <p class="admin-card__title">Estado del pedido</p>
                </div>
                <div style="padding:1.25rem 1.5rem">
                    <form method="POST" action="<?= BASE_URL ?>/admin/pedidos/cambiar-estado">
                        <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                        <div class="form-field" style="margin-bottom:1rem">
                            <label for="estado">Nuevo estado</label>
                            <select id="estado" name="estado">
                                <?php
                                $estados = ['pendiente','pagado','enviado','entregado','cancelado'];
                                foreach ($estados as $e):
                                ?>
                                <option value="<?= $e ?>" <?= $pedido['estado'] === $e ? 'selected' : '' ?>>
                                    <?= ucfirst($e) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-admin btn-admin-sm" style="width:100%">Actualizar estado</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
