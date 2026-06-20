<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <!-- BREADCRUMB -->
    <nav class="admin-breadcrumb">
        <span>Admin</span>
        <span>›</span>
        <span>Dashboard</span>
    </nav>

    <!-- PAGE HEADER -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Bienvenida, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h1>
            <p class="admin-page-subtitle">Resumen general de tu tienda al día de hoy.</p>
        </div>
        <a href="<?= BASE_URL ?>/" class="btn-admin-secondary btn-admin-sm">Ver tienda →</a>
    </div>

    <!-- FLASH -->
    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <!-- STAT CARDS -->
    <div class="stat-cards">

        <div class="stat-card">
            <p class="stat-card__label">Ventas del mes</p>
            <p class="stat-card__value">$<?= number_format($ventasMes, 0, ',', '.') ?></p>
            <p class="stat-card__change <?= $cambioPct < 0 ? 'stat-card__change--down' : '' ?>">
                <?= $cambioPct >= 0 ? '+' : '' ?><?= $cambioPct ?>% vs mes anterior
            </p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Pedidos hoy</p>
            <p class="stat-card__value"><?= $pedidosHoy ?></p>
            <p class="stat-card__change">nuevos pedidos</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Productos activos</p>
            <p class="stat-card__value"><?= $productosActivos ?></p>
            <p class="stat-card__change">en catálogo</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Clientes</p>
            <p class="stat-card__value"><?= $totalUsuarios ?></p>
            <p class="stat-card__change">registrados</p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Mensajes</p>
            <p class="stat-card__value"><?= $mensajesPendientes ?></p>
            <p class="stat-card__change">sin responder</p>
        </div>

    </div>

    <!-- GRID: ÚLTIMOS PEDIDOS + MÁS VENDIDOS -->
    <div class="admin-grid">

        <!-- ÚLTIMOS PEDIDOS -->
        <div class="admin-card">
            <div class="admin-card__head">
                <p class="admin-card__title">Últimos pedidos</p>
                <a href="<?= BASE_URL ?>/admin/pedidos" class="btn-admin-secondary btn-admin-sm">Ver todos</a>
            </div>

            <?php if (empty($ultimosPedidos)): ?>
            <div class="admin-empty"><p>No hay pedidos todavía.</p></div>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($ultimosPedidos as $p): ?>
                <tr>
                    <td><a href="<?= BASE_URL ?>/admin/pedidos/<?= $p['id'] ?>">#<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?></a></td>
                    <td><?= htmlspecialchars(($p['nombre'] ?? '') . ' ' . ($p['apellido'] ?? '')) ?></td>
                    <td>$<?= number_format($p['total'] ?? 0, 0, ',', '.') ?></td>
                    <td><span class="badge badge--<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- MÁS VENDIDOS -->
        <div class="admin-card">
            <div class="admin-card__head">
                <p class="admin-card__title">Más vendidos</p>
                <a href="<?= BASE_URL ?>/admin/analytics" class="btn-admin-secondary btn-admin-sm">Analytics</a>
            </div>

            <?php if (empty($masVendidos)): ?>
            <div class="admin-empty"><p>Sin datos de ventas todavía.</p></div>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr><th>Producto</th><th>Vendidos</th></tr>
                </thead>
                <tbody>
                <?php foreach ($masVendidos as $mv): ?>
                <tr>
                    <td><?= htmlspecialchars($mv['nombre']) ?></td>
                    <td><?= (int)$mv['total_vendido'] ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

    </div>

    <!-- ACCESOS RÁPIDOS -->
    <div class="admin-card">
        <div class="admin-card__head">
            <p class="admin-card__title">Accesos rápidos</p>
        </div>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;padding:1.25rem 1.5rem;">
            <a href="<?= BASE_URL ?>/admin/productos/crear"  class="btn-admin btn-admin-sm">+ Producto</a>
            <a href="<?= BASE_URL ?>/admin/categorias/crear" class="btn-admin-secondary btn-admin-sm">+ Categoría</a>
            <a href="<?= BASE_URL ?>/admin/pedidos"          class="btn-admin-secondary btn-admin-sm">Ver Pedidos</a>
            <a href="<?= BASE_URL ?>/admin/stock"            class="btn-admin-secondary btn-admin-sm">Ajustar Stock</a>
            <a href="<?= BASE_URL ?>/admin/contacto"         class="btn-admin-secondary btn-admin-sm">Mensajes</a>
        </div>
    </div>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
