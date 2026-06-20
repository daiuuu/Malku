<?php
// $cupon      = existing record (edit) or null (create)
// $usuario    = recipient user (gifting flow) or null
// $origenPre  = 'manual' | 'regalo_membresia' | 'giftcard'
// $codigoSugerido = pre-filled code suggestion

$esEdicion  = !empty($cupon);
$accion     = $esEdicion
    ? BASE_URL . '/admin/cupones/actualizar'
    : BASE_URL . '/admin/cupones/guardar';

$origenPre      = $origenPre ?? ($cupon['origen'] ?? 'manual');
$esRegalo       = in_array($origenPre, ['regalo_membresia', 'giftcard']);
$esGiftcard     = $origenPre === 'giftcard';

$backUrl = $esRegalo && !$esEdicion
    ? BASE_URL . '/admin/membresias'
    : BASE_URL . '/admin/cupones';

$tierLabels = [
    'manual'           => 'Manual / Promocional',
    'regalo_membresia' => 'Regalo por membresía',
    'giftcard'         => 'Gift card',
];
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <?php if ($esRegalo && !$esEdicion): ?>
        <a href="<?= BASE_URL ?>/admin/membresias">Membresías</a>
        <?php else: ?>
        <a href="<?= BASE_URL ?>/admin/cupones">Cupones</a>
        <?php endif; ?>
        <span>›</span>
        <span>
            <?php if ($esEdicion): ?>Editar
            <?php elseif ($esGiftcard): ?>Nueva gift card
            <?php elseif ($esRegalo): ?>Regalar cupón
            <?php else: ?>Nuevo cupón
            <?php endif; ?>
        </span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">
                <?php if ($esEdicion): ?>Editar cupón
                <?php elseif ($esGiftcard): ?>Nueva gift card
                <?php elseif ($esRegalo): ?>Regalar cupón
                <?php else: ?>Nuevo cupón / promoción
                <?php endif; ?>
            </h1>
            <?php if ($usuario): ?>
            <p class="admin-page-subtitle">
                Para: <strong><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></strong>
                — <?= htmlspecialchars($usuario['email']) ?>
            </p>
            <?php else: ?>
            <p class="admin-page-subtitle">Los cupones públicos pueden usarlos todos los clientes.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="admin-card" style="max-width:600px">

        <form method="POST" action="<?= $accion ?>" class="admin-form">

            <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= $cupon['id'] ?>">
            <?php endif; ?>

            <?php if ($usuario): ?>
            <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
            <input type="hidden" name="redirect"    value="membresias">
            <?php endif; ?>

            <input type="hidden" name="origen" value="<?= htmlspecialchars($origenPre) ?>">

            <!-- Código -->
            <div class="form-field">
                <label>Código del cupón <span style="color:#c0392b">*</span></label>
                <input
                    type="text"
                    name="codigo"
                    value="<?= htmlspecialchars($cupon['codigo'] ?? $codigoSugerido ?? '') ?>"
                    required
                    maxlength="50"
                    placeholder="Ej: VERANO25"
                    style="text-transform:uppercase;letter-spacing:1px"
                >
                <span style="font-size:0.78rem;color:var(--text-muted)">
                    Solo letras, números y guiones. Se convierte a mayúsculas automáticamente.
                </span>
            </div>

            <div class="form-row">

                <!-- Tipo -->
                <div class="form-field">
                    <label>Tipo de descuento</label>
                    <select name="tipo" id="tipo-select">
                        <option value="porcentaje"
                            <?= ($cupon['tipo'] ?? ($esGiftcard ? 'monto_fijo' : 'porcentaje')) === 'porcentaje' ? 'selected' : '' ?>>
                            Porcentaje (%)
                        </option>
                        <option value="monto_fijo"
                            <?= ($cupon['tipo'] ?? ($esGiftcard ? 'monto_fijo' : '')) === 'monto_fijo' ? 'selected' : '' ?>>
                            Monto fijo ($)
                        </option>
                    </select>
                </div>

                <!-- Valor -->
                <div class="form-field">
                    <label>Valor <span style="color:#c0392b">*</span></label>
                    <input
                        type="number"
                        name="valor"
                        value="<?= htmlspecialchars($cupon['valor'] ?? '') ?>"
                        required
                        min="0"
                        step="0.01"
                        placeholder="Ej: 15 (%) o 5000 ($)"
                    >
                </div>

            </div>

            <div class="form-row">

                <!-- Mínimo de compra -->
                <div class="form-field">
                    <label>Mínimo de compra ($)</label>
                    <input
                        type="number"
                        name="minimo_compra"
                        value="<?= htmlspecialchars($cupon['minimo_compra'] ?? '0') ?>"
                        min="0"
                        placeholder="0 = sin mínimo"
                    >
                </div>

                <!-- Usos máximos -->
                <div class="form-field">
                    <label>Usos máximos</label>
                    <input
                        type="number"
                        name="usos_maximos"
                        value="<?= $cupon['usos_maximos'] ?? '' ?>"
                        min="1"
                        placeholder="Vacío = ilimitado"
                    >
                </div>

            </div>

            <!-- Vencimiento -->
            <div class="form-field">
                <label>Fecha de vencimiento <span style="color:var(--text-muted);font-weight:400;font-size:0.8rem">(opcional)</span></label>
                <input
                    type="date"
                    name="fecha_expiracion"
                    value="<?= !empty($cupon['fecha_expiracion'])
                        ? date('Y-m-d', strtotime($cupon['fecha_expiracion']))
                        : '' ?>"
                    style="max-width:200px"
                >
            </div>

            <?php if (!$esEdicion): ?>
            <!-- Origen info -->
            <div class="form-field" style="background:#f8f7f5;padding:12px 16px;border-radius:8px;border:1px solid var(--border)">
                <div style="font-size:0.8rem;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px">Categoría</div>
                <strong style="font-size:0.9rem"><?= $tierLabels[$origenPre] ?></strong>
                <?php if ($esRegalo): ?>
                <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px">
                    Este cupón quedará asignado exclusivamente a <?= $usuario ? htmlspecialchars($usuario['nombre']) : 'este usuario' ?>.
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Nota interna -->
            <div class="form-field">
                <label>Nota interna <span style="color:var(--text-muted);font-weight:400;font-size:0.8rem">(solo la ve el admin)</span></label>
                <input
                    type="text"
                    name="nota"
                    value="<?= htmlspecialchars($cupon['nota'] ?? '') ?>"
                    maxlength="255"
                    placeholder="Ej: Regalo por compra de nivel Oro"
                >
            </div>

            <?php if ($esEdicion): ?>
            <div class="form-field">
                <label style="flex-direction:row;align-items:center;gap:10px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:0.85rem;font-weight:400">
                    <input type="checkbox" name="activo" value="1" <?= $cupon['activo'] ? 'checked' : '' ?>>
                    Cupón activo
                </label>
            </div>
            <?php endif; ?>

            <div class="form-actions" style="margin-top:28px">
                <button type="submit" class="btn-admin">
                    <?php if ($esEdicion): ?>Guardar cambios
                    <?php elseif ($esGiftcard): ?>Crear gift card
                    <?php elseif ($esRegalo): ?>Regalar cupón
                    <?php else: ?>Crear cupón
                    <?php endif; ?>
                </button>
                <a href="<?= $backUrl ?>" class="btn-admin-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</div>
</main>
