<?php
// $beneficiosTier is passed from the controller (array keyed by tier)
$tierBenefits = $beneficiosTier ?? [];

// Fallback so the template never breaks if no rows in DB yet
foreach (['bronce', 'plata', 'oro'] as $_t) {
    if (!isset($tierBenefits[$_t])) $tierBenefits[$_t] = [];
}

$progressPct = 0;
if ($tierKey === 'bronce') {
    $progressPct = min(100, ($totalGastado / 200000) * 100);
} elseif ($tierKey === 'plata') {
    $progressPct = min(100, (($totalGastado - 200000) / 300000) * 100);
} else {
    $progressPct = 100;
}
?>
<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Membresía Malku</h1>
    </div>

    <!-- TIER HERO -->
    <div class="u-tier-hero" style="margin-bottom:24px">
        <span class="u-tier-hero__tier">Nivel actual</span>
        <h2 class="u-tier-hero__name"><?= $tier ?></h2>
        <p class="u-tier-hero__sub">Total acumulado: $<?= number_format($totalGastado, 0, ',', '.') ?></p>

        <?php if ($siguiente): ?>
        <div class="u-tier-hero__progress">
            <div class="u-tier-hero__bar-bg">
                <div class="u-tier-hero__bar-fill" style="width:<?= round($progressPct) ?>%"></div>
            </div>
            <p class="u-tier-hero__progress-text">
                Te faltan $<?= number_format($faltante, 0, ',', '.') ?> para alcanzar el nivel <strong><?= $siguiente ?></strong>
            </p>
        </div>
        <?php else: ?>
        <p class="u-tier-hero__sub" style="margin-top:12px;color:var(--u-gold)">¡Alcanzaste el nivel más alto!</p>
        <?php endif; ?>
    </div>

    <!-- BENEFICIOS -->
    <div class="u-card" style="margin-bottom:24px">
        <div class="u-card__header">
            <h3 class="u-card__title">Tus beneficios <?= $tier ?></h3>
        </div>
        <div class="u-benefits-grid">
            <?php if (empty($tierBenefits[$tierKey])): ?>
            <p style="color:var(--u-dark);opacity:.6;font-size:0.9rem">Sin beneficios definidos aún.</p>
            <?php else: ?>
            <?php foreach ($tierBenefits[$tierKey] as $b): ?>
            <div class="u-benefit-card">
                <div class="u-benefit-card__icon"><?= htmlspecialchars($b['icono'] ?? $b['icon'] ?? '✦') ?></div>
                <div class="u-benefit-card__title"><?= htmlspecialchars($b['titulo'] ?? $b['title'] ?? '') ?></div>
                <div class="u-benefit-card__desc"><?= htmlspecialchars($b['descripcion'] ?? $b['desc'] ?? '') ?></div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- NIVELES -->
    <div class="u-card">
        <div class="u-card__header">
            <h3 class="u-card__title">Estructura de niveles</h3>
        </div>
        <div class="u-table-wrap">
            <table class="u-table">
                <thead>
                    <tr>
                        <th>Nivel</th>
                        <th>Compras acumuladas</th>
                        <th>Beneficio principal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr <?= $tierKey === 'bronce' ? 'style="background:#fef9f0"' : '' ?>>
                        <td><strong>Bronce</strong> <?= $tierKey === 'bronce' ? '← estás aquí' : '' ?></td>
                        <td>$0 — $199.999</td>
                        <td>Acceso al catálogo y favoritos</td>
                    </tr>
                    <tr <?= $tierKey === 'plata' ? 'style="background:#fef9f0"' : '' ?>>
                        <td><strong>Plata</strong> <?= $tierKey === 'plata' ? '← estás aquí' : '' ?></td>
                        <td>$200.000 — $499.999</td>
                        <td>Envío bonificado + acceso anticipado</td>
                    </tr>
                    <tr <?= $tierKey === 'oro' ? 'style="background:#fef9f0"' : '' ?>>
                        <td><strong>Oro</strong> <?= $tierKey === 'oro' ? '← estás aquí' : '' ?></td>
                        <td>$500.000+</td>
                        <td>Envío siempre gratis + atención VIP</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>
