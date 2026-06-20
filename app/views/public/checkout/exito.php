<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="checkout-exito-page">
<div class="contenedor checkout-exito-inner">

    <div class="checkout-exito-icon">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>

    <h1 class="checkout-exito-titulo">¡Compra realizada!</h1>

    <p class="checkout-exito-sub">
        Gracias por elegir Malku. Vamos a procesar tu pedido
        y te avisaremos cuando esté en camino.
    </p>

    <a href="<?= BASE_URL ?>/coleccion" class="checkout-exito-btn">Seguir comprando</a>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
