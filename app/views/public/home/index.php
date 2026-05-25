<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="inicio">

    <!-- ================= HERO ================= -->
    <section class="hero" style="background-image: url('<?= BASE_URL; ?>/assets/img/inicio/hero_section_malku.webp');">

        <div class="hero-overlay"></div>

        <div class="hero-content">

            <h1>Malku</h1>

            <p>
                ARTESANÍA EN LANA PARA LA MUJER CONTEMPORÁNEA
            </p>

            <a href="<?= BASE_URL; ?>/coleccion" class="btn">Ver colección</a>

        </div>

    </section>


    <!-- ================= COLECCIÓN DESTACADA ================= -->
    <section class="coleccion">

        <div class="contenedor">

            <div class="coleccion-header">

                <div>

                    <span class="subtitulo">NUESTRA SELECCIÓN</span>

                    <h2>
                        Colección Destacada
                    </h2>

                </div>

                <a href="<?= BASE_URL; ?>/coleccion" class="explorar">Explorar todo</a>

            </div>


            <!-- ================= PRODUCTOS DINÁMICOS ================= -->
            <div class="grid-productos">

                <?php if(!empty($productosDestacados)): ?>

                    <?php foreach($productosDestacados as $producto): ?>

                        <article class="producto">

                            <a href="<?= BASE_URL; ?>/producto/<?= $producto['slug']; ?>">

                                <img 
                                    src="<?= BASE_URL; ?>/assets/img/productos/<?= $producto['imagen_principal']; ?>" 
                                    alt="<?= $producto['nombre']; ?>"
                                >

                                <h3>
                                    <?= $producto['nombre']; ?>
                                </h3>

                                <p>
                                    $<?= number_format($producto['precio'], 0, ',', '.'); ?>
                                </p>

                            </a>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>
                        No hay productos destacados disponibles.
                    </p>

                <?php endif; ?>

            </div>

        </div>

    </section>

    <!-- ================= HISTORIA ================= -->
    <section class="historia">

        <div class="contenedor historia-grid">

            <div class="historia-texto">

                <a href="<?= BASE_URL; ?>/nosotros" class="explorar">NUESTRA HISTORIA</a>

                <h2>
                    El Legado del Cóndor en cada Punto
                </h2>

                <p>
                    Malku nace de la conexión profunda entre la naturaleza de los Andes 
                    y la visión contemporánea del diseño. Inspirados en la majestuosidad 
                    del cóndor, creamos piezas que trascienden el tiempo.
                </p>

                <div class="historia-features">

                    <div>

                        <h4>
                            <strong>Inspiración artesanal</strong>
                        </h4>

                        <p>
                            Técnicas ancestrales preservadas por manos expertas.
                        </p>

                    </div>

                    <div>

                        <h4>
                            <strong>Fibras naturales</strong>
                        </h4>

                        <p>
                            Lana de la más alta calidad para un lujo duradero.
                        </p>

                    </div>

                </div>

            </div>

            <div class="historia-imagen">

                <img src="<?= BASE_URL; ?>/assets/img/inicio/legado_del_condor.webp" alt="El legado del cóndor">

            </div>

        </div>

    </section>


    <!-- ================= SUSCRIPCIÓN ================= -->
    <section class="suscripcion">

        <div class="contenedor suscripcion-contenido">

            <h3>
                Suscribite a nuestro Diario
            </h3>

            <p>
                Recibí actualizaciones sobre nuevas colecciones y procesos artesanales.
            </p>

            <!-- ================= FORMULARIO ================= -->
            <form 
                class="form-suscripcion"
                action="<?= BASE_URL; ?>/suscripcion"
                method="POST"
            >

                <input 
                    type="email"
                    name="email"
                    placeholder="Correo electrónico"
                    required
                >

                <button type="submit">Unirse</button>

            </form>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>