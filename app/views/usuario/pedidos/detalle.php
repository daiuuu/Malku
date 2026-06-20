<?php
$estados = ['pendiente', 'pagado', 'enviado', 'entregado'];
$estadoLabels = ['Pendiente', 'Pagado', 'Enviado', 'Entregado'];
$estadoIcons  = ['⏳', '✓', '📦', '🎉'];
$estadoActual = $pedido['estado'];
$estadoActualIdx = array_search($estadoActual, $estados);
?>
<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label"><a href="<?= BASE_URL ?>/usuario/pedidos" style="color:inherit">Mis Pedidos</a> / Detalle</span>
        <h1 class="u-page-header__title">Pedido #<?= str_pad($pedido['id'], 5, '0', STR_PAD_LEFT) ?></h1>
    </div>

    <?php if ($estadoActual !== 'cancelado'): ?>
    <!-- TIMELINE -->
    <div class="u-card" style="margin-bottom:20px">
        <div class="u-timeline">
            <?php foreach ($estados as $i => $est): ?>
            <?php
                $done   = $i < $estadoActualIdx;
                $active = $i === $estadoActualIdx;
                $cls    = $done ? 'u-timeline__step--done' : ($active ? 'u-timeline__step--active' : '');
            ?>
            <div class="u-timeline__step <?= $cls ?>">
                <div class="u-timeline__dot"><?= $done ? '✓' : ($active ? $estadoIcons[$i] : '') ?></div>
                <div class="u-timeline__label"><?= $estadoLabels[$i] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="u-flash u-flash--error" style="margin-bottom:20px">Este pedido fue cancelado.</div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

        <!-- Productos -->
        <div class="u-card">
            <div class="u-card__header">
                <h3 class="u-card__title">Artículos</h3>
            </div>
            <?php foreach ($detalle as $item): ?>
            <div class="u-prod-row">
                <div class="u-prod-row__info">
                    <div class="u-prod-row__name"><?= htmlspecialchars($item['nombre_producto']) ?></div>
                    <div class="u-prod-row__qty">Cantidad: <?= (int)$item['cantidad'] ?></div>
                </div>
                <div class="u-prod-row__price">$<?= number_format($item['subtotal'], 0, ',', '.') ?></div>
            </div>
            <?php endforeach; ?>

            <div style="margin-top:16px">
                <div class="u-total-row">
                    <span class="u-total-row__key">Subtotal</span>
                    <span class="u-total-row__val">$<?= number_format($pedido['subtotal'], 0, ',', '.') ?></span>
                </div>
                <?php if ($pedido['descuento'] > 0): ?>
                <div class="u-total-row">
                    <span class="u-total-row__key">Descuento</span>
                    <span class="u-total-row__val" style="color:#2d6a4f">−$<?= number_format($pedido['descuento'], 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
                <div class="u-total-row">
                    <span class="u-total-row__key">Envío</span>
                    <span class="u-total-row__val"><?= $pedido['costo_envio'] > 0 ? '$' . number_format($pedido['costo_envio'], 0, ',', '.') : 'Gratis' ?></span>
                </div>
                <div class="u-total-row u-total-row--final">
                    <span class="u-total-row__key">Total</span>
                    <span class="u-total-row__val">$<?= number_format($pedido['total'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <!-- Info pedido -->
        <div class="u-card">
            <div class="u-card__header">
                <h3 class="u-card__title">Información</h3>
            </div>
            <div class="u-order-row">
                <span class="u-order-row__key">Código</span>
                <span class="u-order-row__val"><?= htmlspecialchars($pedido['codigo']) ?></span>
            </div>
            <div class="u-order-row">
                <span class="u-order-row__key">Fecha</span>
                <span class="u-order-row__val"><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></span>
            </div>
            <div class="u-order-row">
                <span class="u-order-row__key">Método de pago</span>
                <span class="u-order-row__val"><?= ucfirst($pedido['metodo_pago']) ?></span>
            </div>
            <div class="u-order-row">
                <span class="u-order-row__key">Estado</span>
                <span class="u-badge u-badge--<?= $pedido['estado'] ?>"><?= ucfirst($pedido['estado']) ?></span>
            </div>
            <?php if (!empty($pedido['observaciones'])): ?>
            <div style="margin-top:16px">
                <div style="font-size:12px;color:var(--u-muted);text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px">Observaciones</div>
                <p style="font-size:14px;color:var(--u-dark)"><?= htmlspecialchars($pedido['observaciones']) ?></p>
            </div>
            <?php endif; ?>
            <div class="u-btn-row">
                <a href="<?= BASE_URL ?>/usuario/pedidos" class="u-btn u-btn--outline u-btn--sm">← Volver</a>
            </div>
        </div>

    </div>

</div>
</main>
