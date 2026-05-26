<?php

require_once __DIR__ . '/../../../config/app.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ================= META ================= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ================= TITLE DINÁMICO ================= -->
    <title><?= $titulo ?? 'Malku' ?></title>

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="<?= BASE_URL; ?>/assets/img/global/icon_malku.png" type="image/png">

    <!-- ================= FUENTES ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- ================= CSS GLOBAL ================= -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/global/estilos.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/layouts/header.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/layouts/footer.css">

    <!-- ================= CSS ESPECÍFICO ================= -->
    <?php if(isset($css)): ?>

        <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/<?= $css ?>">

    <?php endif; ?>

</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="site-header">

        <nav class="header-container">

            <!-- ================= LOGO ================= -->
            <a href="<?= BASE_URL; ?>/" class="logo">
                <img src="<?= BASE_URL; ?>/assets/img/icon_malku.png" alt="Logo Malku">
                <span>MALKU</span>
            </a>

            <!-- ================= NAVEGACIÓN DESKTOP ================= -->
            <nav class="desktop-nav">
                <ul> <!-- falta completar rutas -->
                    <li><a href="<?= BASE_URL; ?>/coleccion">COLECCIÓN</a></li>
                    <li><a href="<?= BASE_URL; ?>/nosotros">NOSOTROS</a></li>
                    <li><a href="<?= BASE_URL; ?>/contacto">CONTACTO</a></li>
                </ul>
            </nav>

            <!-- ================= ICONOS ================= -->
            <div class="icons">

                <span>
                    <a href="<?= BASE_URL; ?>/carrito">🛒</a>
                </span>

                <span>
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <a href="<?= BASE_URL; ?>/mi-cuenta">
                            👤
                        </a>

                    <?php else: ?>
                        <a href="<?= BASE_URL; ?>/login">
                            👤
                        </a>

                    <?php endif; ?>
                </span>

            </div>

            <!-- ================= MENÚ MOBILE ================= -->
            <!-- <button class="menu-toggle" aria-label="Abrir menú">☰</button> -->

            <!-- ================= OFF CANVAS ================= -->
            <!-- <div class="off-canvas-menu" id="off-canvas-menu">
                <button class="close-btn" aria-label="Cerrar menú">&times;</button>

                <nav>
                    <ul>
                        <li><a href="<?= BASE_URL; ?>/coleccion">COLECCIÓN</a></li>
                        <li><a href="<?= BASE_URL; ?>/nosotros">NOSOTROS</a></li>
                        <li><a href="<?= BASE_URL; ?>/contacto">CONTACTO</a></li>
                    </ul>
                </nav>

            </div> -->

        </nav>

    </header>