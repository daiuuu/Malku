<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ================= META ================= -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ================= TITLE DINÁMICO ================= -->
    <title><?= $titulo ?? 'Malku' ?></title>

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="/assets/img/icon_malku.png" type="image/png">

    <!-- ================= FUENTES ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600&family=Cormorant+Garamond:ital,wght@0,400;1,400&display=swap" rel="stylesheet">

    <!-- ================= CSS GLOBAL ================= -->
    <link rel="stylesheet" href="/assets/css/global/estilos.css">
    <link rel="stylesheet" href="/assets/css/layouts/header.css">
    <link rel="stylesheet" href="/assets/css/layouts/footer.css">

    <!-- ================= CSS ESPECÍFICO ================= -->
    <?php if(isset($css)): ?>

        <link rel="stylesheet"
              href="/assets/css/<?= $css ?>">

    <?php endif; ?>

</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="site-header">

        <nav class="header-container">

            <!-- ================= LOGO ================= -->
            <a href="/" class="logo"> <!-- falta completar ruta -->
                <img src="/assets/img/icon_malku.png" alt="Logo Malku">
                <span>MALKU</span>
            </a>

            <!-- ================= NAVEGACIÓN DESKTOP ================= -->
            <nav class="desktop-nav">
                <ul> <!-- falta completar rutas -->
                    <li><a href="/coleccion">COLECCIÓN</a></li>
                    <li><a href="/nosotros">NOSOTROS</a></li>
                    <li><a href="/contacto">CONTACTO</a></li>
                </ul>
            </nav>

            <!-- ================= ICONOS ================= -->
            <div class="icons">

                <span>
                    <a href="/carrito">🛒</a>
                </span>

                <span>
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <a href="/mi-cuenta">
                            👤
                        </a>

                    <?php else: ?>
                        <a href="/login">
                            👤
                        </a>

                    <?php endif; ?>
                </span>

            </div>

            <!-- ================= MENÚ MOBILE ================= -->
            <button class="menu-toggle" aria-label="Abrir menú">☰</button>

            <!-- ================= OFF CANVAS ================= -->
            <div class="off-canvas-menu" id="off-canvas-menu">
                <button class="close-btn" aria-label="Cerrar menú">&times;</button>

                <nav>
                    <ul>
                        <li><a href="/coleccion">COLECCIÓN</a></li>
                        <li><a href="/nosotros">NOSOTROS</a></li>
                        <li><a href="/contacto">CONTACTO</a></li>
                    </ul>
                </nav>

            </div>

        </nav>

    </header>