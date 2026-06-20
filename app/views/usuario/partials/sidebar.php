<?php

// ================= URL ACTUAL =================
$currentUrl =
    trim($_GET['url'] ?? '', '/');

// ================= ITEMS DE NAVEGACIÓN =================
$navItems = [
    [
        'url'   => 'usuario',
        'label' => 'Dashboard'
    ],
    [
        'url'   => 'usuario/pedidos',
        'label' => 'Pedidos'
    ],
    [
        'url'   => 'usuario/perfil',
        'label' => 'Perfil'
    ],
    [
        'url'   => 'usuario/direcciones',
        'label' => 'Direcciones'
    ],
    [
        'url'   => 'usuario/favoritos',
        'label' => 'Favoritos'
    ],
    [
        'url'   => 'usuario/membresia',
        'label' => 'Membresía Malku'
    ],
];

// ================= INICIAL DEL USUARIO =================
$inicial =
    strtoupper(
        substr(
            $_SESSION['usuario']['nombre'],
            0,
            1
        )
    );

?>

<!-- ================= SIDEBAR ================= -->
<aside
    class="user-sidebar"
    id="user-sidebar"
>

    <div class="sidebar-inner">

        <!-- ================= LOGO ================= -->
        <div class="sidebar-logo">

            <a href="<?= BASE_URL; ?>">
                MALKU
            </a>

        </div>

        <!-- ================= USUARIO ================= -->
        <div class="sidebar-user">

            <div class="sidebar-avatar">
                <?= $inicial; ?>
            </div>

            <div class="sidebar-user-info">

                <span class="sidebar-user-name">
                    <?= htmlspecialchars(
                        $_SESSION['usuario']['nombre']
                    ); ?>
                    <?= htmlspecialchars(
                        $_SESSION['usuario']['apellido'] ?? ''
                    ); ?>
                </span>

                <span class="sidebar-user-email">
                    <?= htmlspecialchars(
                        $_SESSION['usuario']['email']
                    ); ?>
                </span>

            </div>

        </div>

        <!-- ================= DIVISOR ================= -->
        <div class="sidebar-divider"></div>

        <!-- ================= NAVEGACIÓN ================= -->
        <nav class="sidebar-nav">

            <ul class="sidebar-nav-list">

                <?php foreach($navItems as $item): ?>

                    <li class="sidebar-nav-item <?=
                        $currentUrl === $item['url']
                            ? 'active'
                            : ''
                    ?>">

                        <a
                            href="<?= BASE_URL; ?>/<?= $item['url']; ?>"
                            class="sidebar-nav-link"
                        >
                            <?= $item['label']; ?>
                        </a>

                    </li>

                <?php endforeach; ?>

            </ul>

        </nav>

        <!-- ================= BOTTOM ================= -->
        <div class="sidebar-bottom">

            <div class="sidebar-divider"></div>

            <a
                href="<?= BASE_URL; ?>/logout"
                class="sidebar-logout"
            >
                Cerrar sesión
            </a>

        </div>

    </div>

</aside>

<!-- ================= OVERLAY ================= -->
<div
    class="sidebar-overlay"
    id="sidebar-overlay"
></div>

<!-- ================= TOGGLE MOBILE ================= -->
<button
    class="sidebar-toggle"
    id="sidebar-toggle"
    aria-label="Abrir menú"
>

    <span class="toggle-line"></span>
    <span class="toggle-line"></span>
    <span class="toggle-line"></span>

</button>

<!-- ================= JS SIDEBAR ================= -->
<script>

    (function()
    {
        var sidebar  = document.getElementById('user-sidebar');
        var toggle   = document.getElementById('sidebar-toggle');
        var overlay  = document.getElementById('sidebar-overlay');

        function abrirSidebar()
        {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function cerrarSidebar()
        {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', function()
        {
            sidebar.classList.contains('open')
                ? cerrarSidebar()
                : abrirSidebar();
        });

        overlay.addEventListener('click', cerrarSidebar);

    })();

</script>
