<?php

// ======================================================
// INICIAR SESIÓN
// ======================================================

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

// ======================================================
// CONTROLLERS PÚBLICOS
// ======================================================

require_once __DIR__ .
    '/../app/controllers/public/HomeController.php';

require_once __DIR__ .
    '/../app/controllers/public/ColeccionController.php';

require_once __DIR__ .
    '/../app/controllers/public/ProductoController.php';

require_once __DIR__ .
    '/../app/controllers/public/NosotrosController.php';

require_once __DIR__ .
    '/../app/controllers/public/ContactoController.php';

require_once __DIR__ .
    '/../app/controllers/public/CarritoController.php';

require_once __DIR__ .
    '/../app/controllers/public/AuthController.php';

require_once __DIR__ .
    '/../app/controllers/public/CheckoutController.php';

require_once __DIR__ .
    '/../app/controllers/public/EnviosDevolucionesController.php';

// ======================================================
// CONTROLLERS USUARIO
// ======================================================

require_once __DIR__ .
    '/../app/controllers/usuario/DashboardUsuarioController.php';

// ======================================================
// CONTROLLERS ADMIN
// ======================================================

require_once __DIR__ .
    '/../app/controllers/admin/DashboardAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/ProductoAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/CategoriaAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/PedidoAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/UsuarioAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/ContactoAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/StockAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/AnalyticsAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/CuponAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/ConfiguracionAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/MembresiaAdminController.php';

require_once __DIR__ .
    '/../app/repositories/CuponRepository.php';

// ======================================================
// URL ACTUAL
// ======================================================

$url = $_GET['url'] ?? '';

// ======================================================
// LIMPIAR URL
// ======================================================

$url = trim($url, '/');

// ======================================================
// ROUTES
// ======================================================

switch(true)
{
    // ==================================================
    // HOME
    // ==================================================
    case ($url === ''):

        $controller = new HomeController();

        $controller->index();

        break;

    // ==================================================
    // COLECCIÓN
    // ==================================================
    case ($url === 'coleccion'):

        $controller = new ColeccionController();

        $controller->index();

        break;

    // ==================================================
    // COLECCIÓN - AJAX CARGAR MÁS
    // ==================================================
    case ($url === 'coleccion/buscar'):

        $controller = new ColeccionController();

        $controller->buscar();

        break;

    // ==================================================
    // PRODUCTO DETALLE
    // ==================================================
    case (strpos($url, 'producto/') === 0):

        $slug = substr($url, strlen('producto/'));

        $controller = new ProductoController();

        $controller->detalle($slug);

        break;

    // ==================================================
    // NOSOTROS
    // ==================================================
    case ($url === 'nosotros'):

        $controller = new NosotrosController();

        $controller->index();

        break;

    // ==================================================
    // CONTACTO
    // ==================================================
    case ($url === 'contacto'):

        $controller = new ContactoController();

        $controller->index();

        break;

    // ==================================================
    // ENVIAR CONTACTO
    // ==================================================
    case ($url === 'contacto/enviar'):

        $controller = new ContactoController();

        $controller->enviar();

        break;

    // ==================================================
    // CARRITO
    // ==================================================
    case ($url === 'carrito'):

        $controller = new CarritoController();

        $controller->index();

        break;

    // ==================================================
    // AGREGAR AL CARRITO
    // ==================================================
    case ($url === 'carrito/agregar'):

        $controller = new CarritoController();

        $controller->agregar();

        break;

    // ==================================================
    // ELIMINAR DEL CARRITO
    // ==================================================
    case ($url === 'carrito/eliminar'):

        $controller = new CarritoController();

        $controller->eliminar();

        break;

    // ==================================================
    // ACTUALIZAR CARRITO
    // ==================================================
    case ($url === 'carrito/actualizar'):

        $controller = new CarritoController();

        $controller->actualizar();

        break;

    // ==================================================
    // LOGIN
    // ==================================================
    case ($url === 'login'):

        $controller = new AuthController();

        $controller->login();

        break;

    // ==================================================
    // LOGIN POST
    // ==================================================
    case ($url === 'login/autenticar'):

        $controller = new AuthController();

        $controller->autenticar();

        break;

    // ==================================================
    // REGISTRO
    // ==================================================
    case ($url === 'registro'):

        $controller = new AuthController();

        $controller->registro();

        break;

    // ==================================================
    // REGISTRO POST
    // ==================================================
    case ($url === 'registro/guardar'):

        $controller = new AuthController();

        $controller->guardarRegistro();

        break;

    // ==================================================
    // RECUPERAR CONTRASEÑA
    // ==================================================
    case ($url === 'recuperar-password'):

        $controller = new AuthController();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $controller->enviarRecuperacion();
        }
        else
        {
            $controller->recuperarPassword();
        }

        break;

    // ==================================================
    // NUEVA CONTRASEÑA (GET muestra form, POST procesa)
    // ==================================================
    case ($url === 'nueva-password'):

        $controller = new AuthController();

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $controller->procesarNuevaPassword();
        }
        else
        {
            $controller->mostrarNuevaPassword();
        }

        break;

    // ==================================================
    // LOGOUT
    // ==================================================
    case ($url === 'logout'):

        $controller = new AuthController();

        $controller->logout();

        break;

    // ==================================================
    // PANEL ADMIN — todas las rutas /admin/*
    // ==================================================
    case (strpos($url, 'admin') === 0):

        AuthMiddleware::verificar();
        AuthMiddleware::esAdmin();

        $css = 'admin/admin.css?v=2';

        // ---- DASHBOARD ----
        if ($url === 'admin') {
            $c = new DashboardAdminController();
            $c->index();

        // ---- PRODUCTOS ----
        } elseif ($url === 'admin/productos') {
            $c = new ProductoAdminController();
            $c->index();

        } elseif ($url === 'admin/productos/crear') {
            $c = new ProductoAdminController();
            $c->crear();

        } elseif ($url === 'admin/productos/guardar') {
            $c = new ProductoAdminController();
            $c->guardar();

        } elseif (preg_match('#^admin/productos/editar/(\d+)$#', $url, $m)) {
            $c = new ProductoAdminController();
            $c->editar((int)$m[1]);

        } elseif ($url === 'admin/productos/actualizar') {
            $c = new ProductoAdminController();
            $c->actualizar();

        } elseif ($url === 'admin/productos/eliminar') {
            $c = new ProductoAdminController();
            $c->eliminar();

        // ---- CATEGORÍAS ----
        } elseif ($url === 'admin/categorias') {
            $c = new CategoriaAdminController();
            $c->index();

        } elseif ($url === 'admin/categorias/crear') {
            $c = new CategoriaAdminController();
            $c->crear();

        } elseif ($url === 'admin/categorias/guardar') {
            $c = new CategoriaAdminController();
            $c->guardar();

        } elseif (preg_match('#^admin/categorias/editar/(\d+)$#', $url, $m)) {
            $c = new CategoriaAdminController();
            $c->editar((int)$m[1]);

        } elseif ($url === 'admin/categorias/actualizar') {
            $c = new CategoriaAdminController();
            $c->actualizar();

        } elseif ($url === 'admin/categorias/eliminar') {
            $c = new CategoriaAdminController();
            $c->eliminar();

        // ---- PEDIDOS ----
        } elseif ($url === 'admin/pedidos') {
            $c = new PedidoAdminController();
            $c->index();

        } elseif (preg_match('#^admin/pedidos/(\d+)$#', $url, $m)) {
            $c = new PedidoAdminController();
            $c->detalle((int)$m[1]);

        } elseif ($url === 'admin/pedidos/cambiar-estado') {
            $c = new PedidoAdminController();
            $c->cambiarEstado();

        // ---- USUARIOS ----
        } elseif ($url === 'admin/usuarios') {
            $c = new UsuarioAdminController();
            $c->index();

        } elseif ($url === 'admin/usuarios/cambiar-rol') {
            $c = new UsuarioAdminController();
            $c->cambiarRol();

        } elseif ($url === 'admin/usuarios/cambiar-estado') {
            $c = new UsuarioAdminController();
            $c->cambiarEstado();

        // ---- CONTACTO ----
        } elseif ($url === 'admin/contacto') {
            $c = new ContactoAdminController();
            $c->index();

        } elseif ($url === 'admin/contacto/cambiar-estado') {
            $c = new ContactoAdminController();
            $c->cambiarEstado();

        } elseif ($url === 'admin/contacto/responder') {
            $c = new ContactoAdminController();
            $c->responder();

        // ---- STOCK ----
        } elseif ($url === 'admin/stock') {
            $c = new StockAdminController();
            $c->index();

        } elseif ($url === 'admin/stock/ajustar') {
            $c = new StockAdminController();
            $c->ajustar();

        // ---- ANALYTICS ----
        } elseif ($url === 'admin/analytics') {
            $c = new AnalyticsAdminController();
            $c->index();

        // ---- CUPONES ----
        } elseif ($url === 'admin/cupones') {
            $c = new CuponAdminController();
            $c->index();

        } elseif ($url === 'admin/cupones/crear') {
            $c = new CuponAdminController();
            $c->crear();

        } elseif ($url === 'admin/cupones/guardar') {
            $c = new CuponAdminController();
            $c->guardar();

        } elseif (preg_match('#^admin/cupones/editar/(\d+)$#', $url, $m)) {
            $c = new CuponAdminController();
            $c->editar((int)$m[1]);

        } elseif ($url === 'admin/cupones/actualizar') {
            $c = new CuponAdminController();
            $c->actualizar();

        } elseif ($url === 'admin/cupones/eliminar') {
            $c = new CuponAdminController();
            $c->eliminar();

        } elseif (preg_match('#^admin/cupones/regalar/(\d+)$#', $url, $m)) {
            $c = new CuponAdminController();
            $c->regalar((int)$m[1]);

        // ---- MEMBRESÍAS ----
        } elseif ($url === 'admin/membresias') {
            $c = new MembresiaAdminController();
            $c->index();

        } elseif (preg_match('#^admin/membresias/asignar/(\d+)$#', $url, $m)) {
            $c = new MembresiaAdminController();
            $c->asignar((int)$m[1]);

        } elseif ($url === 'admin/membresias/guardar') {
            $c = new MembresiaAdminController();
            $c->guardar();

        } elseif ($url === 'admin/membresias/eliminar') {
            $c = new MembresiaAdminController();
            $c->eliminar();

        } elseif ($url === 'admin/membresias/cambiar-estado') {
            $c = new MembresiaAdminController();
            $c->cambiarEstado();

        } elseif ($url === 'admin/membresias/beneficios') {
            $c = new MembresiaAdminController();
            $c->beneficios();

        } elseif ($url === 'admin/membresias/beneficios/crear') {
            $c = new MembresiaAdminController();
            $c->beneficioCrear();

        } elseif ($url === 'admin/membresias/beneficios/guardar') {
            $c = new MembresiaAdminController();
            $c->beneficioGuardar();

        } elseif (preg_match('#^admin/membresias/beneficios/editar/(\d+)$#', $url, $m)) {
            $c = new MembresiaAdminController();
            $c->beneficioEditar((int)$m[1]);

        } elseif ($url === 'admin/membresias/beneficios/actualizar') {
            $c = new MembresiaAdminController();
            $c->beneficioActualizar();

        } elseif ($url === 'admin/membresias/beneficios/eliminar') {
            $c = new MembresiaAdminController();
            $c->beneficioEliminar();

        // ---- CONFIGURACIÓN ----
        } elseif ($url === 'admin/configuracion/contacto') {
            $c = new ConfiguracionAdminController();
            $c->contacto();

        } elseif ($url === 'admin/configuracion/contacto/guardar') {
            $c = new ConfiguracionAdminController();
            $c->guardarContacto();

        } elseif ($url === 'admin/configuracion/envios') {
            $c = new ConfiguracionAdminController();
            $c->envios();

        } elseif ($url === 'admin/configuracion/envios/guardar') {
            $c = new ConfiguracionAdminController();
            $c->guardarEnvios();

        } else {
            http_response_code(404);
            echo '<h1>404 — Sección no encontrada</h1>';
        }

        break;

    // ==================================================
    // PANEL USUARIO — todas las rutas /usuario/*
    // ==================================================
    case (strpos($url, 'usuario') === 0):

        AuthMiddleware::verificar();

        $c = new DashboardUsuarioController();

        // ---- DASHBOARD ----
        if ($url === 'usuario') {
            $c->index();

        // ---- PEDIDOS ----
        } elseif ($url === 'usuario/pedidos') {
            $c->pedidos();

        } elseif (preg_match('#^usuario/pedidos/(\d+)$#', $url, $m)) {
            $c->pedidoDetalle((int)$m[1]);

        // ---- PERFIL ----
        } elseif ($url === 'usuario/perfil') {
            $c->perfil();

        } elseif ($url === 'usuario/perfil/guardar') {
            $c->guardarPerfil();

        } elseif ($url === 'usuario/perfil/cambiar-password') {
            $c->cambiarPassword();

        // ---- DIRECCIONES ----
        } elseif ($url === 'usuario/direcciones') {
            $c->direcciones();

        } elseif ($url === 'usuario/direcciones/nueva') {
            $c->nuevaDireccion();

        } elseif ($url === 'usuario/direcciones/guardar') {
            $c->guardarDireccion();

        } elseif (preg_match('#^usuario/direcciones/editar/(\d+)$#', $url, $m)) {
            $c->editarDireccion((int)$m[1]);

        } elseif ($url === 'usuario/direcciones/actualizar') {
            $c->actualizarDireccion();

        } elseif ($url === 'usuario/direcciones/eliminar') {
            $c->eliminarDireccion();

        } elseif ($url === 'usuario/direcciones/principal') {
            $c->marcarPrincipal();

        // ---- FAVORITOS ----
        } elseif ($url === 'usuario/favoritos') {
            $c->favoritos();

        } elseif ($url === 'usuario/favoritos/agregar') {
            $c->agregarFavorito();

        } elseif ($url === 'usuario/favoritos/toggle') {
            $c->toggleFavorito();

        } elseif ($url === 'usuario/favoritos/eliminar') {
            $c->eliminarFavorito();

        // ---- CUPONES ----
        } elseif ($url === 'usuario/cupones') {
            $c->cupones();

        // ---- MEMBRESÍA ----
        } elseif ($url === 'usuario/membresia') {
            $c->membresia();

        } else {
            http_response_code(404);
            echo '<h1>404 — Sección no encontrada</h1>';
        }

        break;

    // ==================================================
    // ENVÍOS & DEVOLUCIONES
    // ==================================================
    // Alias corto: /envios -> misma vista de envíos y devoluciones
    case ($url === 'envios'):

        $controller = new EnviosDevolucionesController();

        $controller->index();

        break;

    case ($url === 'envios-devoluciones'):

        $controller = new EnviosDevolucionesController();

        $controller->index();

        break;
    
    // ================= CHECKOUT =================
    case ($url === 'checkout'):

        $controller = new CheckoutController();

        $controller->index();

        break;

    // ================= APLICAR CUPÓN EN CHECKOUT =================
    case ($url === 'checkout/aplicar-cupon'):

        $controller = new CheckoutController();
        $controller->aplicarCupon();
        break;

    // ================= QUITAR CUPÓN EN CHECKOUT =================
    case ($url === 'checkout/quitar-cupon'):

        $controller = new CheckoutController();
        $controller->quitarCupon();
        break;

    // ================= PROCESAR CHECKOUT =================
    case ($url === 'checkout/procesar'):

        $controller = new CheckoutController();

        $controller->procesar();

        break;

    // ================= CHECKOUT ÉXITO =================
    case ($url === 'checkout/exito'):

        $controller = new CheckoutController();

        $controller->exito();

        break;

    // ==================================================
    // ERROR 404
    // ==================================================
    default:

        http_response_code(404);

        echo '
            <main
                style="
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-direction: column;
                    font-family: Arial;
                    gap: 20px;
                "
            >

                <h1
                    style="
                        font-size: 70px;
                        margin: 0;
                    "
                >
                    404
                </h1>

                <p
                    style="
                        font-size: 18px;
                        color: #555;
                    "
                >
                    Página no encontrada
                </p>

            </main>
        ';

        break;
}