<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="nosotros-page">

    <!-- ================= HERO ================= -->
    <section class="nosotros-hero" style="background-image: url('<?= BASE_URL; ?>/assets/img/nosotros/nosotros_hero.webp');">

        <div class="hero-overlay"></div>

        <div class="hero-content">

            <span class="hero-label">
                NUESTRA HISTORIA
            </span>

            <h1>
                Malku
            </h1>

            <p>
                Artesanía andina contemporánea nacida entre montañas,
                tradición y fibras naturales.
            </p>

        </div>

    </section>

    <!-- ================= INTRO ================= -->
    <section class="intro-section">

        <div class="contenedor intro-grid">

            <div class="intro-label">

                <span>
                    #1 — NUESTRA HISTORIA
                </span>

            </div>

            <div class="intro-content">

                <h2>
                    Nacida del silencio de las cumbres, nuestra marca es un
                    tributo a la paciencia de la tierra.
                </h2>

                <div class="intro-columns">

                    <p>
                        Malku comenzó no como un negocio, sino como un viaje
                        de retorno. En el corazón de los Andes, descubrimos
                        que el verdadero lujo no reside en la opulencia,
                        sino en la autenticidad de la fibra y el susurro
                        de las manos que la transforman.
                    </p>

                    <p>
                        Durante décadas, hemos cultivado relaciones con
                        comunidades que han guardado el secreto del tejido
                        por generaciones. Hoy, cada pieza de Malku lleva
                        consigo el ADN de una cultura que entiende que
                        el tiempo es el ingrediente más preciado.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- ================= LEGADO ================= -->
    <section class="legado-section">

        <div class="contenedor legado-grid">

            <div class="legado-icono">

                <img 
                    src="<?= BASE_URL; ?>/assets/img/global/icon_malku.png" 
                    alt="Ícono Malku"
                >

            </div>

            <div class="legado-content">

                <span class="section-label">
                    #2 — LEGADO Y ARTESANÍA
                </span>

                <h2>
                    El Arte de lo Lento.
                </h2>

                <p>
                    Nuestra artesanía es un diálogo entre el pasado y el
                    presente. Utilizamos técnicas ancestrales de hilado
                    y tejido natural, aplicándolas a siluetas contemporáneas
                    que desafían las tendencias efímeras del mercado global.
                </p>

                <div class="legado-info">

                    <div>

                        <h4>
                            <strong>Fibras nobles</strong>
                        </h4>

                        <p>
                            Seleccionamos únicamente lana fina de alpaca y
                            vicuña, respetando el ciclo natural de esquila.
                        </p>

                    </div>

                    <div>

                        <h4>
                            <strong>Herencia viva</strong>
                        </h4>

                        <p>
                            Cada prenda cuenta una historia tejida por manos
                            andinas, reinterpretada para el mundo moderno.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- ================= SUSTENTABILIDAD ================= -->
    <section class="sustentabilidad-section">

        <div class="contenedor">

            <div class="section-heading">

                <span class="section-label">
                    #3 — SUSTENTABILIDAD
                </span>

                <h2>
                    Compromiso con el Origen
                </h2>

            </div>

            <!-- GRID -->
            <div class="sustentabilidad-grid">

                <!-- CARD 1 -->
                <article class="s-card s-card-light">

                    <div class="s-icon">
                        🍃
                    </div>

                    <h3>
                        Ética de la Tierra
                    </h3>

                    <p>
                        No solo producimos; preservamos. Nuestros procesos 
                        garantizan el bienestar animal y el pago justo a 
                        los artesanos, asegurando que el ecosistema andino 
                        prospere junto a nosotros.
                    </p>

                </article>

                <!-- CARD 2 -->
                <article class="s-card s-card-primary">

                    <div class="s-icon">
                        ⟳
                    </div>

                    <h3>
                        Circularidad
                    </h3>

                    <p>
                        Diseñamos para la eternidad. Cada prenda Malku
                        está concebida para durar décadas, reduciendo el
                        desperdicio textil a menor escala.
                    </p>

                </article>

                <!-- CARD 3 -->
                <article class="s-card s-card-dark">

                    <div class="s-icon">
                        ▲
                    </div>

                    <h3>
                        Residuos Cero
                    </h3>

                </article>

                <!-- CARD 4 -->
                <article class="s-card s-card-horizontal">

                    <div class="mini-logo">

                        <img 
                            src="<?= BASE_URL; ?>/assets/img/global/icon_malku.png" 
                            alt="Malku"
                        >

                    </div>

                    <div>

                        <h3>
                            Transparencia Radical
                        </h3>

                        <p>
                            Desde el pastoreo hasta el empaque, rastreamos
                            cada fibra para que sepas exactamente de qué
                            cumbre proviene tu prenda.
                        </p>

                    </div>

                </article>

            </div>

        </div>

    </section>

    <!-- ================= CTA ================= -->
    <section class="cta-section">

        <div class="contenedor cta-content">

            <h2>
                Sé parte del legado.
            </h2>

            <a href="<?= BASE_URL; ?>/coleccion" class="cta-btn">
                Descubrí la colección
            </a>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>