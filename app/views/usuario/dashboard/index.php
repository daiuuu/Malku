<main>
<div class="contenedor">

    <!-- ===== PAGE HEADER ===== -->
    <div class="u-page-header">
        <span class="u-page-header__label">Bienvenid<?= strtolower($usuario['nombre'][0]) === 'a' ? 'a' : 'o' ?></span>
        <h1 class="u-page-header__title"><?= htmlspecialchars($usuario['nombre']) ?>.</h1>
    </div>

    <!-- ===== STATS ===== -->
    <div class="u-stat-grid">
        <div class="u-stat-card">
            <span class="u-stat-card__number"><?= $totalPedidos ?></span>
            <span class="u-stat-card__label">Pedidos</span>
            <span class="u-stat-card__desc">Compras realizadas</span>
        </div>
        <div class="u-stat-card">
            <span class="u-stat-card__number"><?= $totalFavoritos ?></span>
            <span class="u-stat-card__label">Favoritos</span>
            <span class="u-stat-card__desc">Productos guardados</span>
        </div>
        <div class="u-stat-card">
            <span class="u-stat-card__number"><?= $totalDirecciones ?></span>
            <span class="u-stat-card__label">Direcciones</span>
            <span class="u-stat-card__desc">Guardadas en tu cuenta</span>
        </div>
        <div class="u-stat-card">
            <span class="u-stat-card__number"><?= $totalProductosComprados ?></span>
            <span class="u-stat-card__label">Productos</span>
            <span class="u-stat-card__desc">Artículos comprados</span>
        </div>
    </div>

    <!-- ===== DASH GRID ===== -->
    <div class="u-dash-grid">

        <!-- Último pedido -->
        <div class="u-card">
            <div class="u-card__header">
                <h3 class="u-card__title">Último pedido</h3>
                <a href="<?= BASE_URL ?>/usuario/pedidos" class="u-card__link">Ver todos →</a>
            </div>
            <?php if ($ultimoPedido): ?>
                <div class="u-order-row">
                    <span class="u-order-row__key">N° de pedido</span>
                    <span class="u-order-row__val">#<?= str_pad($ultimoPedido['id'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="u-order-row">
                    <span class="u-order-row__key">Fecha</span>
                    <span class="u-order-row__val"><?= date('d/m/Y', strtotime($ultimoPedido['fecha_pedido'])) ?></span>
                </div>
                <div class="u-order-row">
                    <span class="u-order-row__key">Estado</span>
                    <span class="u-badge u-badge--<?= $ultimoPedido['estado'] ?>"><?= ucfirst($ultimoPedido['estado']) ?></span>
                </div>
                <div class="u-order-row">
                    <span class="u-order-row__key">Total</span>
                    <span class="u-order-row__val u-order-row__total">$<?= number_format($ultimoPedido['total'], 0, ',', '.') ?></span>
                </div>
                <div style="margin-top:20px">
                    <a href="<?= BASE_URL ?>/usuario/pedidos/<?= $ultimoPedido['id'] ?>" class="u-btn u-btn--outline u-btn--sm">Ver detalle</a>
                </div>
            <?php else: ?>
                <p class="u-card__empty">Todavía no realizaste compras.</p>
                <a href="<?= BASE_URL ?>/coleccion" class="u-btn u-btn--dark u-btn--sm">Explorar colección →</a>
            <?php endif; ?>
        </div>

        <!-- Membresía -->
        <div class="u-membership-card">
            <span class="u-membership-card__label">Círculo Exclusivo</span>
            <h3 class="u-membership-card__title">Membresía Malku</h3>
            <ul>
                <li>Acceso anticipado a colecciones</li>
                <li>Promociones exclusivas para miembros</li>
                <li>Prioridad en nuevos lanzamientos</li>
                <li>Beneficios crecientes por fidelidad</li>
            </ul>
            <a href="<?= BASE_URL ?>/usuario/membresia" class="u-btn u-btn--outline" style="color:#fff;border-color:rgba(255,255,255,.4)">Ver mi membresía</a>
        </div>

    </div>

    <!-- ===== BANNER ===== -->
    <div class="u-banner">
        <p class="u-banner__quote"><i>El arte de lo lento y lo eterno.</i></p>
        <a href="<?= BASE_URL ?>/nosotros" class="u-btn u-btn--outline" style="color:#fff;border-color:rgba(255,255,255,.4)">Conocer nuestra historia</a>
    </div>

</div>
</main>
