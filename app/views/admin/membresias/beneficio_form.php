<?php
// $beneficio is set when editing; absent when creating
$esEdicion = !empty($beneficio);
$accion    = $esEdicion
    ? BASE_URL . '/admin/membresias/beneficios/actualizar'
    : BASE_URL . '/admin/membresias/beneficios/guardar';

$tierPre = $beneficio['tier'] ?? ($tierPre ?? 'bronce');
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/membresias">Membresías</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/membresias/beneficios">Beneficios</a>
        <span>›</span>
        <span><?= $esEdicion ? 'Editar' : 'Nuevo' ?></span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">
                <?= $esEdicion ? 'Editar beneficio' : 'Nuevo beneficio' ?>
            </h1>
            <p class="admin-page-subtitle">
                Los cambios se reflejan de inmediato en el panel del usuario.
            </p>
        </div>
    </div>

    <div class="admin-card" style="max-width:580px">

        <form method="POST" action="<?= $accion ?>" class="admin-form">

            <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= $beneficio['id'] ?>">
            <?php endif; ?>

            <div class="form-row">

                <div class="form-field">
                    <label>Nivel de membresía</label>
                    <select name="tier" required>
                        <?php foreach (['bronce' => 'Bronce', 'plata' => 'Plata', 'oro' => 'Oro'] as $val => $lbl): ?>
                        <option value="<?= $val ?>" <?= $tierPre === $val ? 'selected' : '' ?>>
                            <?= $lbl ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-field">
                    <label>Icono / símbolo</label>
                    <input
                        type="text"
                        name="icono"
                        value="<?= htmlspecialchars($beneficio['icono'] ?? '✦') ?>"
                        maxlength="10"
                        placeholder="✦"
                        style="max-width:90px"
                    >
                </div>

            </div>

            <div class="form-field">
                <label>Título del beneficio <span style="color:#c0392b">*</span></label>
                <input
                    type="text"
                    name="titulo"
                    value="<?= htmlspecialchars($beneficio['titulo'] ?? '') ?>"
                    required
                    placeholder="Ej: Envío gratis siempre"
                    maxlength="200"
                >
            </div>

            <div class="form-field">
                <label>Descripción <span style="color:var(--text-muted);font-weight:400;font-size:0.8rem">(opcional)</span></label>
                <textarea
                    name="descripcion"
                    rows="3"
                    placeholder="Explicación corta que aparece bajo el título"
                    style="resize:vertical"
                ><?= htmlspecialchars($beneficio['descripcion'] ?? '') ?></textarea>
            </div>

            <div class="form-field" style="max-width:160px">
                <label>Orden de aparición</label>
                <input
                    type="number"
                    name="orden"
                    value="<?= (int)($beneficio['orden'] ?? 0) ?>"
                    min="0"
                    max="999"
                >
            </div>

            <div class="form-actions" style="margin-top:28px">
                <button type="submit" class="btn-admin">
                    <?= $esEdicion ? 'Guardar cambios' : 'Crear beneficio' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/membresias/beneficios" class="btn-admin-secondary">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>
</main>
