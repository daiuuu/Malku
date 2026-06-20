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

    <!-- ================= TOAST ================= -->
    <?php if(isset($_SESSION['contacto_exito'])): ?>
    <div class="contacto-toast" id="contacto-toast" role="alert">
        <div class="contacto-toast__icon">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Mensaje enviado
        </div>
        <p class="contacto-toast__text"><?= htmlspecialchars($_SESSION['contacto_exito']) ?></p>
        <button class="contacto-toast__close" aria-label="Cerrar">&times;</button>
        <div class="contacto-toast__bar"></div>
    </div>
    <?php unset($_SESSION['contacto_exito']); endif; ?>

    <?php if(isset($_SESSION['contacto_error'])): ?>
    <div class="contacto-toast contacto-toast--error" id="contacto-toast" role="alert"
         style="border-left-color:#9b3535">
        <div class="contacto-toast__icon" style="color:#9b3535">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Error
        </div>
        <p class="contacto-toast__text"><?= htmlspecialchars($_SESSION['contacto_error']) ?></p>
        <button class="contacto-toast__close" aria-label="Cerrar">&times;</button>
        <div class="contacto-toast__bar" style="background:#9b3535"></div>
    </div>
    <?php unset($_SESSION['contacto_error']); endif; ?>

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

                <!-- EMAIL -->
                <div class="info-block">
                    <span class="info-label">Correo electrónico</span>
                    <a href="mailto:<?= htmlspecialchars($cfg['contacto_email'] ?? 'hola@malku.com') ?>" class="info-link">
                        <?= htmlspecialchars($cfg['contacto_email'] ?? 'hola@malku.com') ?>
                    </a>
                </div>

                <!-- TELÉFONO -->
                <div class="info-block">
                    <span class="info-label">Teléfono</span>
                    <a href="tel:<?= htmlspecialchars($cfg['contacto_telefono'] ?? '') ?>" class="info-link">
                        <?= htmlspecialchars($cfg['contacto_telefono'] ?? '+54 9 11 6454-7751') ?>
                    </a>
                </div>

                <!-- DIRECCIÓN -->
                <div class="info-block">
                    <span class="info-label">El Atelier</span>
                    <p>
                        <?= htmlspecialchars($cfg['contacto_direccion'] ?? 'Av. General Paz 1240') ?> <br>
                        <?= htmlspecialchars($cfg['contacto_ciudad'] ?? 'Buenos Aires, Argentina') ?>
                    </p>
                    <span class="info-horario">
                        <?= htmlspecialchars($cfg['contacto_horario'] ?? 'Lun—Vie, 10am—6pm') ?>
                    </span>
                </div>

                <!-- REDES -->
                <div class="info-block">
                    <span class="info-label">Conectar</span>
                    <div class="redes-contacto">
                        <?php if (!empty($cfg['contacto_instagram']) && $cfg['contacto_instagram'] !== '#'): ?>
                        <a href="<?= htmlspecialchars($cfg['contacto_instagram']) ?>" target="_blank" rel="noopener">Instagram</a>
                        <?php else: ?>
                        <a href="#">Instagram</a>
                        <?php endif; ?>
                        <?php if (!empty($cfg['contacto_facebook']) && $cfg['contacto_facebook'] !== '#'): ?>
                        <a href="<?= htmlspecialchars($cfg['contacto_facebook']) ?>" target="_blank" rel="noopener">Facebook</a>
                        <?php else: ?>
                        <a href="#">Facebook</a>
                        <?php endif; ?>
                    </div>
                </div>

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

                <a href="https://wa.me/<?= htmlspecialchars($cfg['contacto_telefono_wa'] ?? '5491164547751') ?>?text=%C2%A1Hola%21%20Vengo%20de%20Malku%20y%20me%20comunico%20por%20una%20consulta%20sobre%20cuidado%20y%20reparaci%C3%B3n%20de%20prendas." target="_blank" rel="noopener">Solicitar reparación →</a>

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

                <a href="https://wa.me/<?= htmlspecialchars($cfg['contacto_telefono_wa'] ?? '5491164547751') ?>?text=%C2%A1Hola%21%20Vengo%20de%20Malku%20y%20me%20comunico%20por%20una%20consulta%20mayorista%20para%20aplicar%20como%20partner." target="_blank" rel="noopener">Aplicar como partner →</a>

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

<script>
(function () {
    var toast = document.getElementById('contacto-toast');
    if (!toast) return;

    function dismiss() {
        toast.classList.add('toast--out');
        setTimeout(function () { toast.remove(); }, 320);
    }

    toast.querySelector('.contacto-toast__close').addEventListener('click', dismiss);
    setTimeout(dismiss, 4000);
}());
</script>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>