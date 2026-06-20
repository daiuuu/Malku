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

                    <?php if (!empty($carrito)): ?>
                    <button
                        type="button"
                        class="btn-outline btn-compartir-carrito"
                        id="btn-compartir"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/></svg>
                        Compartir lista
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

<script src="<?= BASE_URL; ?>/assets/js/global/carrito_flash.js"></script>

<!-- ================= MODAL COMPARTIR ================= -->
<div class="compartir-overlay" id="compartir-overlay" aria-hidden="true">
    <div class="compartir-modal" role="dialog" aria-modal="true" aria-labelledby="compartir-titulo">

        <button class="compartir-cerrar" id="compartir-cerrar" aria-label="Cerrar">&times;</button>

        <span class="compartir-eyebrow">Compartir lista</span>
        <h2 id="compartir-titulo">Mandá tu lista a quien quieras</h2>
        <p>Cualquier persona con este link puede ver tus productos y agregarlos a su carrito.</p>

        <div class="compartir-link-wrap" id="compartir-link-wrap" style="display:none">
            <input
                type="text"
                id="compartir-link-input"
                class="compartir-link-input"
                readonly
                aria-label="Link de tu lista compartida"
            >
            <button type="button" class="compartir-copy-btn" id="compartir-copy-btn" aria-label="Copiar link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg>
                Copiar
            </button>
        </div>

        <div class="compartir-loading" id="compartir-loading">
            <div class="compartir-spinner"></div>
            <span>Generando link…</span>
        </div>

        <div class="compartir-copiado" id="compartir-copiado" aria-live="polite">
            ✓ Link copiado al portapapeles
        </div>

    </div>
</div>

<script>
(function () {
    var btn      = document.getElementById('btn-compartir');
    var overlay  = document.getElementById('compartir-overlay');
    var cerrar   = document.getElementById('compartir-cerrar');
    var loading  = document.getElementById('compartir-loading');
    var linkWrap = document.getElementById('compartir-link-wrap');
    var linkInput= document.getElementById('compartir-link-input');
    var copyBtn  = document.getElementById('compartir-copy-btn');
    var copiado  = document.getElementById('compartir-copiado');
    var linkGenerado = null;

    if (!btn) return;

    function abrirModal() {
        overlay.classList.add('activo');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        if (!linkGenerado) {
            loading.style.display  = 'flex';
            linkWrap.style.display = 'none';
            copiado.style.display  = 'none';

            fetch('<?= BASE_URL ?>/carrito/compartir', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.url) {
                    linkGenerado      = data.url;
                    linkInput.value   = data.url;
                    loading.style.display  = 'none';
                    linkWrap.style.display = 'flex';
                }
            })
            .catch(function () {
                loading.style.display = 'none';
            });
        }
    }

    function cerrarModal() {
        overlay.classList.remove('activo');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    btn.addEventListener('click', abrirModal);
    cerrar.addEventListener('click', cerrarModal);
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) cerrarModal();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarModal();
    });

    copyBtn.addEventListener('click', function () {
        if (!linkGenerado) return;
        navigator.clipboard.writeText(linkGenerado).then(function () {
            copiado.style.display = 'block';
            copyBtn.textContent   = '✓ Copiado';
            setTimeout(function () {
                copiado.style.display = 'none';
                copyBtn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg> Copiar';
            }, 2500);
        }).catch(function () {
            linkInput.select();
            document.execCommand('copy');
            copiado.style.display = 'block';
        });
    });
})();
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>