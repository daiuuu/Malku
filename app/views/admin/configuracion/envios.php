<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main class="admin-page">
<div class="admin-wrap">

    <nav class="admin-breadcrumb">
        <a href="<?= BASE_URL ?>/admin">Admin</a>
        <span>›</span>
        <span>Envíos y Devoluciones</span>
    </nav>

    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Envíos y Devoluciones</h1>
            <p class="admin-page-subtitle">Editá las políticas que se muestran en la página pública.</p>
        </div>
        <a href="<?= BASE_URL ?>/envios" target="_blank" class="btn-admin-secondary btn-admin-sm">Ver página →</a>
    </div>

    <?php if (!empty($_SESSION['admin_ok'])): ?>
    <div class="admin-flash admin-flash--ok"><?= htmlspecialchars($_SESSION['admin_ok']) ?></div>
    <?php unset($_SESSION['admin_ok']); endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/configuracion/envios/guardar" class="admin-form" style="max-width:760px">

        <!-- POLÍTICA DE ENVÍOS -->
        <div class="admin-card" style="margin-bottom:1.5rem;overflow:visible">
            <div class="admin-card__head"><p class="admin-card__title">Política de Envíos</p></div>
            <div style="padding:1.5rem 1.5rem 0.5rem">

                <p style="font-size:0.7rem;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:#b0a898;margin:0 0 1rem">Buenos Aires</p>
                <div class="form-row">
                    <div class="form-field">
                        <label>Precio / condición</label>
                        <input type="text" name="envios_ba_precio" value="<?= htmlspecialchars($config['envios_ba_precio'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-field">
                    <label>Descripción</label>
                    <textarea name="envios_ba_desc" rows="3"><?= htmlspecialchars($config['envios_ba_desc'] ?? '') ?></textarea>
                </div>

                <p style="font-size:0.7rem;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:#b0a898;margin:0.5rem 0 1rem">Envíos Nacionales</p>
                <div class="form-row">
                    <div class="form-field">
                        <label>Precio / condición</label>
                        <input type="text" name="envios_nacional_precio" value="<?= htmlspecialchars($config['envios_nacional_precio'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-field">
                    <label>Descripción</label>
                    <textarea name="envios_nacional_desc" rows="3"><?= htmlspecialchars($config['envios_nacional_desc'] ?? '') ?></textarea>
                </div>

                <p style="font-size:0.7rem;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:#b0a898;margin:0.5rem 0 1rem">Nuestro Compromiso</p>
                <div class="form-field">
                    <label>Texto</label>
                    <textarea name="envios_compromiso" rows="4"><?= htmlspecialchars($config['envios_compromiso'] ?? '') ?></textarea>
                </div>

            </div>
        </div>

        <!-- DEVOLUCIONES -->
        <div class="admin-card" style="margin-bottom:1.5rem;overflow:visible">
            <div class="admin-card__head"><p class="admin-card__title">Devoluciones y Cambios</p></div>
            <div style="padding:1.5rem 1.5rem 0.5rem">

                <div class="form-field">
                    <label>Texto introductorio</label>
                    <textarea name="dev_intro" rows="3"><?= htmlspecialchars($config['dev_intro'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-field">
                        <label>Días para devolver</label>
                        <input type="number" name="dev_ventana_dias" min="1" value="<?= htmlspecialchars($config['dev_ventana_dias'] ?? '14') ?>">
                    </div>
                </div>

                <div class="form-field">
                    <label>Política de ventana de devolución</label>
                    <textarea name="dev_ventana_desc" rows="3"><?= htmlspecialchars($config['dev_ventana_desc'] ?? '') ?></textarea>
                </div>

                <div class="form-field">
                    <label>Política de reembolsos</label>
                    <textarea name="dev_reembolso_desc" rows="3"><?= htmlspecialchars($config['dev_reembolso_desc'] ?? '') ?></textarea>
                </div>

                <div class="form-field">
                    <label>Política de cambios</label>
                    <textarea name="dev_cambios_desc" rows="3"><?= htmlspecialchars($config['dev_cambios_desc'] ?? '') ?></textarea>
                </div>

                <div class="form-field">
                    <label>Atención personalizada</label>
                    <textarea name="dev_atencion_desc" rows="3"><?= htmlspecialchars($config['dev_atencion_desc'] ?? '') ?></textarea>
                </div>

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
