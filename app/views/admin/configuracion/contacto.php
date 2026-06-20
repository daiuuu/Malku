<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Datos de contacto</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Datos de contacto</h1>
            <p class="admin-page-subtitle">Esta información aparece en la página de contacto del sitio.</p>
        </div>
        <a href="<?= BASE_URL ?>/contacto" target="_blank" class="btn-admin-secondary btn-admin-sm">Ver página →</a>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/configuracion/contacto/guardar" class="admin-form" style="max-width:760px">

        <div class="form-row">
            <div class="form-field">
                <label>Email de contacto</label>
                <input type="email" name="contacto_email" value="<?= htmlspecialchars($config['contacto_email'] ?? '') ?>" placeholder="hola@malku.com">
            </div>
            <div class="form-field">
                <label>Teléfono (visible en el sitio)</label>
                <input type="text" name="contacto_telefono" value="<?= htmlspecialchars($config['contacto_telefono'] ?? '') ?>" placeholder="+54 9 11 6454-7751">
            </div>
        </div>

        <div class="form-field">
            <label>Número de WhatsApp <span style="font-weight:300;text-transform:none;letter-spacing:0">(solo números, sin +, sin espacios — ej: 5491164547751)</span></label>
            <input type="text" name="contacto_telefono_wa" value="<?= htmlspecialchars($config['contacto_telefono_wa'] ?? '') ?>" placeholder="5491164547751">
            <span class="form-hint">Este número se usa en los links de WhatsApp del sitio.</span>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>Dirección</label>
                <input type="text" name="contacto_direccion" value="<?= htmlspecialchars($config['contacto_direccion'] ?? '') ?>" placeholder="Av. General Paz 1240">
            </div>
            <div class="form-field">
                <label>Ciudad / País</label>
                <input type="text" name="contacto_ciudad" value="<?= htmlspecialchars($config['contacto_ciudad'] ?? '') ?>" placeholder="Buenos Aires, Argentina">
            </div>
        </div>

        <div class="form-field">
            <label>Horario de atención</label>
            <input type="text" name="contacto_horario" value="<?= htmlspecialchars($config['contacto_horario'] ?? '') ?>" placeholder="Lun—Vie, 10am—6pm">
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>URL Instagram</label>
                <input type="text" name="contacto_instagram" value="<?= htmlspecialchars($config['contacto_instagram'] ?? '') ?>" placeholder="https://instagram.com/malku">
            </div>
            <div class="form-field">
                <label>URL Facebook</label>
                <input type="text" name="contacto_facebook" value="<?= htmlspecialchars($config['contacto_facebook'] ?? '') ?>" placeholder="https://facebook.com/malku">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-admin">Guardar cambios</button>
            <a href="<?= BASE_URL ?>/admin" class="btn-admin-secondary">Cancelar</a>
        </div>

    </form>

</div>
</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
