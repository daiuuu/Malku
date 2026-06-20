<main id="producto-page">

    <!-- ================= VOLVER ================= -->
    <section class="volver-coleccion-section">

        <div class="contenedor volver-coleccion-container">

            <a
                href="<?= BASE_URL; ?>/coleccion"
                class="volver-coleccion-btn"
            >
                Volver a colección
            </a>

        </div>

    </section>

    <!-- ================= PRODUCTO ================= -->
    <section class="producto-section">

        <div class="contenedor producto-grid">

            <!-- ================= IMAGEN ================= -->
            <div class="producto-galeria">

                <div class="galeria-item galeria-main">

                    <img
                        src="<?= BASE_URL; ?>/assets/img/<?= $producto['imagen_principal']; ?>"
                        alt="<?= $producto['nombre']; ?>"
                    >

                </div>

            </div>

            <!-- ================= INFO ================= -->
            <div class="producto-info">

                <!-- ================= HEADER ================= -->
                <div class="producto-header">

                    <h1>
                        <?= $producto['nombre']; ?>
                    </h1>

                    <span class="precio">

                        $<?= number_format(
                            $producto['precio'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </span>

                </div>

                <!-- ================= DESCRIPCIÓN ================= -->
                <p class="producto-descripcion">

                    <?= $producto['descripcion']; ?>

                </p>

                <!-- ================= CATEGORÍA ================= -->
                <div class="producto-bloque">

                    <span class="producto-label">
                        CATEGORÍA
                    </span>

                    <p>
                        <?= $producto['categoria_nombre']; ?>
                    </p>

                </div>

                <!-- ================= STOCK ================= -->
                <div class="producto-bloque">

                    <span class="producto-label">
                        STOCK DISPONIBLE
                    </span>

                    <p>
                        <?= $producto['stock']; ?> unidades
                    </p>

                </div>

                <!-- ================= FORMULARIO ================= -->
                <form
                    action="<?= BASE_URL; ?>/carrito/agregar"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="producto_id"
                        value="<?= $producto['id']; ?>"
                    >

                    <!-- ================= CANTIDAD ================= -->
                    <div class="producto-bloque">

                        <span class="producto-label">
                            CANTIDAD
                        </span>

                        <div class="cantidad-selector">

                            <button
                                type="button"
                                class="cantidad-btn"
                                id="cantidad-menos"
                            >
                                −
                            </button>

                            <input
                                type="number"
                                name="cantidad"
                                value="1"
                                min="1"
                                max="<?= $producto['stock']; ?>"
                                id="cantidad-input"
                                class="cantidad-input"
                            >

                            <button
                                type="button"
                                class="cantidad-btn"
                                id="cantidad-mas"
                            >
                                +
                            </button>

                        </div>

                    </div>

                    <!-- ================= BOTÓN ================= -->
                    <button
                        type="submit"
                        class="add-cart-btn"
                    >
                        AGREGAR AL CARRITO
                    </button>

                </form>

                <!-- ================= FAVORITO ================= -->
                <?php if ($logueado): ?>
                <form method="POST" action="<?= BASE_URL ?>/usuario/favoritos/toggle" class="fav-detalle-form">
                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                    <input type="hidden" name="redirect" value="<?= BASE_URL ?>/producto/<?= htmlspecialchars($producto['slug']) ?>">
                    <button type="submit" class="fav-detalle-btn<?= $esFav ? ' fav-detalle-btn--active' : '' ?>">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="<?= $esFav ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <?= $esFav ? 'Guardado en favoritos' : 'Agregar a favoritos' ?>
                    </button>
                </form>
                <?php else: ?>
                <button type="button" class="fav-detalle-btn fav-btn--guest">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    Agregar a favoritos
                </button>
                <?php endif; ?>

                <!-- ================= ACORDEÓN ================= -->
                <div class="producto-acordeon">

                    <details>

                        <summary>
                            MATERIALES
                        </summary>

                        <p>
                            <?= !empty($producto['materiales'])
                                ? $producto['materiales']
                                : 'Información no disponible';
                            ?>
                        </p>

                    </details>

                    <details>

                        <summary>
                            INSTRUCCIONES DE CUIDADO
                        </summary>

                        <p>
                            <?= !empty($producto['cuidados'])
                                ? $producto['cuidados']
                                : 'Información no disponible';
                            ?>
                        </p>

                    </details>

                    <details>

                        <summary>
                            ENVÍOS Y DEVOLUCIONES
                        </summary>

                        <p>

                            Consultá nuestra política de
                            <a href="<?= BASE_URL; ?>/envios-devoluciones">
                                envíos y devoluciones
                            </a>.
                        </p>

                    </details>

                </div>

            </div>

        </div>

    </section>

    <!-- ================= RELACIONADOS ================= -->
    <section class="related-section">

        <div class="contenedor">

            <h2 class="related-title">
                También te puede gustar
            </h2>

            <div class="related-grid">

                <?php foreach($relacionados as $item): ?>

                    <article class="related-card">

                        <a
                            href="<?= BASE_URL; ?>/producto/<?= htmlspecialchars($item['slug']); ?>"
                        >

                            <div class="related-image">

                                <img
                                    src="<?= BASE_URL; ?>/assets/img/<?= htmlspecialchars($item['imagen_principal']); ?>"
                                    alt="<?= $item['nombre']; ?>"
                                >

                            </div>

                            <div class="related-info">

                                <h3>
                                    <?= htmlspecialchars($item['nombre']); ?>
                                </h3>

                                <span>

                                    $<?= number_format(
                                        $item['precio'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>

                                </span>

                            </div>

                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

</main>