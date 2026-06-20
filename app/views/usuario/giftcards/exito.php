<main>
<div class="contenedor gc-page gc-page--exito">

    <!-- ===== CABECERA ===== -->
    <div class="u-page-header" style="text-align:center">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Gift Card creada</h1>
    </div>

    <!-- ===== TARJETA GRANDE ===== -->
    <div class="gc-card-big">
        <div class="gc-card-big__inner">

            <!-- Frente -->
            <div class="gc-card-big__top">
                <span class="gc-card-big__type">Gift Card</span>
                <span class="gc-card-big__brand">Malku</span>
            </div>

            <div class="gc-card-big__amount">
                $<?= number_format($gc['monto'], 0, ',', '.') ?>
            </div>

            <div class="gc-card-big__deco"></div>

            <div class="gc-card-big__code-row">
                <span class="gc-card-big__code" id="gc-code">
                    <?= htmlspecialchars($gc['codigo']) ?>
                </span>
                <button class="gc-card-big__copy" id="gc-copy" title="Copiar código" type="button">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2"/>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                    </svg>
                    <span id="copy-label">Copiar</span>
                </button>
            </div>

            <div class="gc-card-big__meta">
                <span>Válida hasta <?= date('d/m/Y', strtotime($gc['expiracion'])) ?></span>
                <span>·</span>
                <span>Uso único</span>
            </div>

        </div>
    </div>

    <!-- ===== MENSAJE DE ESTADO ===== -->
    <div class="gc-exito-msg">
        <?php if ($gc['asignada']): ?>
        <div class="u-flash u-flash--ok" style="text-align:center;margin:0">
            La gift card fue asignada a
            <strong><?= htmlspecialchars($gc['email']) ?></strong>
            <?php if ($gc['nombre']): ?>
                (<?= htmlspecialchars($gc['nombre']) ?>)
            <?php endif; ?>.
            Aparece en sus cupones automáticamente.
        </div>
        <?php else: ?>
        <div class="gc-exito-share">
            <p>Compartí el código con quien quieras. Puede usarlo en el checkout de cualquier compra.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- ===== INSTRUCCIONES ===== -->
    <div class="u-card gc-instrucciones">
        <div class="u-card__header">
            <h3 class="u-card__title">¿Cómo usarla?</h3>
        </div>
        <ol class="gc-steps">
            <li>
                <span class="gc-steps__num">1</span>
                <span>El destinatario elige los productos que quiera en Malku.</span>
            </li>
            <li>
                <span class="gc-steps__num">2</span>
                <span>
                    En el checkout ingresa el código
                    <strong class="gc-steps__code"><?= htmlspecialchars($gc['codigo']) ?></strong>.
                </span>
            </li>
            <li>
                <span class="gc-steps__num">3</span>
                <span>
                    Se aplica el descuento de
                    <strong>$<?= number_format($gc['monto'], 0, ',', '.') ?></strong> automáticamente.
                </span>
            </li>
        </ol>
    </div>

    <!-- ===== ACCIONES ===== -->
    <div class="u-btn-row" style="justify-content:center">
        <a href="<?= BASE_URL ?>/usuario/giftcard/crear" class="u-btn u-btn--outline">Crear otra</a>
        <a href="<?= BASE_URL ?>/usuario/cupones" class="u-btn u-btn--dark">Ver mis cupones</a>
    </div>

</div>
</main>

<script>
(function () {
    const btn   = document.getElementById('gc-copy');
    const label = document.getElementById('copy-label');
    const code  = document.getElementById('gc-code');

    if (!btn || !code) return;

    btn.addEventListener('click', function () {
        navigator.clipboard.writeText(code.textContent.trim()).then(() => {
            label.textContent = '¡Copiado!';
            btn.classList.add('gc-card-big__copy--done');
            setTimeout(() => {
                label.textContent = 'Copiar';
                btn.classList.remove('gc-card-big__copy--done');
            }, 2200);
        });
    });
})();
</script>
