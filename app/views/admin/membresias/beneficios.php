<?php
$tierLabel = ['bronce' => 'Bronce', 'plata' => 'Plata', 'oro' => 'Oro'];
$tierBadge = ['bronce' => 'badge--pendiente', 'plata' => 'badge--enviado', 'oro' => 'badge--activo'];
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/membresias">Membresías</a>
        <span>›</span>
        <span>Beneficios</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Beneficios de membresía</h1>
            <p class="admin-page-subtitle">Editá los beneficios que ven los usuarios en su panel</p>
        </div>
        <a href="<?= BASE_URL ?>/admin/membresias/beneficios/crear" class="btn-admin">
            + Nuevo beneficio
        </a>
    </div>

    <?php if ($flash_ok): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="admin-flash admin-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <?php foreach (['bronce', 'plata', 'oro'] as $tier): ?>
    <div class="admin-card" style="margin-bottom:24px">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
            <div style="display:flex;align-items:center;gap:12px">
                <span class="badge <?= $tierBadge[$tier] ?>"><?= $tierLabel[$tier] ?></span>
                <span style="color:var(--text-muted);font-size:0.82rem">
                    <?= count($porTier[$tier]) ?> beneficio<?= count($porTier[$tier]) !== 1 ? 's' : '' ?>
                </span>
            </div>
            <a href="<?= BASE_URL ?>/admin/membresias/beneficios/crear?tier=<?= $tier ?>"
               class="btn-admin-secondary" style="font-size:0.78rem;padding:6px 14px">
                + Agregar
            </a>
        </div>

        <?php if (empty($porTier[$tier])): ?>
        <p style="color:var(--text-muted);font-size:0.85rem;margin:0">Sin beneficios definidos.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px">Orden</th>
                    <th style="width:36px">Icono</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th style="width:120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($porTier[$tier] as $b): ?>
                <tr>
                    <td style="text-align:center;color:var(--text-muted)"><?= (int)$b['orden'] ?></td>
                    <td style="text-align:center;font-size:1.1rem"><?= htmlspecialchars($b['icono']) ?></td>
                    <td><?= htmlspecialchars($b['titulo']) ?></td>
                    <td style="color:var(--text-muted);font-size:0.83rem">
                        <?= $b['descripcion'] ? htmlspecialchars($b['descripcion']) : '<em>—</em>' ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;align-items:center">
                            <a href="<?= BASE_URL ?>/admin/membresias/beneficios/editar/<?= $b['id'] ?>"
                               class="badge badge--enviado" style="text-decoration:none;font-size:0.75rem;cursor:pointer">
                                Editar
                            </a>
                            <form method="POST" action="<?= BASE_URL ?>/admin/membresias/beneficios/eliminar"
                                  onsubmit="return confirm('¿Eliminar este beneficio?')">
                                <input type="hidden" name="id" value="<?= $b['id'] ?>">
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
    <?php endforeach; ?>

    <div style="margin-top:8px">
        <a href="<?= BASE_URL ?>/admin/membresias" class="btn-admin-secondary">← Volver a Membresías</a>
    </div>

</div>
</main>
