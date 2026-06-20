<?php
$gc         = $_SESSION['gc_pendiente'] ?? [];
$monto      = (float)($gc['monto']    ?? 0);
$codigo     = $gc['codigo']            ?? '';
$expiracion = $gc['expiracion']        ?? '';

$montoFmt   = '$' . number_format($monto, 0, ',', '.');

$waMsg = rawurlencode(
    "¡Hola! Vengo de Malku y quiero pagar una gift card en efectivo.\n"
    . "Monto: {$montoFmt} ARS\n"
    . "Código de referencia: {$codigo}"
);
$waUrl = 'https://wa.me/' . WHATSAPP_NUMERO . '?text=' . $waMsg;
?>

<main>
<div class="contenedor gc-page gc-page--exito">

    <!-- ===== CABECERA ===== -->
    <div class="u-page-header" style="text-align:center">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Coordiná el pago</h1>
    </div>

    <!-- ===== TARJETA DE REFERENCIA ===== -->
    <div class="gc-card-big">
        <div class="gc-card-big__inner">
            <div class="gc-card-big__top">
                <span class="gc-card-big__type">Gift Card</span>
                <span class="gc-card-big__brand">Malku</span>
            </div>

            <div class="gc-card-big__amount">
                <?= $montoFmt ?>
            </div>

            <div class="gc-card-big__deco"></div>

            <div class="gc-card-big__code-row">
                <span class="gc-card-big__code" id="gc-code">
                    <?= htmlspecialchars($codigo) ?>
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
                <?php if ($expiracion): ?>
                <span>Válida hasta <?= date('d/m/Y', strtotime($expiracion)) ?></span>
                <span>·</span>
                <?php endif; ?>
                <span>Pendiente de pago</span>
            </div>
        </div>
    </div>

    <!-- ===== INSTRUCCIONES ===== -->
    <div class="u-card gc-instrucciones">
        <div class="u-card__header">
            <h3 class="u-card__title">¿Cómo pagar en efectivo?</h3>
        </div>
        <ol class="gc-steps">
            <li>
                <span class="gc-steps__num">1</span>
                <span>Tocá el botón de WhatsApp de abajo para abrir el chat con Malku.</span>
            </li>
            <li>
                <span class="gc-steps__num">2</span>
                <span>
                    El mensaje ya viene pre-cargado con tu código
                    <strong class="gc-steps__code"><?= htmlspecialchars($codigo) ?></strong>
                    y el monto <strong><?= $montoFmt ?></strong>.
                </span>
            </li>
            <li>
                <span class="gc-steps__num">3</span>
                <span>Coordinamos el pago y activamos tu gift card manualmente.</span>
            </li>
            <li>
                <span class="gc-steps__num">4</span>
                <span>Una vez confirmado, la gift card aparece activa en <strong>Mis Cupones</strong>.</span>
            </li>
        </ol>
    </div>

    <!-- ===== CTA WHATSAPP ===== -->
    <div class="u-btn-row" style="justify-content:center; flex-direction: column; align-items: center; gap: 12px;">
        <a
            href="<?= htmlspecialchars($waUrl) ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="u-btn gc-btn-wa"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="flex-shrink:0">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.527 5.845L.057 23.882l6.196-1.622A11.956 11.956 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.006-1.37l-.36-.214-3.727.977.995-3.63-.234-.373A9.818 9.818 0 0 1 12 2.182c5.422 0 9.818 4.396 9.818 9.818 0 5.422-4.396 9.818-9.818 9.818z"/>
            </svg>
            Coordinar pago por WhatsApp
        </a>
        <a href="<?= BASE_URL ?>/usuario/cupones" class="u-btn u-btn--outline">Ver mis cupones</a>
    </div>

</div>
</main>

<style>
.gc-btn-wa {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #25d366;
    color: #fff;
    border: none;
    font-size: 0.95rem;
    padding: 13px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background .2s;
}
.gc-btn-wa:hover { background: #1ebe5c; color: #fff; }
</style>

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
