<?php
/*
 * Variables esperadas:
 *   $errorCode    — código HTTP (404, 403, 500…)
 *   $errorTitulo  — título corto
 *   $errorMensaje — descripción para el usuario
 *   $errorAcciones — array de ['label' => '…', 'url' => '…', 'primary' => true/false]
 */

$acciones = $errorAcciones ?? [
    ['label' => 'Ir al inicio',      'url' => BASE_URL . '/',           'primary' => true],
    ['label' => 'Ver colección',     'url' => BASE_URL . '/coleccion',  'primary' => false],
];
?>

<main class="error-page">
    <div class="error-inner">

        <p class="error-code"><?= $errorCode ?? '?' ?></p>
        <h1 class="error-title"><?= htmlspecialchars($errorTitulo ?? 'Algo salió mal') ?></h1>
        <div class="error-divider"></div>
        <p class="error-message"><?= nl2br(htmlspecialchars($errorMensaje ?? '')) ?></p>

        <div class="error-actions">
            <?php foreach ($acciones as $accion): ?>
            <a href="<?= $accion['url'] ?>"
               class="error-btn <?= $accion['primary'] ? 'error-btn--primary' : 'error-btn--secondary' ?>">
                <?= htmlspecialchars($accion['label']) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <?php if (($errorCode ?? 0) === 404): ?>
        <p class="error-hint">
            Si escribiste la URL a mano, revisá que esté bien escrita.<br>
            Si seguiste un enlace, es posible que la página haya sido movida.
        </p>
        <?php endif; ?>

    </div>
</main>
