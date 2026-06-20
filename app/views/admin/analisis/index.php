<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Analytics</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Analytics</h1>
            <p class="admin-page-subtitle">Métricas generales de tu tienda.</p>
        </div>
    </div>

    <!-- KPI CARDS -->
    <div class="analytics-grid">

        <div class="stat-card">
            <p class="stat-card__label">Ventas hoy</p>
            <p class="stat-card__value">$<?= number_format($ventasHoy, 0, ',', '.') ?></p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Ventas esta semana</p>
            <p class="stat-card__value">$<?= number_format($ventasSemana, 0, ',', '.') ?></p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Ventas del mes</p>
            <p class="stat-card__value">$<?= number_format($ventasMes, 0, ',', '.') ?></p>
        </div>

        <div class="stat-card">
            <p class="stat-card__label">Nuevos clientes (mes)</p>
            <p class="stat-card__value"><?= $nuevosEsteMes ?></p>
            <p class="stat-card__change">de <?= $totalUsuarios ?> total</p>
        </div>

    </div>

    <div class="admin-grid">

        <!-- PRODUCTOS MÁS VENDIDOS -->
        <div class="admin-card">
            <div class="admin-card__head">
                <p class="admin-card__title">Productos más vendidos</p>
            </div>
            <?php if (empty($masVendidos)): ?>
            <div class="admin-empty"><p>Sin datos de ventas todavía.</p></div>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Unidades vendidas</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($masVendidos as $i => $mv): ?>
                <tr>
                    <td style="color:#8e8a82;width:2rem"><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($mv['nombre']) ?></td>
                    <td><strong><?= (int)$mv['total_vendido'] ?></strong></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- VENTAS POR MES -->
        <div class="admin-card">
            <div class="admin-card__head">
                <p class="admin-card__title">Ventas por mes (12 meses)</p>
            </div>
            <?php if (empty($ventasPorMes)): ?>
            <div class="admin-empty"><p>Sin datos de ventas todavía.</p></div>
            <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mes</th>
                        <th>Pedidos</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $meses = ['','Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
                foreach ($ventasPorMes as $v):
                ?>
                <tr>
                    <td><?= $meses[(int)$v['mes']] ?> <?= $v['anio'] ?></td>
                    <td><?= (int)$v['cantidad'] ?></td>
                    <td>$<?= number_format($v['total'] ?? 0, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

    </div>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
