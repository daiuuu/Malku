<?php
$origenLabel = [
    'manual'           => 'Promoción',
    'regalo_membresia' => 'Regalo',
    'giftcard'         => 'Gift card',
];
?>
<main>
<div class="contenedor">

    <div class="u-page-header" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem">
        <div>
            <span class="u-page-header__label">Mi cuenta</span>
            <h1 class="u-page-header__title">Mis cupones</h1>
        </div>
        <a href="<?= BASE_URL ?>/usuario/giftcard/crear" class="u-btn u-btn--outline" style="margin-top:.25rem">
            🎁 Crear Gift Card
        </a>
    </div>

    <?php if (empty($cupones)): ?>

    <div class="u-card" style="text-align:center;padding:3rem 2rem">
        <div style="font-size:2rem;margin-bottom:12px">🎁</div>
        <p style="color:var(--u-dark);opacity:.7;margin:0">
            Todavía no tenés cupones disponibles.<br>
            <span style="font-size:0.88rem">Los cupones y gift cards que te regalen aparecerán acá.</span>
        </p>
    </div>

    <?php else: ?>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;margin-bottom:32px">
        <?php foreach ($cupones as $c): ?>
        <?php
        $vencido = $c['fecha_expiracion'] && $c['fecha_expiracion'] < date('Y-m-d');
        $agotado = $c['usos_maximos'] !== null && $c['usos_actuales'] >= $c['usos_maximos'];
        $valido  = $c['activo'] && !$vencido && !$agotado;
        ?>
        <div class="u-card" style="padding:0;overflow:hidden;opacity:<?= $valido ? '1' : '.6' ?>">

            <!-- Cabecera de color según tipo -->
            <div style="
                background: <?= $c['origen'] === 'giftcard' ? 'var(--u-gold)' : 'var(--u-green)' ?>;
                color: #fff;
                padding: 14px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            ">
                <span style="font-size:0.75rem;text-transform:uppercase;letter-spacing:1px;opacity:.85">
                    <?= $origenLabel[$c['origen']] ?? 'Cupón' ?>
                </span>
                <?php if (!$valido): ?>
                <span style="font-size:0.72rem;background:rgba(0,0,0,.2);padding:2px 8px;border-radius:20px">
                    <?= !$c['activo'] ? 'Inactivo' : ($vencido ? 'Vencido' : 'Agotado') ?>
                </span>
                <?php endif; ?>
            </div>

            <div style="padding:18px 20px">

                <!-- Código -->
                <div style="font-size:1.5rem;font-family:'Cormorant Garamond',serif;font-weight:600;letter-spacing:2px;margin-bottom:8px">
                    <?= htmlspecialchars($c['codigo']) ?>
                </div>

                <!-- Valor -->
                <div style="font-size:1.1rem;margin-bottom:12px;color:var(--u-dark)">
                    <?php if ($c['tipo'] === 'porcentaje'): ?>
                        <strong><?= number_format($c['valor'], 0) ?>% de descuento</strong>
                    <?php else: ?>
                        <strong>$<?= number_format($c['valor'], 0, ',', '.') ?> de descuento</strong>
                    <?php endif; ?>
                </div>

                <!-- Detalles -->
                <div style="font-size:0.8rem;color:var(--u-dark);opacity:.65;display:flex;flex-direction:column;gap:4px">
                    <?php if ((float)$c['minimo_compra'] > 0): ?>
                    <span>Mínimo de compra: $<?= number_format($c['minimo_compra'], 0, ',', '.') ?></span>
                    <?php endif; ?>
                    <?php if ($c['fecha_expiracion']): ?>
                    <span>Vence: <?= date('d/m/Y', strtotime($c['fecha_expiracion'])) ?></span>
                    <?php else: ?>
                    <span>Sin vencimiento</span>
                    <?php endif; ?>
                    <?php if ($c['usos_maximos'] === '1' || $c['usos_maximos'] === 1): ?>
                    <span>Uso único</span>
                    <?php endif; ?>
                </div>

                <?php if ($valido): ?>
                <div style="margin-top:16px;padding:10px 14px;background:#f8f7f5;border-radius:8px;font-size:0.82rem;color:var(--u-dark)">
                    Ingresá este código en el checkout para aplicarlo a tu próxima compra.
                </div>
                <?php endif; ?>

            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>

    <div>
        <a href="<?= BASE_URL ?>/coleccion" class="u-btn u-btn--dark">Ver colección</a>
    </div>

</div>
</main>
