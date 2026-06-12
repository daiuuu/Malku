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
                Recuperar Contraseña
            </h2>

            <!-- ================= DESCRIPCIÓN ================= -->
            <p class="recuperar-description">
                Introducí tu correo electrónico para recibir
                las instrucciones y restablecer el acceso
                a tu cuenta.
            </p>

            <!-- ================= MENSAJE ÉXITO ================= -->
            <?php if(isset($_SESSION['recuperar_exito'])): ?>

                <div class="mensaje-exito">

                    <?= $_SESSION['recuperar_exito']; ?>

                </div>

                <?php unset($_SESSION['recuperar_exito']); ?>

            <?php endif; ?>

            <!-- ================= MENSAJE ERROR ================= -->
            <?php if(isset($_SESSION['recuperar_error'])): ?>

                <div class="mensaje-error">

                    <?= $_SESSION['recuperar_error']; ?>

                </div>

                <?php unset($_SESSION['recuperar_error']); ?>

            <?php endif; ?>

            <!-- ================= FORMULARIO ================= -->
            <form
                class="recuperar-form"
                method="POST"
                action="<?= BASE_URL; ?>/recuperar-password"
            >

                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="tu@ejemplo.com"
                        required
                    >

                </div>

                <!-- BOTÓN -->
                <button
                    type="submit"
                    class="btn-recuperar"
                >
                    Enviar instrucciones
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
