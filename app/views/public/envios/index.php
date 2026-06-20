<?php
$titulo = $titulo ?? 'Envíos y Devoluciones | Malku';
$css    = $css    ?? 'public/envios_devoluciones.css';
$cfg    = $cfg    ?? [];
?>

<!-- ================= MAIN ================= -->
<main id="envios-page">

    <!-- ================= HERO ================= -->
    <section class="envios-hero">

        <div class="contenedor envios-hero-grid">

            <div class="envios-hero-texto">
                <h1>Envíos & <br>Devoluciones</h1>
                <p>
                    Cada pieza MALKU es cuidadosamente tejida y preparada
                    para su viaje hasta tu hogar.
                    Nuestro proceso refleja la misma paciencia,
                    precisión y respeto por el tiempo que vive en cada fibra.
                </p>
            </div>

            <div class="envios-hero-imagen">
                <img
                    src="<?= BASE_URL; ?>/assets/img/envios_devoluciones_hero.webp"
                    alt="Packaging artesanal Malku"
                >
            </div>

        </div>

    </section>

    <!-- ================= POLÍTICAS ================= -->
    <section class="politicas-envio">

        <div class="contenedor politicas-grid">

            <div class="shipping-card">

                <h2>Política de Envíos</h2>

                <!-- Buenos Aires -->
                <div class="shipping-item">
                    <div class="shipping-top">
                        <div>
                            <h3>Envíos a Buenos Aires</h3>
                            <span>Entrega express</span>
                        </div>
                        <p class="shipping-precio">
                            <?= htmlspecialchars($cfg['envios_ba_precio'] ?? 'Gratis en compras +$250.000') ?>
                        </p>
                    </div>
                    <p class="shipping-desc">
                        <?= htmlspecialchars($cfg['envios_ba_desc'] ?? '') ?>
                    </p>
                </div>

                <!-- Nacional -->
                <div class="shipping-item">
                    <div class="shipping-top">
                        <div>
                            <h3>Envíos Nacionales</h3>
                            <span>Argentina Standard</span>
                        </div>
                        <p class="shipping-precio">
                            <?= htmlspecialchars($cfg['envios_nacional_precio'] ?? 'Calculado al finalizar compra') ?>
                        </p>
                    </div>
                    <p class="shipping-desc">
                        <?= htmlspecialchars($cfg['envios_nacional_desc'] ?? '') ?>
                    </p>
                </div>

            </div>

            <!-- Compromiso -->
            <div class="compromiso-card">
                <div class="compromiso-icono">✦</div>
                <h3>Nuestro Compromiso</h3>
                <p><?= nl2br(htmlspecialchars($cfg['envios_compromiso'] ?? '')) ?></p>
                <div class="compromiso-tags">
                    <span>Packaging reciclable</span>
                    <span>Carbon Neutral</span>
                </div>
            </div>

        </div>

    </section>


    <!-- ================= TRACK ORDER ================= -->
    <section class="track-order">

        <div class="contenedor track-container">

            <h2>Seguí tu pedido</h2>

            <p>
                Ingresá tu número de seguimiento para conocer
                el estado actual de tus piezas artesanales.
            </p>

            <form class="track-form">
                <input type="text" placeholder="Número de pedido / Tracking ID">
                <button type="submit">Rastrear envío</button>
            </form>

        </div>

    </section>


    <!-- ================= DEVOLUCIONES ================= -->
    <section class="devoluciones">

        <div class="contenedor devoluciones-grid">

            <div class="devoluciones-intro">
                <span class="section-label">CUIDADO & CONTINUIDAD</span>
                <h2>Devoluciones y Cambios</h2>
                <p><?= htmlspecialchars($cfg['dev_intro'] ?? '') ?></p>
            </div>

            <div class="devoluciones-info">

                <div class="info-block">
                    <h3>Ventana de <?= (int)($cfg['dev_ventana_dias'] ?? 14) ?> días</h3>
                    <p><?= htmlspecialchars($cfg['dev_ventana_desc'] ?? '') ?></p>
                </div>

                <div class="info-block">
                    <h3>Reembolsos</h3>
                    <p><?= htmlspecialchars($cfg['dev_reembolso_desc'] ?? '') ?></p>
                </div>

                <div class="info-block">
                    <h3>Cambios</h3>
                    <p><?= htmlspecialchars($cfg['dev_cambios_desc'] ?? '') ?></p>
                </div>

                <div class="info-block">
                    <h3>Atención personalizada</h3>
                    <p><?= htmlspecialchars($cfg['dev_atencion_desc'] ?? '') ?></p>
                </div>

            </div>

        </div>

    </section>


    <!-- ================= FAQ ================= -->
    <section class="faq-section">

        <div class="contenedor faq-container">

            <h2>Preguntas Frecuentes</h2>

            <div class="faq-list">

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Impuestos y tasas internacionales</span>
                        <span class="faq-icon">+</span>
                    </button>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Piezas artesanales personalizadas</span>
                        <span class="faq-icon">+</span>
                    </button>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Extensión de devoluciones festivas</span>
                        <span class="faq-icon">+</span>
                    </button>
                </div>

            </div>

        </div>

    </section>

</main>
