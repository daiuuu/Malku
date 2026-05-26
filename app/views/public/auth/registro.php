<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="registro-page">

    <section class="registro-section">

        <div class="registro-grid">

            <!-- ================= FORM ================= -->
            <div class="registro-content">

                <div class="registro-container">

                    <span class="registro-label">
                        Comunidad Malku
                    </span>

                    <h2>
                        Crear cuenta
                    </h2>

                    <p class="registro-description">
                        Unite a nuestra comunidad de artesanía,
                        fibras nobles y diseño contemporáneo.
                    </p>

                    <?php if(isset($_SESSION['registro_error'])): ?>

                        <div class="mensaje-error">

                            <?= $_SESSION['registro_error']; ?>

                        </div>

                        <?php unset($_SESSION['registro_error']); ?>

                    <?php endif; ?>

                    <form
                        class="registro-form"
                        method="POST"
                        action="<?= BASE_URL; ?>/registro/guardar"
                    >

                        <!-- NOMBRE -->
                        <div class="form-group">

                            <label for="nombre">
                                Nombre completo
                            </label>

                            <input
                                type="text"
                                id="nombre"
                                name="nombre"
                                placeholder="Ingrese su nombre"
                                required
                            >

                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">

                            <label for="email">
                                Correo electrónico
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="correo@ejemplo.com"
                                required
                            >

                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">

                            <label for="password">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                            >

                        </div>

                        <!-- CHECKBOX -->
                        <div class="checkbox-group">

                            <input
                                type="checkbox"
                                id="newsletter"
                                name="newsletter"
                            >

                            <label for="newsletter">
                                Deseo recibir novedades
                                sobre nuevas colecciones.
                            </label>

                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="btn-registro"
                        >
                            Registrarse
                        </button>

                        <!-- LOGIN -->
                        <div class="registro-login">

                            <span>
                                ¿Ya tenés una cuenta?
                            </span>

                            <a
                                href="<?= BASE_URL; ?>/login"
                            >
                                Iniciar sesión aquí
                            </a>

                        </div>

                    </form>

                </div>

            </div>

            <!-- ================= IMAGEN ================= -->
            <div class="registro-image">

                <img
                    src="<?= BASE_URL; ?>/assets/img/auth/registro-textura.jpg"
                    alt="Textura artesanal de lana Malku"
                >

                <div class="registro-image-content">

                    <span>
                        Artesanía de los Andes
                    </span>

                    <h1>
                        Texturas del lujo silencioso
                    </h1>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>