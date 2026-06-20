<?php
// $pregunta = existing row (edit) or null (create)
$esEdicion = !empty($pregunta);
$accion    = $esEdicion
    ? BASE_URL . '/admin/preguntas/actualizar'
    : BASE_URL . '/admin/preguntas/guardar';
?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <a href="<?= BASE_URL ?>/admin/preguntas">Preguntas Frecuentes</a>
        <span>›</span>
        <span><?= $esEdicion ? 'Editar' : 'Nueva pregunta' ?></span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">
                <?= $esEdicion ? 'Editar pregunta' : 'Nueva pregunta frecuente' ?>
            </h1>
            <p class="admin-page-subtitle">
                <?= $esEdicion ? 'Modificá el texto de la pregunta y su respuesta.' : 'Agregá una nueva pregunta al acordeón de la página de Envíos.' ?>
            </p>
        </div>
    </div>

    <div class="admin-card" style="max-width:680px">

        <form method="POST" action="<?= $accion ?>" class="admin-form">

            <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= $pregunta['id'] ?>">
            <?php endif; ?>

            <!-- Pregunta -->
            <div class="form-field">
                <label>Pregunta <span style="color:#c0392b">*</span></label>
                <input
                    type="text"
                    name="pregunta"
                    value="<?= htmlspecialchars($pregunta['pregunta'] ?? '') ?>"
                    required
                    maxlength="500"
                    placeholder="Ej: ¿Hacen envíos internacionales?"
                >
            </div>

            <!-- Respuesta -->
            <div class="form-field">
                <label>Respuesta <span style="color:#c0392b">*</span></label>
                <textarea
                    name="respuesta"
                    required
                    rows="5"
                    placeholder="Escribí la respuesta completa aquí..."
                    style="width:100%;resize:vertical"
                ><?= htmlspecialchars($pregunta['respuesta'] ?? '') ?></textarea>
            </div>

            <div class="form-row">

                <!-- Orden -->
                <div class="form-field">
                    <label>Orden de aparición</label>
                    <input
                        type="number"
                        name="orden"
                        value="<?= (int)($pregunta['orden'] ?? 0) ?>"
                        min="0"
                        style="max-width:120px"
                        placeholder="0"
                    >
                    <span style="font-size:0.78rem;color:var(--text-muted)">Menor número = más arriba</span>
                </div>

                <!-- Activo -->
                <div class="form-field" style="justify-content:flex-end;padding-bottom:4px">
                    <label style="flex-direction:row;align-items:center;gap:10px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:0.85rem;font-weight:400">
                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            <?= ($pregunta['activo'] ?? 1) ? 'checked' : '' ?>
                        >
                        Visible en el sitio
                    </label>
                </div>

            </div>

            <div class="form-actions" style="margin-top:28px">
                <button type="submit" class="btn-admin">
                    <?= $esEdicion ? 'Guardar cambios' : 'Crear pregunta' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/preguntas" class="btn-admin-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</div>
</main>
