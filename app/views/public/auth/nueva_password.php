<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="recuperar-page">

    <section class="recuperar-section">

        <div class="recuperar-container">

            <!-- ================= LABEL ================= -->
            <span class="recuperar-label">
                Seguridad
            </span>

            <!-- ================= TÍTULO ================= -->
            <h2>
                Nueva Contraseña
            </h2>

            <!-- ================= DESCRIPCIÓN ================= -->
            <p class="recuperar-description">
                Elegí una nueva contraseña para
                tu cuenta. Debe tener al menos
                6 caracteres.
            </p>

            <!-- ================= MENSAJE ERROR ================= -->
            <?php if(isset($_SESSION['nueva_password_error'])): ?>

                <div class="mensaje-error">

                    <?= htmlspecialchars(
                        $_SESSION['nueva_password_error']
                    ); ?>

                </div>

                <?php unset($_SESSION['nueva_password_error']); ?>

            <?php endif; ?>

            <!-- ================= FORMULARIO ================= -->
            <form
                class="recuperar-form"
                method="POST"
                action="<?= BASE_URL; ?>/nueva-password"
            >

                <input
                    type="hidden"
                    name="token"
                    value="<?= htmlspecialchars($token); ?>"
                >

                <!-- CONTRASEÑA -->
                <div class="form-group">

                    <label for="password">
                        Nueva contraseña
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        minlength="6"
                        required
                    >

                </div>

                <!-- CONFIRMAR -->
                <div class="form-group">

                    <label for="confirm_password">
                        Confirmar contraseña
                    </label>

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="••••••••"
                        minlength="6"
                        required
                    >

                </div>

                <!-- BOTÓN -->
                <button
                    type="submit"
                    class="btn-recuperar"
                >
                    Guardar contraseña
                </button>

            </form>

            <!-- ================= VOLVER ================= -->
            <a
                href="<?= BASE_URL; ?>/login"
                class="recuperar-volver"
            >
                ← Volver al inicio de sesión
            </a>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
