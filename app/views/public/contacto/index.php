<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<main id="contacto-page">

    <!-- ================= HERO CONTACTO ================= -->
    <section class="contacto-hero">

        <div class="contenedor">

            <span class="contacto-label">
                ATELIER MALKU
            </span>

            <h1>
                <i>Contactanos</i>
            </h1>

            <p>
                Cada prenda nace de una historia, y cada consulta merece el mismo cuidado.
                Ya sea para acompañarte en una compra, conocer nuestros procesos
                artesanales o explorar colaboraciones, nuestro atelier está abierto para vos.
            </p>

        </div>

    </section>

    <!-- ================= MENSAJES ================= -->
    <?php if(isset($_SESSION['contacto_exito'])): ?>

        <div class="contenedor">

            <div class="mensaje-exito">

                <?= $_SESSION['contacto_exito']; ?>

            </div>

        </div>

        <?php unset($_SESSION['contacto_exito']); ?>

    <?php endif; ?>

    <?php if(isset($_SESSION['contacto_error'])): ?>

        <div class="contenedor">

            <div class="mensaje-error">

                <?= $_SESSION['contacto_error']; ?>

            </div>

        </div>

        <?php unset($_SESSION['contacto_error']); ?>

    <?php endif; ?>

    <!-- ================= CONTACTO PRINCIPAL ================= -->
    <section class="contacto-main">

        <div class="contenedor contacto-grid">

            <!-- ================= FORMULARIO ================= -->
            <div class="contacto-formulario-container">

                <form 
                    class="contacto-formulario"
                    action="<?= BASE_URL; ?>/contacto/enviar"
                    method="POST"
                >

                    <!-- ================= NOMBRE ================= -->
                    <div class="form-group">

                        <label for="nombre">
                            Nombre completo
                        </label>

                        <input 
                            type="text"
                            id="nombre"
                            name="nombre"
                            placeholder="Ingresa tu nombre"
                            required
                            minlength="3"
                            maxlength="120"
                            value="<?= $_SESSION['old_nombre'] ?? ''; ?>"
                        >

                    </div>

                    <!-- ================= EMAIL ================= -->
                    <div class="form-group">

                        <label for="email">
                            Correo electrónico
                        </label>

                        <input 
                            type="email"
                            id="email"
                            name="email"
                            placeholder="hola@ejemplo.com"
                            required
                            maxlength="150"
                            value="<?= $_SESSION['old_email'] ?? ''; ?>"
                        >

                    </div>

                    <!-- ================= ASUNTO ================= -->
                    <div class="form-group">

                        <label for="asunto">
                            Asunto
                        </label>

                        <input 
                            type="text"
                            id="asunto"
                            name="asunto"
                            placeholder="Motivo de tu consulta"
                            required
                            minlength="5"
                            maxlength="150"
                            value="<?= $_SESSION['old_asunto'] ?? ''; ?>"
                        >

                    </div>

                    <!-- ================= MENSAJE ================= -->
                    <div class="form-group">

                        <label for="mensaje">
                            Mensaje
                        </label>

                        <textarea 
                            id="mensaje"
                            name="mensaje"
                            rows="5"
                            placeholder="Escribe tu mensaje aquí..."
                            required
                            minlength="10"
                            maxlength="2000"
                        ><?= $_SESSION['old_mensaje'] ?? ''; ?></textarea>

                    </div>

                    <!-- ================= BOTÓN ================= -->
                    <button type="submit" class="btn-contacto">
                        Enviar consulta
                    </button>

                </form>

            </div>

            <!-- ================= INFO CONTACTO ================= -->
            <div class="contacto-info">

                <!-- ================= EMAIL ================= -->
                <div class="info-block">

                    <span class="info-label">
                        Correo electrónico
                    </span>

                    <a href="mailto:hola@malku.com" class="info-link">hola@malku.com</a>

                </div>

                <!-- ================= TELÉFONO ================= -->
                <div class="info-block">

                    <span class="info-label">
                        Teléfono
                    </span>

                    <a href="tel:+5491164547751" class="info-link">+54 9 11 6454-7751</a>

                </div>

                <!-- ================= DIRECCIÓN ================= -->
                <div class="info-block">

                    <span class="info-label">
                        El Atelier
                    </span>

                    <p>
                        Av. General Paz 1240 <br>
                        Buenos Aires, Argentina
                    </p>

                    <span class="info-horario">
                        Lun—Vie, 10am—6pm
                    </span>

                </div>


                <!-- ================= REDES ================= -->
                <div class="info-block">

                    <span class="info-label">
                        Conectar
                    </span>

                    <div class="redes-contacto">

                        <a href="#">Instagram</a>
                        <a href="#">Facebook</a>

                    </div>

                </div>

                <!-- ================= DECORACIÓN ================= -->
                <div class="contacto-decoracion">M</div>

            </div>

        </div>

    </section>

    <!-- ================= SERVICIOS ================= -->
    <section class="contacto-servicios">

        <div class="contenedor servicios-grid">

            <!-- ================= SERVICIO 1 ================= -->
            <article class="servicio-card">

                <h2>
                    Cuidado & Reparaciones
                </h2>

                <p>
                    Cada pieza MALKU está diseñada para perdurar por generaciones.
                    Ofrecemos un servicio de reparación dedicado para preservar
                    la esencia y la vida útil de cada prenda artesanal.
                </p>

                <a href="tel:+5491164547751">Solicitar reparación →</a>

            </article>

            <!-- ================= SERVICIO 2 ================= -->
            <article class="servicio-card">

                <h2>
                    Consultas Mayoristas
                </h2>

                <p>
                    Colaboramos con boutiques y espacios seleccionados alrededor
                    del mundo que comparten nuestra visión de lujo silencioso,
                    artesanía y diseño atemporal.
                </p>

                <a href="#">Aplicar como partner →</a>

            </article>

        </div>

    </section>

    <!-- ================= IMAGEN EDITORIAL ================= -->
    <section class="contacto-editorial">

        <div class="contenedor">

            <div class="editorial-imagen">

                <img
                    src="<?= BASE_URL; ?>/assets/img/contacto/contacto-editorial.jpg"
                    alt="Lana artesanal Malku"
                >

            </div>

        </div>

    </section>

</main>

<?php

unset($_SESSION['old_nombre']);
unset($_SESSION['old_email']);
unset($_SESSION['old_asunto']);
unset($_SESSION['old_mensaje']);

?>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>