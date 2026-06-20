<!-- ================= FOOTER ================= -->
<footer class="site-footer">

    <!-- ================= GRID PRINCIPAL ================= -->
    <div class="contenedor footer-grid">

        <!-- ================= MARCA ================= -->
        <div class="footer-brand">

            <h4 class="footer-brand-title">Malku</h4>

            <p>
                Lujo esencial para un mundo que valora lo perdurable.
            </p>

        </div>

        <!-- ================= EXPLORAR ================= -->
        <div>

            <h5 class="footer-title">Explorar</h5>

            <ul class="footer-links">

                <li><a href="<?= BASE_URL; ?>/coleccion">Colección</a></li>
                <li><a href="<?= BASE_URL; ?>/nosotros">Nosotros</a></li>
                <li><a href="<?= BASE_URL; ?>/contacto">Contacto</a></li>

            </ul>

        </div>

        <!-- ================= SOPORTE ================= -->
        <div>

            <h5 class="footer-title">Soporte</h5>

            <ul class="footer-links">

                <li><a href="<?= BASE_URL; ?>/envios-devoluciones">Envíos</a></li>
                <li><a href="<?= BASE_URL; ?>/envios-devoluciones#devoluciones">Devoluciones</a></li>

            </ul>

        </div>

        <!-- ================= REDES ================= -->
        <div>

            <h5 class="footer-title">Seguinos</h5>

            <ul class="footer-links">

                <li><a href="https://instagram.com" target="_blank">Instagram</a></li>
                <li><a href="https://facebook.com" target="_blank">Facebook</a></li>

            </ul>

        </div>

    </div>

    <!-- ================= FOOTER INFERIOR ================= -->
    <div class="footer-bottom contenedor">

        <p>
            © <?= date('Y') ?> Malku. Todos los derechos reservados.
        </p>

        <!-- ================= LINKS LEGALES ================= -->
        <div class="footer-legal">

            <a href="<?= BASE_URL; ?>/terminos">Términos</a>
            <a href="<?= BASE_URL; ?>/privacidad">Privacidad</a>

        </div>

    </div>

</footer>

<!-- ================= JS GLOBAL ================= -->
<script src="<?= BASE_URL; ?>/assets/js/global/menu.js"></script>
<script>window.BASE_URL = '<?= BASE_URL; ?>';</script>
<script src="<?= BASE_URL; ?>/assets/js/global/coleccion.js"></script>

<?php if ($_esAdmin ?? false): ?>
<script src="<?= BASE_URL ?>/assets/js/admin/admin.js"></script>
<?php endif; ?>

<?php if (isset($js)): ?>
<script src="<?= BASE_URL ?>/assets/js/<?= $js ?>"></script>
<?php endif; ?>

</body>
</html>