<main>
<div class="contenedor gc-page gc-page--exito">

    <!-- ===== CABECERA ===== -->
    <div class="u-page-header" style="text-align:center">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">El pago no se completó</h1>
    </div>

    <!-- ===== CARD DE ERROR ===== -->
    <div class="gc-error-card">
        <div class="gc-error-card__icon">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
        </div>
        <p class="gc-error-card__msg">
            Hubo un problema al procesar el pago o lo cancelaste antes de completarlo.<br>
            Tu gift card quedó guardada pero <strong>no está activa</strong> todavía.
        </p>
    </div>

    <!-- ===== OPCIONES ===== -->
    <div class="u-card gc-instrucciones">
        <div class="u-card__header">
            <h3 class="u-card__title">¿Qué podés hacer?</h3>
        </div>
        <ol class="gc-steps">
            <li>
                <span class="gc-steps__num">1</span>
                <span><strong>Intentar de nuevo:</strong> creá una nueva gift card con los mismos datos.</span>
            </li>
            <li>
                <span class="gc-steps__num">2</span>
                <span><strong>Pagar en efectivo:</strong> elegí la opción de efectivo para coordinar el pago por WhatsApp.</span>
            </li>
            <li>
                <span class="gc-steps__num">3</span>
                <span><strong>Contactanos</strong> si creés que hubo un error con el pago.</span>
            </li>
        </ol>
    </div>

    <!-- ===== ACCIONES ===== -->
    <div class="u-btn-row" style="justify-content:center">
        <a href="<?= BASE_URL ?>/usuario/giftcard/crear" class="u-btn u-btn--dark">Intentar de nuevo</a>
        <a href="<?= BASE_URL ?>/contacto" class="u-btn u-btn--outline">Contactar</a>
    </div>

</div>
</main>

<style>
.gc-error-card {
    max-width: 520px;
    margin: 0 auto 32px;
    text-align: center;
}
.gc-error-card__icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #fdf0f0;
    border: 2px solid #e8c5c5;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #b94040;
}
.gc-error-card__msg {
    color: var(--u-dark);
    font-size: 0.95rem;
    line-height: 1.6;
}
</style>
