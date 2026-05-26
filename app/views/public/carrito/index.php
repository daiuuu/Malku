<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="carrito-page">

    <section class="carrito-section">

        <div class="contenedor carrito-grid">

            <!-- ================= PRODUCTOS ================= -->
            <div class="carrito-productos">

                <!-- ================= TÍTULO ================= -->
                <div class="carrito-titulo">

                    <h1>
                        Tu Pedido
                    </h1>

                    <span>
                        (<?= $cantidadItems; ?> artículos)
                    </span>

                </div>

                <!-- ================= MENSAJES ================= -->
                <?php if(isset($_SESSION['carrito_exito'])): ?>

                    <div class="mensaje-exito">

                        <?= $_SESSION['carrito_exito']; ?>

                    </div>

                    <?php unset($_SESSION['carrito_exito']); ?>

                <?php endif; ?>

                <?php if(isset($_SESSION['carrito_error'])): ?>

                    <div class="mensaje-error">

                        <?= $_SESSION['carrito_error']; ?>

                    </div>

                    <?php unset($_SESSION['carrito_error']); ?>

                <?php endif; ?>

                <!-- ================= PRODUCTOS ================= -->
                <?php if(!empty($carrito)): ?>

                    <?php foreach($carrito as $item): ?>

                        <article class="carrito-item">

                            <!-- ================= IMAGEN ================= -->
                            <div class="carrito-imagen">

                                <img
                                    src="<?= BASE_URL; ?>/assets/img/productos/<?= $item['imagen']; ?>"
                                    alt="<?= $item['nombre']; ?>"
                                >

                            </div>

                            <!-- ================= INFO ================= -->
                            <div class="carrito-info">

                                <div class="carrito-top">

                                    <div>

                                        <h2>
                                            <?= $item['nombre']; ?>
                                        </h2>

                                        <p>
                                            Color:
                                            <?= $item['color']; ?>
                                        </p>

                                        <p>
                                            Talla:
                                            <?= $item['talle']; ?>
                                        </p>

                                    </div>

                                    <span class="carrito-precio">

                                        $<?= number_format(
                                            $item['precio'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>

                                    </span>

                                </div>

                                <!-- ================= CANTIDAD ================= -->
                                <div class="carrito-cantidad">

                                    <!-- RESTAR -->
                                    <form
                                        action="<?= BASE_URL; ?>/carrito/actualizar"
                                        method="POST"
                                    >

                                        <input
                                            type="hidden"
                                            name="producto_id"
                                            value="<?= $item['id']; ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="cantidad"
                                            value="<?= $item['cantidad'] - 1; ?>"
                                        >

                                        <button type="submit">
                                            −
                                        </button>

                                    </form>

                                    <span>
                                        <?= $item['cantidad']; ?>
                                    </span>

                                    <!-- SUMAR -->
                                    <form
                                        action="<?= BASE_URL; ?>/carrito/actualizar"
                                        method="POST"
                                    >

                                        <input
                                            type="hidden"
                                            name="producto_id"
                                            value="<?= $item['id']; ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="cantidad"
                                            value="<?= $item['cantidad'] + 1; ?>"
                                        >

                                        <button type="submit">
                                            +
                                        </button>

                                    </form>

                                    <!-- ELIMINAR -->
                                    <a
                                        href="<?= BASE_URL; ?>/carrito/eliminar?id=<?= $item['id']; ?>"
                                    >
                                        Eliminar
                                    </a>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="carrito-vacio">

                        <h2>
                            Tu carrito está vacío
                        </h2>

                        <a
                            href="<?= BASE_URL; ?>/coleccion"
                            class="btn-outline"
                        >
                            Explorar colección
                        </a>

                    </div>

                <?php endif; ?>

            </div>

            <!-- ================= RESUMEN ================= -->
            <aside class="resumen-compra">

                <h3>
                    Resumen de pedido
                </h3>

                <!-- SUBTOTAL -->
                <div class="resumen-linea">

                    <span>
                        Subtotal
                    </span>

                    <p>

                        $<?= number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ); ?>

                    </p>

                </div>

                <!-- ENVÍO -->
                <div class="resumen-linea">

                    <span>
                        Envío
                    </span>

                    <small>
                        Calculado en el siguiente paso
                    </small>

                </div>

                <!-- TOTAL -->
                <div class="resumen-total">

                    <span>
                        Total
                    </span>

                    <p>

                        $<?= number_format(
                            $total,
                            0,
                            ',',
                            '.'
                        ); ?>

                    </p>

                </div>

                <!-- BOTONES -->
                <div class="resumen-botones">

                    <?php if(isset($_SESSION['usuario'])): ?>

                    <a
                        href="<?= BASE_URL; ?>/checkout"
                        class="btn-checkout"
                    >
                        Finalizar compra →
                    </a>

                <?php else: ?>

                    <button
                        type="button"
                        class="btn-checkout"
                        id="abrir-login-modal"
                    >
                        Finalizar compra →
                    </button>

                <?php endif; ?>

                    <a
                        href="<?= BASE_URL; ?>/coleccion"
                        class="btn-outline"
                    >
                        Continuar comprando
                    </a>

                </div>

                <!-- BENEFICIOS -->
                <div class="resumen-beneficios">

                    <div class="beneficio">

                        <span>
                            ✦
                        </span>

                        <div>

                            <h4>
                                Envíos globales
                            </h4>

                            <p>
                                Artesanía de los Andes a tu puerta
                                en 5–8 días hábiles.
                            </p>

                        </div>

                    </div>

                    <div class="beneficio">

                        <span>
                            ⌂
                        </span>

                        <div>

                            <h4>
                                Pago seguro
                            </h4>

                            <p>
                                Encriptación de nivel bancario
                                para proteger tus datos.
                            </p>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </section>

</main>

<?php if(!isset($_SESSION['usuario'])): ?>

    <!-- ================= MODAL LOGIN ================= -->
    <div class="modal-auth-overlay" id="modal-auth">

        <div class="modal-auth">

            <button
                class="cerrar-modal-auth"
                id="cerrar-modal-auth"
            >
                ×
            </button>

            <span class="modal-auth-subtitulo">
                EXPERIENCIA MALKU
            </span>

            <h2>
                Descubrí una experiencia personalizada
            </h2>

            <p>
                Iniciá sesión para acceder a tus pedidos,
                beneficios exclusivos y una experiencia
                de compra inspirada en el universo Malku.
            </p>

            <div class="modal-auth-botones">

                <a
                    href="<?= BASE_URL; ?>/login"
                    class="btn-auth-login"
                >
                    Iniciar sesión
                </a>

                <span>
                    o
                </span>

                <a
                    href="<?= BASE_URL; ?>/registro"
                    class="btn-auth-register"
                >
                    Crear cuenta
                </a>

            </div>

        </div>

    </div>

<?php endif; ?>

<script src="<?= BASE_URL; ?>/assets/js/global/carrito_auth_modal.js"></script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>