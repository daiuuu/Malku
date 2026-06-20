<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="checkout-page">
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Compra</span>
        <h1 class="u-page-header__title">Finalizar compra</h1>
    </div>

    <div class="checkout-grid">

        <!-- ================= PRODUCTOS ================= -->
        <div class="checkout-productos">
            <?php foreach ($productos as $producto): ?>
            <article class="checkout-item">

                <img
                    class="checkout-item__img"
                    src="<?= BASE_URL ?>/assets/img/productos/<?= htmlspecialchars($producto['imagen'] ?? '') ?>"
                    alt="<?= htmlspecialchars($producto['nombre']) ?>"
                >

                <div class="checkout-item__info">
                    <h3 class="checkout-item__nombre"><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <p class="checkout-item__meta">
                        <?php if (!empty($producto['color'])): ?>
                        <span><?= htmlspecialchars($producto['color']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($producto['talle'])): ?>
                        <span>Talle <?= htmlspecialchars($producto['talle']) ?></span>
                        <?php endif; ?>
                    </p>
                    <p class="checkout-item__qty">Cantidad: <?= (int)$producto['cantidad'] ?></p>
                </div>

                <p class="checkout-item__precio">
                    $<?= number_format($producto['precio'] * $producto['cantidad'], 0, ',', '.') ?>
                </p>

            </article>
            <?php endforeach; ?>
        </div>

        <!-- ================= RESUMEN ================= -->
        <aside class="checkout-resumen">

            <h2 class="checkout-resumen__title">Resumen del pedido</h2>

            <!-- Subtotal -->
            <div class="checkout-row">
                <span>Subtotal</span>
                <span>$<?= number_format($subtotal, 0, ',', '.') ?></span>
            </div>

            <!-- Descuento -->
            <?php if ($cuponAplicado && $descuento > 0): ?>
            <div class="checkout-row checkout-row--descuento">
                <span>Cupón (<?= htmlspecialchars($cuponAplicado['codigo']) ?>)</span>
                <span>− $<?= number_format($descuento, 0, ',', '.') ?></span>
            </div>
            <?php endif; ?>

            <!-- Total -->
            <div class="checkout-row checkout-row--total">
                <span>Total</span>
                <span>$<?= number_format($total, 0, ',', '.') ?></span>
            </div>

            <!-- Cupón aplicado -->
            <?php if ($cuponAplicado): ?>
            <div class="checkout-cupon-badge">
                <span>Cupón <strong><?= htmlspecialchars($cuponAplicado['codigo']) ?></strong> aplicado</span>
                <a href="<?= BASE_URL ?>/checkout/quitar-cupon">Quitar</a>
            </div>
            <?php else: ?>

            <!-- Error de cupón -->
            <?php if ($cuponError): ?>
            <div class="checkout-cupon-error"><?= htmlspecialchars($cuponError) ?></div>
            <?php endif; ?>

            <!-- Ingresar cupón -->
            <form class="checkout-cupon-form" method="POST" action="<?= BASE_URL ?>/checkout/aplicar-cupon">
                <input type="text" name="codigo" placeholder="Código de cupón o gift card">
                <button type="submit">Aplicar</button>
            </form>

            <?php endif; ?>

            <!-- Confirmar -->
            <form action="<?= BASE_URL ?>/checkout/procesar" method="POST">
                <button type="submit" class="checkout-btn-confirmar">Confirmar compra</button>
            </form>

            <p class="checkout-seguro">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Pago seguro y encriptado
            </p>

        </aside>

    </div><!-- /.checkout-grid -->

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
