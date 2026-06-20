<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="coleccion-page">

    <!-- ================= HERO ================= -->
    <section class="coleccion-hero">

        <div class="contenedor">

            <h1>
                <i>Colección</i>
            </h1>

            <p>
                Descubrí la esencia de la artesanía andina a través de nuestras
                prendas tejidas a mano con lana premium. Cada pieza cuenta una
                historia de tradición, elaborada con fibras sustentables de alpaca
                y merino provenientes de las altas montañas.
            </p>

        </div>

    </section>

    <!-- ================= FILTROS ================= -->
    <section class="filtros">

        <div class="contenedor filtros-container">

            <!-- ================= IZQUIERDA ================= -->
            <div class="filtros-left">

                <!-- ================= BUSCADOR ================= -->
                <form
                    class="filtros-buscador"
                    method="GET"
                    action="<?= BASE_URL; ?>/coleccion"
                >

                    <input
                        type="text"
                        name="buscar"
                        id="buscador-productos"
                        placeholder="Buscar productos..."
                        value="<?= htmlspecialchars($_GET['buscar'] ?? ''); ?>"
                    >

                    <button
                        type="submit"
                        class="btn-buscador"
                    >
                        🔍
                    </button>

                </form>

                <!-- ================= FILTRO CATEGORÍA ================= -->
                <form
                    method="GET"
                    action="<?= BASE_URL; ?>/coleccion"
                >

                    <?php if(isset($_GET['buscar'])): ?>

                        <input
                            type="hidden"
                            name="buscar"
                            value="<?= htmlspecialchars($_GET['buscar']); ?>"
                        >

                    <?php endif; ?>

                    <?php if(isset($_GET['orden'])): ?>

                        <input
                            type="hidden"
                            name="orden"
                            value="<?= htmlspecialchars($_GET['orden']); ?>"
                        >

                    <?php endif; ?>

                    <select
                        name="categoria"
                        class="filtro-btn"
                        onchange="this.form.submit()"
                    >

                        <option value="">
                            Todas las categorías
                        </option>

                        <?php foreach($categorias as $categoriaItem): ?>

                            <option
                                value="<?= $categoriaItem['id']; ?>"

                                <?= (
                                    isset($_GET['categoria']) &&
                                    $_GET['categoria'] == $categoriaItem['id']
                                )
                                    ? 'selected'
                                    : '';
                                ?>
                            >

                                <?= htmlspecialchars($categoriaItem['nombre']); ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </form>

            </div>

            <!-- ================= DERECHA ================= -->
            <div class="filtros-right">

                <span>
                    Ordenar por:
                </span>

                <form
                    method="GET"
                    action="<?= BASE_URL; ?>/coleccion"
                >

                    <?php if(isset($_GET['buscar'])): ?>

                        <input
                            type="hidden"
                            name="buscar"
                            value="<?= htmlspecialchars($_GET['buscar']); ?>"
                        >

                    <?php endif; ?>

                    <?php if(isset($_GET['categoria'])): ?>

                        <input
                            type="hidden"
                            name="categoria"
                            value="<?= htmlspecialchars($_GET['categoria']); ?>"
                        >

                    <?php endif; ?>

                    <select
                        name="orden"
                        class="filtro-btn"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="nuevos"

                            <?= (
                                ($_GET['orden'] ?? 'nuevos')
                                == 'nuevos'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Más nuevos
                        </option>

                        <option
                            value="precio_asc"

                            <?= (
                                ($_GET['orden'] ?? '')
                                == 'precio_asc'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Menor precio
                        </option>

                        <option
                            value="precio_desc"

                            <?= (
                                ($_GET['orden'] ?? '')
                                == 'precio_desc'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Mayor precio
                        </option>

                    </select>

                </form>

            </div>

        </div>

    </section>

    <!-- ================= PRODUCTOS ================= -->
    <section class="productos">

        <div class="contenedor">

            <div class="productos-grid">

                <?php if(!empty($productos)): ?>

                    <?php foreach($productos as $producto):
                        $esFav    = in_array($producto['id'], $favoritosIds);
                        $logueado = isset($_SESSION['usuario']);
                    ?>

                        <article class="producto-card"
                            data-name="<?= htmlspecialchars(strtolower($producto['nombre'])); ?>"
                            data-categoria="<?= htmlspecialchars(strtolower($producto['categoria_nombre'])); ?>"
                        >

                            <!-- ================= IMAGEN ================= -->
                            <div class="producto-imagen">

                                <a
                                    href="<?= BASE_URL; ?>/producto/<?= htmlspecialchars($producto['slug']); ?>"
                                    class="producto-link"
                                >
                                    <img
                                        src="<?= BASE_URL; ?>/assets/img/<?= htmlspecialchars($producto['imagen_principal']); ?>"
                                        alt="<?= htmlspecialchars($producto['nombre']); ?>"
                                    >
                                </a>

                                <?php if($producto['destacado'] == 1): ?>
                                    <span class="producto-tag">Destacado</span>
                                <?php endif; ?>

                                <!-- CORAZÓN -->
                                <?php if($logueado): ?>
                                <form class="fav-form" method="POST" action="<?= BASE_URL ?>/usuario/favoritos/toggle">
                                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="redirect" value="<?= BASE_URL ?>/coleccion<?= !empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING']) : '' ?>">
                                    <button type="submit" class="fav-btn<?= $esFav ? ' fav-btn--active' : '' ?>" aria-label="<?= $esFav ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>">
                                        <?php if($esFav): ?>
                                        <svg viewBox="0 0 24 24" fill="#c0392b" stroke="#c0392b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                        <?php else: ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <?php else: ?>
                                <a href="<?= BASE_URL ?>/login" class="fav-btn" aria-label="Iniciar sesión para guardar">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </a>
                                <?php endif; ?>

                            </div>

                            <!-- ================= INFO ================= -->
                            <a
                                href="<?= BASE_URL; ?>/producto/<?= htmlspecialchars($producto['slug']); ?>"
                                class="producto-link"
                            >
                                <div class="producto-info">

                                    <div class="producto-top">

                                        <h3>
                                            <?= htmlspecialchars($producto['nombre']); ?>
                                        </h3>

                                        <p class="precio">
                                            $<?= number_format($producto['precio'], 0, ',', '.'); ?>
                                        </p>

                                    </div>

                                    <span class="producto-color">
                                        <?= htmlspecialchars($producto['categoria_nombre']); ?>
                                    </span>

                                </div>
                            </a>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p class="sin-productos">
                        No se encontraron productos.
                    </p>

                <?php endif; ?>

            </div>

        </div>

    </section>

    <!-- ================= PAGINACIÓN ================= -->
    <section class="load-more-section">

        <div class="contenedor load-more-container">

            <p>
                Mostrando <?= count($productos); ?> productos
            </p>

            <?php if($hayMasProductos): ?>

                <?php

                $queryParams = $_GET;

                $queryParams['pagina'] = $pagina + 1;

                ?>

                <a
                    href="<?= BASE_URL; ?>/coleccion?<?= http_build_query($queryParams); ?>"
                    class="load-more-btn"
                >
                    Cargar más productos
                </a>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>