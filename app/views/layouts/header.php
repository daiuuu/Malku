<?php

require_once __DIR__ . '/../../../config/app.php';

$_esAdmin    = isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'admin';
$_esLogueado = isset($_SESSION['usuario']);

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Malku' ?></title>

    <link rel="icon" href="<?= BASE_URL ?>/assets/img/global/icon_malku.png" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500&family=Cormorant+Garamond:ital,wght@1,300;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global/estilos.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/layouts/header.css?v=2">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/layouts/footer.css?v=2">

    <?php if (isset($css)): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= $css ?>">
    <?php endif; ?>

</head>
<body>

<header class="site-header">
    <div class="header-container">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>/" class="logo">
            <img src="<?= BASE_URL ?>/assets/img/icon_malku.png" alt="Logo Malku">
            <span>MALKU</span>
        </a>

        <!-- DESKTOP NAV -->
        <nav class="desktop-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>/coleccion">Colección</a></li>
                <li><a href="<?= BASE_URL ?>/nosotros">Nosotros</a></li>
                <li><a href="<?= BASE_URL ?>/contacto">Contacto</a></li>
            </ul>
        </nav>

        <!-- DESKTOP ICONS -->
        <div class="header-icons">

            <a href="<?= BASE_URL ?>/carrito" class="hicon hicon--cart" aria-label="Carrito"></a>

            <?php if ($_esLogueado): ?>

            <div class="account-wrap">
                <button class="hicon hicon--account" id="account-btn" aria-label="Mi cuenta" aria-expanded="false"></button>

                <div class="account-menu" id="account-menu">
                    <?php if ($_esAdmin): ?>

                        <span class="account-menu__label"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin">Dashboard</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/productos">Productos</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/categorias">Categorías</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/pedidos">Pedidos</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/usuarios">Usuarios</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/contacto">Mensajes</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/stock">Stock</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/analytics">Analytics</a>
                        <div class="account-menu__divider"></div>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/configuracion/contacto">Datos de Contacto</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/admin/configuracion/envios">Envíos & Devoluciones</a>
                        <div class="account-menu__divider"></div>
                        <a class="account-menu__item account-menu__item--danger" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a>

                    <?php else: ?>

                        <span class="account-menu__label"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario">Dashboard</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario/pedidos">Mis Pedidos</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario/favoritos">Favoritos</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario/direcciones">Direcciones</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario/perfil">Mi Perfil</a>
                        <a class="account-menu__item" href="<?= BASE_URL ?>/usuario/membresia">Membresía</a>
                        <div class="account-menu__divider"></div>
                        <a class="account-menu__item account-menu__item--danger" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a>

                    <?php endif; ?>
                </div>
            </div>

            <?php else: ?>

            <a href="<?= BASE_URL ?>/login" class="hicon hicon--account" aria-label="Iniciar sesión"></a>

            <?php endif; ?>

        </div>

        <!-- HAMBURGER -->
        <button class="hamburger" id="menu-toggle" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</header>

<!-- OVERLAY -->
<div class="canvas-overlay" id="menu-overlay"></div>

<!-- OFF-CANVAS MENU -->
<aside class="canvas-menu" id="off-canvas-menu">

    <div class="canvas-menu__head">
        <span class="canvas-menu__brand">MALKU</span>
        <button class="canvas-menu__close" id="close-btn" aria-label="Cerrar">&times;</button>
    </div>

    <div class="canvas-menu__body">

        <div class="canvas-group">
            <p class="canvas-group__label">Explorar</p>
            <ul>
                <li><a href="<?= BASE_URL ?>/coleccion">Colección</a></li>
                <li><a href="<?= BASE_URL ?>/nosotros">Nosotros</a></li>
                <li><a href="<?= BASE_URL ?>/contacto">Contacto</a></li>
                <li><a href="<?= BASE_URL ?>/carrito">Carrito</a></li>
            </ul>
        </div>

        <?php if ($_esAdmin): ?>

        <div class="canvas-group">
            <p class="canvas-group__label">Administración</p>
            <ul>
                <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
                <li><a href="<?= BASE_URL ?>/admin/productos">Productos</a></li>
                <li><a href="<?= BASE_URL ?>/admin/categorias">Categorías</a></li>
                <li><a href="<?= BASE_URL ?>/admin/pedidos">Pedidos</a></li>
                <li><a href="<?= BASE_URL ?>/admin/usuarios">Usuarios</a></li>
                <li><a href="<?= BASE_URL ?>/admin/contacto">Mensajes</a></li>
                <li><a href="<?= BASE_URL ?>/admin/stock">Stock</a></li>
                <li><a href="<?= BASE_URL ?>/admin/analytics">Analytics</a></li>
                <li><a href="<?= BASE_URL ?>/admin/configuracion/contacto">Datos de Contacto</a></li>
                <li><a href="<?= BASE_URL ?>/admin/configuracion/envios">Envíos & Dev.</a></li>
                <li><a href="<?= BASE_URL ?>/logout" class="canvas-danger">Cerrar Sesión</a></li>
            </ul>
        </div>

        <?php elseif ($_esLogueado): ?>

        <div class="canvas-group">
            <p class="canvas-group__label"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></p>
            <ul>
                <li><a href="<?= BASE_URL ?>/usuario">Mi Cuenta</a></li>
                <li><a href="<?= BASE_URL ?>/logout" class="canvas-danger">Cerrar Sesión</a></li>
            </ul>
        </div>

        <?php else: ?>

        <div class="canvas-group">
            <p class="canvas-group__label">Cuenta</p>
            <ul>
                <li><a href="<?= BASE_URL ?>/login">Iniciar Sesión</a></li>
                <li><a href="<?= BASE_URL ?>/registro">Registrarse</a></li>
            </ul>
        </div>

        <?php endif; ?>

    </div>

</aside>
