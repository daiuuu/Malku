<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Mis Favoritos</h1>
    </div>

    <?php if ($flash_ok): ?>
    <div class="u-flash u-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>

    <?php if (empty($favoritos)): ?>
    <div class="u-card">
        <p class="u-card__empty">No guardaste ningún producto en favoritos todavía.</p>
        <div style="text-align:center">
            <a href="<?= BASE_URL ?>/coleccion" class="u-btn u-btn--dark">Explorar la colección →</a>
        </div>
    </div>
    <?php else: ?>
    <div class="u-fav-grid">
        <?php foreach ($favoritos as $fav): ?>
        <div class="u-fav-card">
            <div class="u-fav-card__img">
                <?php if (!empty($fav['imagen_principal'])): ?>
                <img src="<?= BASE_URL ?>/assets/img/productos/<?= htmlspecialchars($fav['imagen_principal']) ?>" alt="<?= htmlspecialchars($fav['nombre']) ?>">
                <?php else: ?>
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:40px">M</div>
                <?php endif; ?>
            </div>
            <div class="u-fav-card__body">
                <div class="u-fav-card__name"><?= htmlspecialchars($fav['nombre']) ?></div>
                <div class="u-fav-card__price">$<?= number_format($fav['precio'], 0, ',', '.') ?></div>
                <div class="u-fav-card__actions">
                    <a href="<?= BASE_URL ?>/producto/<?= htmlspecialchars($fav['slug']) ?>" class="u-btn u-btn--dark u-btn--sm">Ver producto</a>
                    <form action="<?= BASE_URL ?>/usuario/favoritos/eliminar" method="POST" style="display:inline">
                        <input type="hidden" name="id" value="<?= $fav['favorito_id'] ?>">
                        <button type="submit" class="u-btn u-btn--outline u-btn--sm" title="Quitar de favoritos">✕</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</main>
