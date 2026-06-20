<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<?php
// Base URL without sort (used for "Cargar más")
$baseColeccion = BASE_URL . '/coleccion';
if ($categoriaSlug) $baseColeccion .= '/' . htmlspecialchars($categoriaSlug);
if ($ordenSlug)     $baseColeccion .= '/' . htmlspecialchars($ordenSlug);
?>

<script>
    window.CATEGORIA_SLUG = <?= json_encode($categoriaSlug ?? '') ?>;
</script>

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
                    action="<?= BASE_URL ?>/coleccion"
                >

                    <input
                        type="text"
                        name="buscar"
                        id="buscador-productos"
                        placeholder="Buscar productos..."
                        value="<?= htmlspecialchars($buscar) ?>"
                    >

                    <button type="submit" class="btn-buscador">🔍</button>

                </form>

                <!-- ================= FILTRO CATEGORÍA (SELECT) ================= -->
                <div class="filtros-cat-wrap">
                    <span class="filtros-cat-label">Categoría:</span>
                    <select
                        class="filtro-btn filtro-btn--cat"
                        id="categoria-select"
                        aria-label="Filtrar por categoría"
                    >
                        <option value="">Todas</option>
                        <?php foreach ($categorias as $cat): ?>
                        <option
                            value="<?= htmlspecialchars($cat['slug']) ?>"
                            <?= $categoriaSlug === $cat['slug'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script>
                document.getElementById('categoria-select').addEventListener('change', function () {
                    var slug      = this.value;
                    var ordenSlug = <?= json_encode($ordenSlug) ?>;
                    var url = window.BASE_URL + '/coleccion';
                    if (slug) url += '/' + slug;
                    if (ordenSlug) url += '/' + ordenSlug;
                    window.location.href = url;
                });
                </script>

            </div>

            <!-- ================= DERECHA ================= -->
            <div class="filtros-right">

                <span>Ordenar por:</span>

                <select class="filtro-btn" id="orden-select" aria-label="Ordenar productos">
                    <option value="nuevos"     <?= $orden === 'nuevos'     ? 'selected' : '' ?>>Más nuevos</option>
                    <option value="destacados" <?= $orden === 'destacados' ? 'selected' : '' ?>>Destacados</option>
                    <option value="precio_asc" <?= $orden === 'precio_asc' ? 'selected' : '' ?>>Menor precio</option>
                    <option value="precio_desc"<?= $orden === 'precio_desc'? 'selected' : '' ?>>Mayor precio</option>
                </select>

                <script>
                document.getElementById('orden-select').addEventListener('change', function () {
                    var orden  = this.value;
                    var catSlug = <?= json_encode($categoriaSlug ?? '') ?>;
                    var buscar  = <?= json_encode($buscar) ?>;
                    var sortMap = {
                        'precio_asc':  'precio-asc',
                        'precio_desc': 'precio-desc',
                        'destacados':  'destacados'
                    };
                    var url = window.BASE_URL + '/coleccion';
                    if (catSlug) url += '/' + catSlug;
                    if (orden && orden !== 'nuevos') url += '/' + sortMap[orden];
                    if (buscar) url += '?buscar=' + encodeURIComponent(buscar);
                    window.location.href = url;
                });
                </script>

            </div>

        </div>

    </section>

    <!-- ================= PRODUCTOS ================= -->
    <section class="productos">

        <div class="contenedor">

            <div class="productos-grid">

                <?php if (!empty($productos)): ?>

                    <?php foreach ($productos as $producto):
                        $esFav    = in_array($producto['id'], $favoritosIds);
                        $logueado = isset($_SESSION['usuario']);
                    ?>

                        <article class="producto-card"
                            data-name="<?= htmlspecialchars(strtolower($producto['nombre'])) ?>"
                            data-categoria="<?= htmlspecialchars(strtolower($producto['categoria_nombre'])) ?>"
                        >

                            <!-- ================= IMAGEN ================= -->
                            <div class="producto-imagen">

                                <a
                                    href="<?= BASE_URL ?>/producto/<?= htmlspecialchars($producto['slug']) ?>"
                                    class="producto-link"
                                >
                                    <img
                                        src="<?= BASE_URL ?>/assets/img/<?= htmlspecialchars($producto['imagen_principal']) ?>"
                                        alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                    >
                                </a>

                                <?php if ($producto['destacado'] == 1): ?>
                                    <span class="producto-tag">Destacado</span>
                                <?php endif; ?>

                                <!-- CORAZÓN -->
                                <?php if ($logueado): ?>
                                <form class="fav-form" method="POST" action="<?= BASE_URL ?>/usuario/favoritos/toggle">
                                    <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($currentPageUrl) ?>">
                                    <button type="submit" class="fav-btn<?= $esFav ? ' fav-btn--active' : '' ?>" aria-label="<?= $esFav ? 'Quitar de favoritos' : 'Agregar a favoritos' ?>">
                                        <?php if ($esFav): ?>
                                        <svg viewBox="0 0 24 24" fill="#c0392b" stroke="#c0392b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                        <?php else: ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <?php else: ?>
                                <button type="button" class="fav-btn fav-btn--guest" aria-label="Guardar en favoritos">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </button>
                                <?php endif; ?>

                            </div>

                            <!-- ================= INFO ================= -->
                            <a
                                href="<?= BASE_URL ?>/producto/<?= htmlspecialchars($producto['slug']) ?>"
                                class="producto-link"
                            >
                                <div class="producto-info">

                                    <div class="producto-top">

                                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>

                                        <p class="precio">
                                            $<?= number_format($producto['precio'], 0, ',', '.') ?>
                                        </p>

                                    </div>

                                    <span class="producto-color">
                                        <?= htmlspecialchars($producto['categoria_nombre']) ?>
                                    </span>

                                </div>
                            </a>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p class="sin-productos">No se encontraron productos.</p>

                <?php endif; ?>

            </div>

        </div>

    </section>

    <!-- ================= PAGINACIÓN ================= -->
    <section class="load-more-section">

        <div class="contenedor load-more-container">

            <p>Mostrando <?= count($productos) ?> productos</p>

            <?php if ($hayMasProductos): ?>

                <?php
                $moreParams = ['pagina' => $pagina + 1];
                if ($buscar) $moreParams['buscar'] = $buscar;
                ?>

                <a
                    href="<?= $baseColeccion . '?' . http_build_query($moreParams) ?>"
                    class="load-more-btn"
                >
                    Cargar más productos
                </a>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
