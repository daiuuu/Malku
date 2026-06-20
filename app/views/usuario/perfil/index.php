<main>
<div class="contenedor">

    <div class="u-page-header">
        <span class="u-page-header__label">Mi cuenta</span>
        <h1 class="u-page-header__title">Mi Perfil</h1>
    </div>

    <?php if ($flash_ok): ?>
    <div class="u-flash u-flash--ok"><?= htmlspecialchars($flash_ok) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
    <div class="u-flash u-flash--error"><?= htmlspecialchars($flash_error) ?></div>
    <?php endif; ?>

    <!-- DATOS PERSONALES -->
    <div class="u-card" style="margin-bottom:20px">
        <div class="u-card__header">
            <h3 class="u-card__title">Datos personales</h3>
        </div>
        <form action="<?= BASE_URL ?>/usuario/perfil/guardar" method="POST">
            <div class="u-form-grid">
                <div class="u-form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                </div>
                <div class="u-form-group">
                    <label for="apellido">Apellido *</label>
                    <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
                </div>
                <div class="u-form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
                <div class="u-form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
                </div>
            </div>
            <div class="u-btn-row">
                <button type="submit" class="u-btn u-btn--dark">Guardar cambios</button>
            </div>
        </form>
    </div>

    <!-- CAMBIAR CONTRASEÑA -->
    <div class="u-card">
        <div class="u-card__header">
            <h3 class="u-card__title">Cambiar contraseña</h3>
        </div>
        <form action="<?= BASE_URL ?>/usuario/perfil/cambiar-password" method="POST">
            <div class="u-form-grid">
                <div class="u-form-group u-form-group--full">
                    <label for="password_actual">Contraseña actual *</label>
                    <input type="password" id="password_actual" name="password_actual" required>
                </div>
                <div class="u-form-group">
                    <label for="password_nueva">Nueva contraseña *</label>
                    <input type="password" id="password_nueva" name="password_nueva" required minlength="6">
                </div>
                <div class="u-form-group">
                    <label for="password_confirmar">Confirmar nueva contraseña *</label>
                    <input type="password" id="password_confirmar" name="password_confirmar" required minlength="6">
                </div>
            </div>
            <div class="u-btn-row">
                <button type="submit" class="u-btn u-btn--outline">Cambiar contraseña</button>
            </div>
        </form>
    </div>

</div>
</main>
