<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../partials/sidebar.php'; ?>

<main class="usuario-main">

    <!-- ================= HERO ================= -->
    <section class="user-hero">

        <div class="user-hero-inner">

            <span class="user-hero-label">
                Bienvenida nuevamente
            </span>

            <h1 class="user-hero-name">
                <?= htmlspecialchars(
                    $usuario['nombre']
                ); ?>.
            </h1>

            <p class="user-hero-date">
                <?= date('d \d\e F \d\e Y'); ?>
            </p>

        </div>

    </section>

    <!-- ================= ESTADÍSTICAS ================= -->
    <section class="user-stats-section">

        <div class="stats-grid">

            <!-- FAVORITOS -->
            <div class="stat-card">

                <span class="stat-number">
                    <?= $totalFavoritos; ?>
                </span>

                <span class="stat-label">
                    Favoritos
                </span>

                <span class="stat-desc">
                    Productos guardados
                </span>

            </div>

            <!-- PEDIDOS -->
            <div class="stat-card">

                <span class="stat-number">
                    <?= $totalPedidos; ?>
                </span>

                <span class="stat-label">
                    Pedidos
                </span>

                <span class="stat-desc">
                    Compras realizadas
                </span>

            </div>

            <!-- PRODUCTOS COMPRADOS -->
            <div class="stat-card">

                <span class="stat-number">
                    <?= $totalProductosComprados; ?>
                </span>

                <span class="stat-label">
                    Productos
                </span>

                <span class="stat-desc">
                    Artículos comprados
                </span>

            </div>

            <!-- DIRECCIONES -->
            <div class="stat-card">

                <span class="stat-number">
                    <?= $totalDirecciones; ?>
                </span>

                <span class="stat-label">
                    Direcciones
                </span>

                <span class="stat-desc">
                    Guardadas en tu cuenta
                </span>

            </div>

        </div>

    </section>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <section class="user-content-section">

        <div class="user-content-grid">

            <!-- ================= ÚLTIMO PEDIDO ================= -->
            <div class="content-card order-card">

                <div class="card-header">

                    <span class="card-label">
                        Actividad reciente
                    </span>

                    <h3 class="card-title">
                        Último pedido
                    </h3>

                </div>

                <div class="card-body">

                    <?php if($ultimoPedido): ?>

                        <div class="order-info">

                            <div class="order-row">

                                <span class="order-key">
                                    N° de pedido
                                </span>

                                <span class="order-val">
                                    #<?= str_pad(
                                        $ultimoPedido['id'],
                                        5,
                                        '0',
                                        STR_PAD_LEFT
                                    ); ?>
                                </span>

                            </div>

                            <div class="order-row">

                                <span class="order-key">
                                    Fecha
                                </span>

                                <span class="order-val">
                                    <?= date(
                                        'd/m/Y',
                                        strtotime(
                                            $ultimoPedido['fecha_creacion']
                                        )
                                    ); ?>
                                </span>

                            </div>

                            <div class="order-row">

                                <span class="order-key">
                                    Estado
                                </span>

                                <span class="order-status order-status--<?=
                                    $ultimoPedido['estado'];
                                ?>">
                                    <?= ucfirst(
                                        $ultimoPedido['estado']
                                    ); ?>
                                </span>

                            </div>

                            <div class="order-row">

                                <span class="order-key">
                                    Total
                                </span>

                                <span class="order-val order-total">
                                    $<?= number_format(
                                        $ultimoPedido['total'],
                                        0,
                                        ',',
                                        '.'
                                    ); ?>
                                </span>

                            </div>

                        </div>

                        <a
                            href="<?= BASE_URL; ?>/usuario/pedidos"
                            class="card-link"
                        >
                            Ver todos los pedidos →
                        </a>

                    <?php else: ?>

                        <p class="card-empty">
                            Todavía no realizaste compras.
                        </p>

                        <a
                            href="<?= BASE_URL; ?>/coleccion"
                            class="card-link"
                        >
                            Explorar la colección →
                        </a>

                    <?php endif; ?>

                </div>

            </div>

            <!-- ================= MEMBRESÍA ================= -->
            <div class="content-card membership-card">

                <div class="membership-inner">

                    <span class="membership-label">
                        Exclusivo
                    </span>

                    <h3 class="membership-title">
                        Círculo Malku
                    </h3>

                    <ul class="membership-benefits">

                        <li>
                            Acceso anticipado a colecciones
                        </li>

                        <li>
                            Promociones exclusivas
                        </li>

                        <li>
                            Prioridad en lanzamientos
                        </li>

                        <li>
                            Beneficios para miembros
                        </li>

                    </ul>

                    <a
                        href="<?= BASE_URL; ?>/usuario/membresia"
                        class="btn-membership"
                    >
                        Ver beneficios
                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- ================= BANNER ================= -->
    <section class="user-banner">

        <div class="user-banner-inner">

            <p class="banner-quote">
                El arte de lo lento y lo eterno.
            </p>

            <a
                href="<?= BASE_URL; ?>/nosotros"
                class="btn-banner"
            >
                Conocer nuestra historia
            </a>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
