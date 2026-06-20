<?php
$origenLabel = [
    'manual'            => 'Manual',
    'regalo_membresia'  => 'Regalo',
    'giftcard'          => 'Gift card',
];
$origenBadge = [
    'manual'            => '',
    'regalo_membresia'  => 'badge--enviado',
    'giftcard'          => 'badge--activo',
];

$total    = count($cupones);
$activos  = count(array_filter($cupones, fn($c) => $c['activo']));
$personal = count(array_filter($cupones, fn($c) => $c['usuario_id']));
$publicos = $total - $personal;
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Cupones</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Cupones & Gift cards</h1>
            <p class="admin-page-subtitle"><?= $total ?> cupones en total</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/cupones/crear" class="btn-admin">+ Nuevo cupón</a>
    </div>

    <?php if ($flash_ok): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stat-cards" style="margin-bottom:28px">
        <div class="stat-card">
            <div class="stat-card__label">Total</div>
            <div class="stat-card__value"><?= $total ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Activos</div>
            <div class="stat-card__value"><?= $activos ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Personales</div>
            <div class="stat-card__value"><?= $personal ?></div>
            <div class="stat-card__change" style="color:#8e8a82">Regalos / gift cards</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Públicos</div>
            <div class="stat-card__value"><?= $publicos ?></div>
        </div>
    </div>

    <div class="admin-card">
        <?php if (empty($cupones)): ?>
        <div class="admin-empty" style="padding:3rem 2rem">
            <p>No hay cupones creados aún.</p>
            <a href="<?= BASE_URL ?>/admin/cupones/crear" class="btn-admin">Crear primer cupón</a>
        </div>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Origen</th>
                    <th>Asignado a</th>
                    <th>Usos</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cupones as $c): ?>
                <?php
                $vencido  = $c['fecha_expiracion'] && $c['fecha_expiracion'] < date('Y-m-d');
                $agotado  = $c['usos_maximos'] !== null && $c['usos_actuales'] >= $c['usos_maximos'];
                $estadoBadge = !$c['activo'] ? 'badge--cancelado'
                    : ($vencido || $agotado ? 'badge--pendiente' : 'badge--activo');
                $estadoLabel = !$c['activo'] ? 'Inactivo'
                    : ($vencido ? 'Vencido' : ($agotado ? 'Agotado' : 'Activo'));
                ?>
                <tr>
                    <td>
                        <code style="font-size:0.82rem;background:#f1f0ed;padding:2px 6px;border-radius:4px">
                            <?= htmlspecialchars($c['codigo']) ?>
                        </code>
                    </td>
                    <td style="color:var(--text-muted);font-size:0.83rem">
                        <?= $c['tipo'] === 'porcentaje' ? 'Porcentaje' : 'Monto fijo' ?>
                    </td>
                    <td>
                        <?php if ($c['tipo'] === 'porcentaje'): ?>
                            <strong><?= number_format($c['valor'], 0) ?>%</strong>
                        <?php else: ?>
                            <strong>$<?= number_format($c['valor'], 0, ',', '.') ?></strong>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($c['origen'] !== 'manual'): ?>
                        <span class="badge <?= $origenBadge[$c['origen']] ?>">
                            <?= $origenLabel[$c['origen']] ?>
                        </span>
                        <?php else: ?>
                        <span style="color:var(--text-muted);font-size:0.82rem">Manual</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:0.83rem">
                        <?php if ($c['nombre']): ?>
                        <div><?= htmlspecialchars($c['nombre'] . ' ' . $c['apellido']) ?></div>
                        <div style="color:var(--text-muted)"><?= htmlspecialchars($c['email']) ?></div>
                        <?php else: ?>
                        <span style="color:var(--text-muted)">Público</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;font-size:0.83rem">
                        <?= $c['usos_actuales'] ?> / <?= $c['usos_maximos'] ?? '∞' ?>
                    </td>
                    <td style="font-size:0.83rem;color:<?= $vencido ? '#c0392b' : 'var(--text-muted)' ?>">
                        <?= $c['fecha_expiracion']
                            ? date('d/m/Y', strtotime($c['fecha_expiracion']))
                            : '—' ?>
                    </td>
                    <td><span class="badge <?= $estadoBadge ?>"><?= $estadoLabel ?></span></td>
                    <td>
                        <div style="display:flex;gap:8px;align-items:center">
                            <a href="<?= BASE_URL ?>/admin/cupones/editar/<?= $c['id'] ?>"
                               class="badge badge--enviado" style="text-decoration:none;font-size:0.75rem">
                                Editar
                            </a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/cupones/eliminar"
                                  onsubmit="return confirm('¿Eliminar el cupón <?= htmlspecialchars($c['codigo'], ENT_QUOTES) ?>?')">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <button type="submit" class="badge badge--cancelado"
                                        style="border:none;cursor:pointer;font-size:0.75rem;background:none">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</div>
</main>
