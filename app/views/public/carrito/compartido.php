<main id="carrito-page">
<section class="carrito-section">
<div class="contenedor">

    <!-- ================= CABECERA ================= -->
    <div class="compartido-header">

        <div class="compartido-meta">
            <span class="compartido-label">Lista compartida</span>
            <?php if ($propietario): ?>
            <h1>Lista de <em><?= htmlspecialchars($propietario) ?></em></h1>
            <?php else: ?>
            <h1>Lista de deseos</h1>
            <?php endif; ?>
            <p class="compartido-sub">
                <?= count($items) ?> <?= count($items) === 1 ? 'artículo' : 'artículos' ?> ·
                Total <strong>$<?= number_format($total, 0, ',', '.') ?></strong>
            </p>
        </div>

        <div class="compartido-acciones-top">
            <button type="button" id="seleccionar-todos" class="compartido-sel-btn">
                Seleccionar todos
            </button>
        </div>

    </div>

    <!-- ================= GRID ================= -->
    <div class="compartido-grid">

        <!-- ITEMS -->
        <form
            method="POST"
            action="<?= BASE_URL ?>/carrito/compartido/<?= htmlspecialchars($lista['codigo']) ?>/agregar"
            id="form-compartido"
        >

            <div class="carrito-productos">

                <?php foreach ($items as $item): ?>

                <label class="compartido-item-label">

                    <article class="carrito-item compartido-item">

                        <!-- CHECKBOX -->
                        <div class="compartido-check">
                            <input
                                type="checkbox"
                                name="items[]"
                                value="<?= (int)$item['id'] ?>"
                                class="compartido-checkbox"
                                checked
                            >
                        </div>

                        <!-- IMAGEN -->
                        <div class="carrito-imagen">
                            <img
                                src="<?= BASE_URL ?>/assets/img/productos/<?= htmlspecialchars($item['imagen']) ?>"
                                alt="<?= htmlspecialchars($item['nombre']) ?>"
                            >
                        </div>

                        <!-- INFO -->
                        <div class="carrito-info">

                            <div class="carrito-top">

                                <div>
                                    <h2><?= htmlspecialchars($item['nombre']) ?></h2>
                                    <?php if (!empty($item['color'])): ?>
                                    <p>Color: <?= htmlspecialchars($item['color']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($item['talle'])): ?>
                                    <p>Talla: <?= htmlspecialchars($item['talle']) ?></p>
                                    <?php endif; ?>
                                    <p class="compartido-qty">
                                        Cantidad: <?= (int)$item['cantidad'] ?>
                                    </p>
                                </div>

                                <span class="carrito-precio">
                                    $<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?>
                                </span>

                            </div>

                        </div>

                    </article>

                </label>

                <?php endforeach; ?>

            </div>

            <!-- ================= RESUMEN ================= -->
            <div class="compartido-resumen">

                <div class="resumen-compra">

                    <h3>Tu selección</h3>

                    <div class="resumen-linea compartido-sel-linea">
                        <span id="sel-count"><?= count($items) ?> artículos</span>
                        <p id="sel-total">$<?= number_format($total, 0, ',', '.') ?></p>
                    </div>

                    <div class="resumen-linea">
                        <span>Envío</span>
                        <small>Calculado al finalizar</small>
                    </div>

                    <div class="resumen-total">
                        <span>Seleccionado</span>
                        <p id="sel-total-2">$<?= number_format($total, 0, ',', '.') ?></p>
                    </div>

                    <div class="resumen-botones">

                        <button type="submit" class="btn-checkout">
                            Agregar al carrito →
                        </button>

                        <a href="<?= BASE_URL ?>/coleccion" class="btn-outline">
                            Ver colección
                        </a>

                    </div>

                    <div class="compartido-aviso">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="15" height="15"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        Los productos seleccionados se agregarán a tu carrito y podrás completar la compra.
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
</section>
</main>

<script>
(function () {
    var checkboxes = document.querySelectorAll('.compartido-checkbox');
    var selBtn     = document.getElementById('seleccionar-todos');
    var selCount   = document.getElementById('sel-count');
    var selTotal   = document.getElementById('sel-total');
    var selTotal2  = document.getElementById('sel-total-2');

    // Item prices × qty from PHP
    var precios = <?= json_encode(
        array_values(array_map(
            fn($i) => ['id' => (int)$i['id'], 'subtotal' => (float)$i['precio'] * (int)$i['cantidad']],
            $items
        ))
    ) ?>;

    function formatPeso(n) {
        return '$' + Math.round(n).toLocaleString('es-AR');
    }

    function recalcular() {
        var count = 0;
        var total = 0;
        checkboxes.forEach(function (cb, idx) {
            if (cb.checked) {
                count++;
                total += precios[idx].subtotal;
            }
        });
        selCount.textContent  = count + ' ' + (count === 1 ? 'artículo' : 'artículos');
        selTotal.textContent  = formatPeso(total);
        selTotal2.textContent = formatPeso(total);
    }

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', recalcular);
    });

    var todosSeleccionados = true;
    selBtn.addEventListener('click', function () {
        todosSeleccionados = !todosSeleccionados;
        checkboxes.forEach(function (cb) { cb.checked = todosSeleccionados; });
        selBtn.textContent = todosSeleccionados ? 'Seleccionar todos' : 'Deseleccionar todos';
        recalcular();
    });
})();
</script>
