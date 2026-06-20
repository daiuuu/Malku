<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Mis Pedidos</h1>
    </div>

    <div class="u-card">
        <?php if (empty($pedidos)): ?>
            <p class="u-card__empty">Todavía no realizaste ninguna compra.</p>
            <div style="text-align:center">
                <a href="<?= BASE_URL ?>/coleccion" class="u-btn u-btn--dark">Explorar la colección →</a>
            </div>
        <?php else: ?>
        <div class="u-table-wrap">
            <table class="u-table">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $p): ?>
                    <tr>
                        <td><strong>#<?= str_pad($p['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                        <td><?= date('d/m/Y', strtotime($p['fecha_pedido'])) ?></td>
                        <td><span class="u-badge u-badge--<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                        <td style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:17px">
                            $<?= number_format($p['total'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/usuario/pedidos/<?= $p['id'] ?>" class="u-btn u-btn--outline u-btn--sm">Ver detalle</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

</div>
</main>
