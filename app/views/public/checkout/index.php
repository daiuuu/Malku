<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="checkout-page">

    <section class="checkout">

        <div class="contenedor">

            <h1>
                Finalizar compra
            </h1>

            <div class="checkout-grid">

                <!-- ================= PRODUCTOS ================= -->

                <div class="checkout-productos">

                    <?php foreach($productos as $producto): ?>

                        <article class="checkout-item">

                            <h3>
                                <?= $producto['nombre']; ?>
                            </h3>

                            <p>
                                Cantidad:
                                <?= $producto['cantidad']; ?>
                            </p>

                            <p>
                                $<?= number_format(
                                    $producto['precio'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </p>

                        </article>

                    <?php endforeach; ?>

                </div>

                <!-- ================= RESUMEN ================= -->

                <aside class="checkout-resumen">

                    <h2>
                        Resumen
                    </h2>

                    <p>
                        Total:
                        <strong>
                            $<?= number_format(
                                $total,
                                0,
                                ',',
                                '.'
                            ); ?>
                        </strong>
                    </p>

                    <form
                        action="<?= BASE_URL; ?>/checkout/procesar"
                        method="POST"
                    >

                        <button type="submit">
                            Confirmar compra
                        </button>

                    </form>

                </aside>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>