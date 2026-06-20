<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Mis Direcciones</h1>
    </div>

    <?php if ($flash_ok): ?>
    <div class="u-flash u-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="u-flash u-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <div style="margin-bottom:20px;display:flex;justify-content:flex-end">
        <a href="<?= BASE_URL ?>/usuario/direcciones/nueva" class="u-btn u-btn--dark">+ Nueva dirección</a>
    </div>

    <?php if (empty($direcciones)): ?>
    <div class="u-card">
        <p class="u-card__empty">No tenés direcciones guardadas todavía.</p>
        <div style="text-align:center">
            <a href="<?= BASE_URL ?>/usuario/direcciones/nueva" class="u-btn u-btn--dark">Agregar dirección</a>
        </div>
    </div>
    <?php else: ?>
    <div class="u-dir-grid">
        <?php foreach ($direcciones as $dir): ?>
        <div class="u-dir-card <?= $dir['principal'] ? 'u-dir-card--principal' : '' ?>">
            <?php if ($dir['principal']): ?>
            <span class="u-dir-card__badge">Principal</span>
            <?php endif; ?>

            <div class="u-dir-card__name"><?= htmlspecialchars($dir['nombre_recibe']) ?></div>
            <div class="u-dir-card__addr">
                <?= htmlspecialchars($dir['calle']) ?> <?= htmlspecialchars($dir['numero']) ?>
                <?php if ($dir['piso']): ?>, Piso <?= htmlspecialchars($dir['piso']) ?><?php endif; ?>
                <?php if ($dir['departamento']): ?> Depto <?= htmlspecialchars($dir['departamento']) ?><?php endif; ?>
                <br>
                <?= htmlspecialchars($dir['ciudad']) ?>, <?= htmlspecialchars($dir['provincia']) ?>
                <?php if ($dir['codigo_postal']): ?> (<?= htmlspecialchars($dir['codigo_postal']) ?>)<?php endif; ?>
                <?php if ($dir['telefono']): ?><br><?= htmlspecialchars($dir['telefono']) ?><?php endif; ?>
            </div>

            <div class="u-dir-card__actions">
                <a href="<?= BASE_URL ?>/usuario/direcciones/editar/<?= $dir['id'] ?>" class="u-btn u-btn--outline u-btn--sm">Editar</a>

                <?php if (!$dir['principal']): ?>
                <form action="<?= BASE_URL ?>/usuario/direcciones/principal" method="POST" style="display:inline">
                    <input type="hidden" name="id" value="<?= $dir['id'] ?>">
                    <button type="submit" class="u-btn u-btn--outline u-btn--sm">Marcar principal</button>
                </form>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/usuario/direcciones/eliminar" method="POST" style="display:inline"
                      onsubmit="return confirm('¿Eliminar esta dirección?')">
                    <input type="hidden" name="id" value="<?= $dir['id'] ?>">
                    <button type="submit" class="u-btn u-btn--danger u-btn--sm">Eliminar</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</main>
