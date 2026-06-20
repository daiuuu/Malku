<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Stock</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Gestión de stock</h1>
            <p class="admin-page-subtitle">Ajustá el inventario de cada producto.</p>
        </div>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <?php if (empty($productos)): ?>
    <div class="admin-empty"><p>No hay productos cargados.</p></div>
    <?php else: ?>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Stock actual</th>
                    <th>Estado</th>
                    <th>Ajustar</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $p): ?>
            <tr>
                <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                <td style="font-size:0.82rem;color:#8e8a82"><?= htmlspecialchars($p['categoria_nombre'] ?? '—') ?></td>
                <td>
                    <?php
                    $s = (int)$p['stock'];
                    if ($s === 0)      echo '<span class="stock-dot stock-dot--out">'      . $s . ' unid.</span>';
                    elseif ($s <= 3)   echo '<span class="stock-dot stock-dot--critical">' . $s . ' unid.</span>';
                    elseif ($s <= 8)   echo '<span class="stock-dot stock-dot--low">'      . $s . ' unid.</span>';
                    else               echo '<span class="stock-dot stock-dot--ok">'       . $s . ' unid.</span>';
                    ?>
                </td>
                <td><span class="badge badge--<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span></td>
                <td>
                    <form method="POST" action="<?= BASE_URL ?>/admin/stock/ajustar" style="display:flex;gap:0.5rem;align-items:center">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <input type="number" name="cantidad" value="0" style="width:70px;padding:0.3rem 0.5rem;border:1px solid rgba(0,0,0,.12);border-radius:4px;font-family:inherit;font-size:0.82rem" placeholder="±">
                        <button type="submit" class="btn-admin-secondary btn-admin-sm">Ajustar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p class="form-hint" style="margin-top:0.75rem">Ingresá un número positivo para sumar stock o negativo para restar.</p>
    <?php endif; ?>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
