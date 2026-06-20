<?php
$montos    = [5000, 10000, 20000, 50000];
$montoPost = (float)($_POST['monto'] ?? 0);
?>

<main>
<div class="contenedor gc-page">

    <!-- ===== CABECERA ===== -->
    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Crear Gift Card</h1>
    </div>

    <?php if ($flash_error ?? null): ?>
    <div class="u-flash u-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <div class="gc-layout">

        <!-- ===== COLUMNA IZQUIERDA — FORMULARIO ===== -->
        <div class="gc-col-form">

            <form method="POST" action="<?= BASE_URL ?>/usuario/giftcard/generar" id="gc-form">

                <!-- SECCIÓN 1: MONTO -->
                <div class="u-card gc-card-section">
                    <div class="u-card__header">
                        <h3 class="u-card__title">¿Cuánto querés regalar?</h3>
                    </div>

                    <div class="gc-montos">
                        <?php foreach ($montos as $m): ?>
                        <label class="gc-monto-opt">
                            <input
                                type="radio"
                                name="monto"
                                value="<?= $m ?>"
                                <?= $montoPost === (float)$m || !$montoPost && $m === 10000 ? 'checked' : '' ?>
                            >
                            <span>
                                <em class="gc-monto-opt__val">$<?= number_format($m, 0, ',', '.') ?></em>
                            </span>
                        </label>
                        <?php endforeach; ?>

                        <label class="gc-monto-opt">
                            <input type="radio" name="monto" value="custom" id="radio-custom">
                            <span>
                                <em class="gc-monto-opt__val">Otro</em>
                            </span>
                        </label>
                    </div>

                    <div class="gc-custom-wrap" id="custom-amount-wrap">
                        <div class="u-form-group">
                            <label for="custom-amount">Monto personalizado (mínimo $1.000)</label>
                            <div class="gc-prefix-wrap">
                                <span class="gc-prefix">$</span>
                                <input
                                    type="number"
                                    id="custom-amount"
                                    name="monto_custom"
                                    min="1000"
                                    step="500"
                                    placeholder="Ej: 15.000"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: DESTINATARIO -->
                <div class="u-card gc-card-section">
                    <div class="u-card__header">
                        <h3 class="u-card__title">¿Para quién es?</h3>
                        <span class="u-card__link" style="cursor:default">Opcional</span>
                    </div>

                    <div class="u-form-group u-form-group--full">
                        <label for="email_destinatario">Email del destinatario</label>
                        <input
                            type="email"
                            id="email_destinatario"
                            name="email_destinatario"
                            placeholder="ejemplo@email.com"
                            value="<?= htmlspecialchars($_POST['email_destinatario'] ?? '') ?>"
                        >
                    </div>
                    <p class="gc-field-hint">
                        Si el email está registrado en Malku, la gift card aparecerá automáticamente en sus cupones. Si no, compartís el código vos.
                    </p>
                </div>

                <!-- SECCIÓN 3: MENSAJE -->
                <div class="u-card gc-card-section">
                    <div class="u-card__header">
                        <h3 class="u-card__title">Mensaje personal</h3>
                        <span class="u-card__link" style="cursor:default">Opcional</span>
                    </div>

                    <div class="u-form-group u-form-group--full">
                        <label for="mensaje">Tu mensaje</label>
                        <textarea
                            id="mensaje"
                            name="mensaje"
                            rows="3"
                            placeholder="Escribí algo lindo para acompañar el regalo…"
                        ><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>
                    </div>
                </div>

                <!-- SECCIÓN 4: MÉTODO DE PAGO -->
                <div class="u-card gc-card-section">
                    <div class="u-card__header">
                        <h3 class="u-card__title">Método de pago</h3>
                    </div>

                    <div class="gc-pago-opts">
                        <label class="gc-pago-opt">
                            <input type="radio" name="metodo_pago" value="tarjeta" id="pago-tarjeta" checked>
                            <span class="gc-pago-opt__inner">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                <span>Tarjeta de<br>crédito / débito</span>
                            </span>
                        </label>

                        <label class="gc-pago-opt">
                            <input type="radio" name="metodo_pago" value="mercadopago" id="pago-mp">
                            <span class="gc-pago-opt__inner">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5L16 9"/></svg>
                                <span>Mercado<br>Pago</span>
                            </span>
                        </label>

                        <label class="gc-pago-opt">
                            <input type="radio" name="metodo_pago" value="efectivo" id="pago-efectivo">
                            <span class="gc-pago-opt__inner">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M6 12h.01M18 12h.01"/></svg>
                                <span>Efectivo<br>(WhatsApp)</span>
                            </span>
                        </label>
                    </div>

                    <p class="gc-field-hint" id="pago-hint">
                        Vas a ser redirigido a Mercado Pago para pagar con tarjeta de forma segura.
                    </p>
                </div>

                <!-- ACCIONES -->
                <div class="u-btn-row">
                    <button type="submit" class="u-btn u-btn--dark" id="gc-submit-btn">Pagar con Mercado Pago</button>
                    <a href="<?= BASE_URL ?>/usuario/cupones" class="u-btn u-btn--outline">Cancelar</a>
                </div>

            </form>

        </div>

        <!-- ===== COLUMNA DERECHA — PREVIEW ===== -->
        <div class="gc-col-preview">
            <div class="gc-preview-sticky">
                <p class="gc-preview-label">Vista previa</p>
                <div class="gc-preview-card">
                    <div class="gc-preview-card__top">
                        <span class="gc-preview-card__type">Gift Card</span>
                        <span class="gc-preview-card__brand">Malku</span>
                    </div>
                    <div class="gc-preview-card__amount" id="preview-amount">
                        $<?= number_format(10000, 0, ',', '.') ?>
                    </div>
                    <div class="gc-preview-card__deco"></div>
                    <div class="gc-preview-card__code">GIFT — ??????</div>
                    <div class="gc-preview-card__meta">
                        <span>Válida por 1 año</span>
                        <span>Uso único</span>
                    </div>
                </div>
                <p class="gc-preview-note">
                    El código se genera al confirmar.
                </p>
            </div>
        </div>

    </div><!-- /.gc-layout -->

</div>
</main>

<style>
.gc-pago-opts {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 4px;
}
.gc-pago-opt {
    display: flex;
}
.gc-pago-opt input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}
.gc-pago-opt__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 18px 10px 14px;
    border: 2px solid #e0dcd6;
    border-radius: 10px;
    cursor: pointer;
    text-align: center;
    font-size: 0.8rem;
    line-height: 1.35;
    color: var(--u-dark);
    transition: border-color .2s, background .2s;
    width: 100%;
}
.gc-pago-opt input:checked + .gc-pago-opt__inner {
    border-color: var(--u-dark);
    background: #f5f3f0;
}
.gc-pago-opt__inner:hover {
    border-color: #aaa;
}
.gc-pago-opt__inner svg {
    opacity: .75;
    flex-shrink: 0;
}
.gc-pago-opt input:checked + .gc-pago-opt__inner svg {
    opacity: 1;
}
@media (max-width: 560px) {
    .gc-pago-opts { grid-template-columns: 1fr; }
    .gc-pago-opt__inner { flex-direction: row; gap: 12px; text-align: left; }
}
</style>

<script>
(function () {
    const radios  = document.querySelectorAll('input[name="monto"]');
    const custom  = document.getElementById('radio-custom');
    const wrap    = document.getElementById('custom-amount-wrap');
    const input   = document.getElementById('custom-amount');
    const preview = document.getElementById('preview-amount');
    const pagoRadios = document.querySelectorAll('input[name="metodo_pago"]');
    const submitBtn  = document.getElementById('gc-submit-btn');
    const pagoHint   = document.getElementById('pago-hint');

    const fmt = (n) =>
        '$' + new Intl.NumberFormat('es-AR', { maximumFractionDigits: 0 }).format(n);

    const pagoLabels = {
        tarjeta:      { btn: 'Pagar con Mercado Pago', hint: 'Vas a ser redirigido a Mercado Pago para pagar con tarjeta de forma segura.' },
        mercadopago:  { btn: 'Pagar con Mercado Pago', hint: 'Vas a ser redirigido a Mercado Pago para pagar con tu wallet.' },
        efectivo:     { btn: 'Coordinar pago en efectivo', hint: 'Te vamos a mostrar un botón de WhatsApp para coordinar el pago en efectivo.' },
    };

    function updatePreview() {
        if (custom.checked) {
            const v = parseFloat(input.value) || 0;
            preview.textContent = v > 0 ? fmt(v) : '$—';
            wrap.style.display = 'block';
        } else {
            const checked = document.querySelector('input[name="monto"]:checked');
            preview.textContent = checked ? fmt(checked.value) : '$—';
            wrap.style.display = 'none';
        }
    }

    function updatePagoUI() {
        const sel = document.querySelector('input[name="metodo_pago"]:checked');
        if (!sel) return;
        const info = pagoLabels[sel.value] || pagoLabels.tarjeta;
        submitBtn.textContent = info.btn;
        pagoHint.textContent  = info.hint;
    }

    radios.forEach(r => r.addEventListener('change', updatePreview));
    input.addEventListener('input', updatePreview);
    pagoRadios.forEach(r => r.addEventListener('change', updatePagoUI));

    document.getElementById('gc-form').addEventListener('submit', function (e) {
        if (custom.checked) {
            const v = parseFloat(input.value) || 0;
            if (v < 1000) {
                e.preventDefault();
                input.focus();
                input.style.borderColor = '#c0392b';
                setTimeout(() => { input.style.borderColor = ''; }, 2000);
                return;
            }
            custom.value = v;
        }
    });

    updatePreview();
    updatePagoUI();
})();
</script>
