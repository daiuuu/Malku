<?php
$tierBadge = [
    'bronce' => 'badge--pendiente',
    'plata'  => 'badge--enviado',
    'oro'    => 'badge--activo',
];
$estadoBadge = [
    'activa'    => 'badge--activo',
    'vencida'   => 'badge--pendiente',
    'cancelada' => 'badge--cancelado',
];

$bronce = count(array_filter($usuarios, fn($u) => $u['tier_auto']['key'] === 'bronce'));
$plata  = count(array_filter($usuarios, fn($u) => $u['tier_auto']['key'] === 'plata'));
$oro    = count(array_filter($usuarios, fn($u) => $u['tier_auto']['key'] === 'oro'));
$manual = count(array_filter($usuarios, fn($u) => !empty($u['membresia_tipo'])));
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Membresías</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Membresías</h1>
            <p class="admin-page-subtitle"><?= count($usuarios) ?> clientes registrados</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/membresias/beneficios" class="btn-admin-secondary">
            Editar beneficios
        </a>
    </div>

    <?php if ($flash_ok): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stat-cards" style="margin-bottom:28px">
        <div class="stat-card">
            <div class="stat-card__label">Bronce</div>
            <div class="stat-card__value"><?= $bronce ?></div>
            <div class="stat-card__change" style="color:#8e8a82">$0 — $199.999</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Plata</div>
            <div class="stat-card__value"><?= $plata ?></div>
            <div class="stat-card__change" style="color:#8e8a82">$200k — $499k</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Oro</div>
            <div class="stat-card__value"><?= $oro ?></div>
            <div class="stat-card__change" style="color:#8e8a82">$500.000+</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Asignación manual</div>
            <div class="stat-card__value"><?= $manual ?></div>
            <div class="stat-card__change" style="color:#8e8a82">por el admin</div>
        </div>
    </div>

    <?php if (empty($usuarios)): ?>
    <div class="admin-empty"><p>No hay clientes registrados.</p></div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Total comprado</th>
                    <th>Nivel automático</th>
                    <th>Membresía manual</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td>
                    <strong><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></strong>
                    <div style="font-size:0.75rem;color:#8e8a82;margin-top:2px"><?= htmlspecialchars($u['email']) ?></div>
                </td>
                <td style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.05rem;white-space:nowrap">
                    $<?= number_format((float)$u['total_gastado'], 0, ',', '.') ?>
                </td>
                <td>
                    <span class="badge <?= $tierBadge[$u['tier_auto']['key']] ?? '' ?>">
                        <?= $u['tier_auto']['label'] ?>
                    </span>
                </td>
                <td>
                    <?php if ($u['tier_manual']): ?>
                        <span class="badge <?= $tierBadge[$u['tier_manual']['key']] ?? '' ?>">
                            <?= $u['tier_manual']['label'] ?>
                        </span>
                    <?php else: ?>
                        <span style="color:#8e8a82;font-size:0.8rem">Sin asignar</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:0.8rem;color:#8e8a82;white-space:nowrap">
                    <?= !empty($u['membresia_expiracion'])
                        ? date('d/m/Y', strtotime($u['membresia_expiracion']))
                        : '—' ?>
                </td>
                <td>
                    <?php if (!empty($u['membresia_estado'])): ?>
                        <span class="badge <?= $estadoBadge[$u['membresia_estado']] ?? '' ?>">
                            <?= ucfirst($u['membresia_estado']) ?>
                        </span>
                    <?php else: ?>
                        <span style="color:#8e8a82;font-size:0.8rem">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="<?= BASE_URL ?>/admin/membresias/asignar/<?= $u['id'] ?>"
                           class="btn-admin-secondary btn-admin-sm">
                            <?= $u['membresia_id'] ? 'Editar' : 'Asignar' ?>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/cupones/regalar/<?= $u['id'] ?>?tipo=regalo_membresia"
                           class="btn-admin-secondary btn-admin-sm"
                           title="Regalar un cupón de descuento">
                            Regalar cupón
                        </a>
                        <a href="<?= BASE_URL ?>/admin/cupones/regalar/<?= $u['id'] ?>?tipo=giftcard"
                           class="btn-admin-secondary btn-admin-sm"
                           title="Regalar una gift card">
                            Gift card
                        </a>
                        <?php if ($u['membresia_id']): ?>
                        <form method="POST" action="<?= BASE_URL ?>/admin/membresias/eliminar"
                              style="display:inline"
                              onsubmit="return confirm('¿Eliminar la membresía manual de este cliente?')">
                            <input type="hidden" name="id" value="<?= $u['membresia_id'] ?>">
                            <button type="submit" class="btn-admin-danger btn-admin-sm">Quitar</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>
</main>
