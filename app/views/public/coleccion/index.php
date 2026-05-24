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
                        placeholder="Buscar productos..."
                        id="buscador-productos"
                        value="<?= $_GET['buscar'] ?? ''; ?>"
                    >

                    <button type="submit" class="btn-buscador">
                        🔍
                    </button>

                </form>

                <!-- ================= FILTRO CATEGORÍA ================= -->
                <form method="GET" action="<?= BASE_URL; ?>/coleccion">

                    <?php if(isset($_GET['buscar'])): ?>
                        <input 
                            type="hidden"
                            name="buscar"
                            value="<?= $_GET['buscar']; ?>"
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

                        <?php foreach($categorias as $categoria): ?>

                            <option 
                                value="<?= $categoria['id']; ?>"
                                <?= (
                                    isset($_GET['categoria']) &&
                                    $_GET['categoria'] == $categoria['id']
                                ) ? 'selected' : ''; ?>
                            >

                                <?= $categoria['nombre']; ?>

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

                <form method="GET" action="<?= BASE_URL; ?>/coleccion">

                    <?php if(isset($_GET['buscar'])): ?>
                        <input 
                            type="hidden"
                            name="buscar"
                            value="<?= $_GET['buscar']; ?>"
                        >
                    <?php endif; ?>

                    <?php if(isset($_GET['categoria'])): ?>
                        <input 
                            type="hidden"
                            name="categoria"
                            value="<?= $_GET['categoria']; ?>"
                        >
                    <?php endif; ?>

                    <select 
                        name="orden"
                        class="filtro-btn"
                        onchange="this.form.submit()"
                    >

                        <option value="nuevos">
                            Más nuevos
                        </option>

                        <option 
                            value="precio_asc"
                            <?= (
                                ($_GET['orden'] ?? '') == 'precio_asc'
                            ) ? 'selected' : ''; ?>
                        >
                            Menor precio
                        </option>

                        <option 
                            value="precio_desc"
                            <?= (
                                ($_GET['orden'] ?? '') == 'precio_desc'
                            ) ? 'selected' : ''; ?>
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

                    <?php foreach($productos as $producto): ?>

                        <article class="producto-card">

                            <a 
                                href="<?= BASE_URL; ?>/producto?id=<?= $producto['id']; ?>"
                                class="producto-link"
                            >

                                <!-- ================= IMAGEN ================= -->
                                <div class="producto-imagen">

                                    <img 
                                        src="<?= BASE_URL; ?>/assets/img/productos/<?= $producto['imagen_principal']; ?>"
                                        alt="<?= $producto['nombre']; ?>"
                                    >

                                    <?php if($producto['destacado'] == 1): ?>

                                        <span class="producto-tag">
                                            Destacado
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <!-- ================= INFO ================= -->
                                <div class="producto-info">

                                    <div class="producto-top">

                                        <h3>
                                            <?= $producto['nombre']; ?>
                                        </h3>

                                        <p class="precio">

                                            $<?= number_format(
                                                $producto['precio'],
                                                0,
                                                ',',
                                                '.'
                                            ); ?>

                                        </p>

                                    </div>


                                    <!-- ================= CATEGORÍA ================= -->
                                    <span class="producto-color">

                                        <?= $producto['categoria_nombre']; ?>

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

                <a 
                    href="<?= BASE_URL; ?>/coleccion?pagina=<?= $pagina + 1; ?>"
                    class="load-more-btn"
                >
                    Cargar más
                </a>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>