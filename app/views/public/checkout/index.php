<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="checkout-page">

    <section class="checkout">

        <div class="contenedor">

            <h1>Finalizar compra</h1>

            <div class="checkout-grid">

                <!-- ================= PRODUCTOS ================= -->
                <div class="checkout-productos">
                    <?php foreach ($productos as $producto): ?>
                    <article class="checkout-item">
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                        <p>Cantidad: <?= $producto['cantidad'] ?></p>
                        <p>$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- ================= RESUMEN ================= -->
                <aside class="checkout-resumen">

                    <h2>Resumen</h2>

                    <?php if ($subtotal !== $total): ?>
                    <p style="display:flex;justify-content:space-between;margin-bottom:4px">
                        <span>Subtotal</span>
                        <span>$<?= number_format($subtotal, 0, ',', '.') ?></span>
                    </p>
                    <p style="display:flex;justify-content:space-between;margin-bottom:4px;color:#27ae60">
                        <span>Descuento (<?= htmlspecialchars($cuponAplicado['codigo']) ?>)</span>
                        <span>− $<?= number_format($descuento, 0, ',', '.') ?></span>
                    </p>
                    <hr style="border:none;border-top:1px solid #e8e6e0;margin:10px 0">
                    <?php endif; ?>

                    <p style="display:flex;justify-content:space-between">
                        <span>Total</span>
                        <strong>$<?= number_format($total, 0, ',', '.') ?></strong>
                    </p>

                    <!-- Cupón aplicado -->
                    <?php if ($cuponAplicado): ?>
                    <div style="margin:14px 0;padding:10px 14px;background:#f0faf4;border:1px solid #b7dfc8;border-radius:8px;font-size:0.83rem;display:flex;justify-content:space-between;align-items:center">
                        <span>Cupón <strong><?= htmlspecialchars($cuponAplicado['codigo']) ?></strong> aplicado</span>
                        <a href="<?= BASE_URL ?>/checkout/quitar-cupon" style="color:#c0392b;font-size:0.78rem;text-decoration:none">Quitar</a>
                    </div>
                    <?php else: ?>

                    <!-- Ingresar cupón -->
                    <?php if ($cuponError): ?>
                    <div style="margin-bottom:8px;padding:8px 12px;background:#fff0f0;border:1px solid #f5c0c0;border-radius:6px;font-size:0.82rem;color:#c0392b">
                        <?= htmlspecialchars($cuponError) ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= BASE_URL ?>/checkout/aplicar-cupon"
                          style="display:flex;gap:8px;margin:14px 0">
                        <input
                            type="text"
                            name="codigo"
                            placeholder="Código de cupón"
                            style="flex:1;padding:8px 12px;border:1px solid #ddd;border-radius:6px;font-size:0.85rem;text-transform:uppercase"
                        >
                        <button type="submit"
                                style="padding:8px 16px;background:#1e1e1c;color:#fff;border:none;border-radius:6px;font-size:0.82rem;cursor:pointer;white-space:nowrap">
                            Aplicar
                        </button>
                    </form>

                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/checkout/procesar" method="POST">
                        <button type="submit">Confirmar compra</button>
                    </form>

                </aside>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
