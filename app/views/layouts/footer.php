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

<?php if (!($_esLogueado ?? false) && !($_esAdmin ?? false)): ?>
<!-- ===== MODAL AUTH GLOBAL ===== -->
<div class="modal-auth-overlay" id="modal-auth" aria-modal="true" role="dialog" aria-label="Iniciar sesión">
    <div class="modal-auth">
        <button class="cerrar-modal-auth" id="cerrar-modal-auth" aria-label="Cerrar">×</button>
        <span class="modal-auth-subtitulo">EXPERIENCIA MALKU</span>
        <h2>Descubrí una experiencia personalizada</h2>
        <p>
            Iniciá sesión para acceder a tus pedidos,
            beneficios exclusivos y una experiencia
            de compra inspirada en el universo Malku.
        </p>
        <div class="modal-auth-botones">
            <a href="<?= BASE_URL ?>/login" class="btn-auth-login">Iniciar sesión</a>
            <span>o</span>
            <a href="<?= BASE_URL ?>/registro" class="btn-auth-register">Crear cuenta</a>
        </div>
    </div>
</div>

<style>
.modal-auth-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9000;display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .35s ease,visibility .35s ease}
.modal-auth-overlay.activo{opacity:1;visibility:visible}
.modal-auth{position:relative;background:#F5F1E8;width:100%;max-width:520px;margin:20px;padding:4rem 4rem 3.5rem;border-radius:4px;transform:translateY(24px);transition:transform .35s ease}
.modal-auth-overlay.activo .modal-auth{transform:translateY(0)}
.cerrar-modal-auth{position:absolute;top:1.2rem;right:1.4rem;background:none;border:none;font-size:1.8rem;line-height:1;cursor:pointer;color:#111;padding:4px 8px}
.modal-auth-subtitulo{display:inline-block;font-size:.62rem;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:#888;margin-bottom:1.5rem}
.modal-auth h2{font-family:'Cormorant Garamond',serif;font-size:3rem;font-style:italic;font-weight:400;line-height:1.15;color:#111;margin:0 0 1.5rem}
.modal-auth p{font-size:.9rem;line-height:1.9;color:#6d6a64;margin-bottom:2.5rem}
.modal-auth-botones{display:flex;flex-direction:column;gap:1rem;align-items:stretch}
.btn-auth-login,.btn-auth-register{display:block;padding:1rem 2rem;text-align:center;text-decoration:none;font-size:.75rem;letter-spacing:.18em;text-transform:uppercase;border-radius:3px;transition:background .2s,color .2s;font-family:inherit}
.btn-auth-login{background:#1e1e1c;color:#fff}
.btn-auth-login:hover{background:#333;color:#fff}
.btn-auth-register{background:transparent;border:1px solid #1e1e1c;color:#1e1e1c}
.btn-auth-register:hover{background:#1e1e1c;color:#fff}
.modal-auth-botones span{font-size:.7rem;text-transform:uppercase;letter-spacing:.25em;color:#aaa;text-align:center}
@media(max-width:600px){.modal-auth{padding:3rem 2rem}.modal-auth h2{font-size:2.2rem}}
</style>

<script>
(function () {
    var modal  = document.getElementById('modal-auth');
    var cerrar = document.getElementById('cerrar-modal-auth');
    if (!modal) return;

    function abrirModal() {
        modal.classList.add('activo');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModal() {
        modal.classList.remove('activo');
        document.body.style.overflow = '';
    }

    // Botón del header (guests)
    var btnHeader = document.getElementById('btn-fav-guest');
    if (btnHeader) btnHeader.addEventListener('click', abrirModal);

    // Botones de corazón en tarjetas de productos (cualquier página)
    document.querySelectorAll('.fav-btn--guest').forEach(function (btn) {
        btn.addEventListener('click', abrirModal);
    });

    // También el botón del carrito (retrocompatibilidad)
    var btnCarrito = document.getElementById('abrir-login-modal');
    if (btnCarrito) btnCarrito.addEventListener('click', abrirModal);

    cerrar.addEventListener('click', cerrarModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) cerrarModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && modal.classList.contains('activo')) cerrarModal(); });
})();
</script>
<?php endif; ?>

</body>
</html>