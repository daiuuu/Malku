<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="login-page">

    <section class="login-section">

        <div class="login-grid">

            <!-- ================= IMAGEN ================= -->
            <div class="login-image">

                <img
                    src="<?= BASE_URL; ?>/assets/img/auth/login-textura.jpg"
                    alt="Textura artesanal de lana Malku"
                >

                <div class="login-brand">

                    <h1>
                        MALKU
                    </h1>

                    <span>
                        Excelencia artesanal desde 1992
                    </span>

                </div>

            </div>

            <!-- ================= FORM ================= -->
            <div class="login-content">

                <div class="login-container">

                    <span class="login-label">
                        Autenticación
                    </span>

                    <h2>
                        Bienvenido nuevamente
                    </h2>

                    <p class="login-description">
                        Ingresá tus credenciales para acceder
                        a tu colección personal y archivo.
                    </p>

                    <?php if(isset($_SESSION['login_error'])): ?>

                        <div class="mensaje-error">

                            <?= $_SESSION['login_error']; ?>

                        </div>

                        <?php unset($_SESSION['login_error']); ?>

                    <?php endif; ?>

                    <?php if(isset($_SESSION['registro_exito'])): ?>

                        <div class="mensaje-exito">

                            <?= $_SESSION['registro_exito']; ?>

                        </div>

                        <?php unset($_SESSION['registro_exito']); ?>

                    <?php endif; ?>

                    <form
                        class="login-form"
                        method="POST"
                        action="<?= BASE_URL; ?>/login/autenticar"
                    >

                        <!-- EMAIL -->
                        <div class="form-group">

                            <label for="email">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="name@example.com"
                                required
                            >

                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">

                            <div class="password-top">

                                <label for="password">
                                    Contraseña
                                </label>

                                <a href="#">
                                        ¿Olvidaste tu contraseña?
                                </a>

                            </div>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                            >

                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="btn-login"
                        >
                            Iniciar sesión
                        </button>

                        <div class="login-divider">

                            <span>
                                o
                            </span>

                        </div>

                        <a
                            href="<?= BASE_URL; ?>/registro"
                            class="btn-create-account"
                        >
                            Crear cuenta
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>