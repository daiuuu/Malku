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

// ======================================================
// CONTROLLERS USUARIO
// ======================================================

require_once __DIR__ .
    '/../app/controllers/usuario/DashboardUsuarioController.php';

require_once __DIR__ .
    '/../app/controllers/usuario/PedidoUsuarioController.php';

require_once __DIR__ .
    '/../app/controllers/usuario/PerfilUsuarioController.php';

require_once __DIR__ .
    '/../app/controllers/usuario/DireccionUsuarioController.php';

require_once __DIR__ .
    '/../app/controllers/usuario/FavoritoUsuarioController.php';

require_once __DIR__ .
    '/../app/controllers/usuario/MembresiaUsuarioController.php';

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
    '/../app/controllers/admin/CuponAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/StockAdminController.php';

require_once __DIR__ .
    '/../app/controllers/admin/AnalyticsAdminController.php';

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
    // PRODUCTO DETALLE
    // ==================================================
    case preg_match(
        '/^producto\/([a-zA-Z0-9\-]+)$/',
        $url,
        $matches
    ):

        $slug = $matches[1];

        $controller = new ProductoController();

        $controller->show($slug);

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
    // PROCESAR LOGIN
    // ==================================================
    case ($url === 'login/procesar'):

        $controller = new AuthController();

        $controller->procesarLogin();

        break;

    // ==================================================
    // REGISTRO
    // ==================================================
    case ($url === 'registro'):

        $controller = new AuthController();

        $controller->registro();

        break;

    // ==================================================
    // PROCESAR REGISTRO
    // ==================================================
    case ($url === 'registro/procesar'):

        $controller = new AuthController();

        $controller->procesarRegistro();

        break;

    // ==================================================
    // LOGOUT
    // ==================================================
    case ($url === 'logout'):

        $controller = new AuthController();

        $controller->logout();

        break;

    // ==================================================
    // CHECKOUT
    // ==================================================
    case ($url === 'checkout'):

        $controller = new CheckoutController();

        $controller->index();

        break;

    // ==================================================
    // PROCESAR CHECKOUT
    // ==================================================
    case ($url === 'checkout/procesar'):

        $controller = new CheckoutController();

        $controller->procesar();

        break;

    // ==================================================
    // FAVORITOS
    // ==================================================
    case ($url === 'favoritos'):

        $controller = new FavoritoUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // AGREGAR FAVORITO
    // ==================================================
    case ($url === 'favoritos/agregar'):

        $controller = new FavoritoUsuarioController();

        $controller->agregar();

        break;

    // ==================================================
    // ELIMINAR FAVORITO
    // ==================================================
    case ($url === 'favoritos/eliminar'):

        $controller = new FavoritoUsuarioController();

        $controller->eliminar();

        break;

    // ==================================================
    // PERFIL USUARIO
    // ==================================================
    case ($url === 'mi-perfil'):

        $controller = new PerfilUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // ACTUALIZAR PERFIL
    // ==================================================
    case ($url === 'mi-perfil/actualizar'):

        $controller = new PerfilUsuarioController();

        $controller->actualizar();

        break;

    // ==================================================
    // PEDIDOS USUARIO
    // ==================================================
    case ($url === 'mis-pedidos'):

        $controller = new PedidoUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // DETALLE PEDIDO
    // ==================================================
    case preg_match(
        '/^mis-pedidos\/([0-9]+)$/',
        $url,
        $matches
    ):

        $pedidoId = $matches[1];

        $controller = new PedidoUsuarioController();

        $controller->detalle($pedidoId);

        break;

    // ==================================================
    // DIRECCIONES
    // ==================================================
    case ($url === 'mis-direcciones'):

        $controller = new DireccionUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // MEMBRESÍA
    // ==================================================
    case ($url === 'membresia'):

        $controller = new MembresiaUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // DASHBOARD USUARIO
    // ==================================================
    case ($url === 'dashboard'):

        $controller = new DashboardUsuarioController();

        $controller->index();

        break;

    // ==================================================
    // ENVÍOS
    // ==================================================
    case ($url === 'envios'):

        require_once __DIR__ .
            '/../app/views/public/internos/envios_devoluciones.php';

        break;

    // ==================================================
    // DEVOLUCIONES
    // ==================================================
    case ($url === 'devoluciones'):

        require_once __DIR__ .
            '/../app/views/public/internos/envios_devoluciones.php';

        break;

    // ==================================================
    // PANEL ADMIN
    // ==================================================
    case ($url === 'admin'):

        $controller = new DashboardAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN PRODUCTOS
    // ==================================================
    case ($url === 'admin/productos'):

        $controller = new ProductoAdminController();

        $controller->index();

        break;

    // ==================================================
    // CREAR PRODUCTO
    // ==================================================
    case ($url === 'admin/productos/crear'):

        $controller = new ProductoAdminController();

        $controller->crear();

        break;

    // ==================================================
    // EDITAR PRODUCTO
    // ==================================================
    case preg_match(
        '/^admin\/productos\/editar\/([0-9]+)$/',
        $url,
        $matches
    ):

        $productoId = $matches[1];

        $controller = new ProductoAdminController();

        $controller->editar($productoId);

        break;

    // ==================================================
    // ELIMINAR PRODUCTO
    // ==================================================
    case preg_match(
        '/^admin\/productos\/eliminar\/([0-9]+)$/',
        $url,
        $matches
    ):

        $productoId = $matches[1];

        $controller = new ProductoAdminController();

        $controller->eliminar($productoId);

        break;

    // ==================================================
    // ADMIN PEDIDOS
    // ==================================================
    case ($url === 'admin/pedidos'):

        $controller = new PedidoAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN USUARIOS
    // ==================================================
    case ($url === 'admin/usuarios'):

        $controller = new UsuarioAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN CONTACTO
    // ==================================================
    case ($url === 'admin/contacto'):

        $controller = new ContactoAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN CUPONES
    // ==================================================
    case ($url === 'admin/cupones'):

        $controller = new CuponAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN STOCK
    // ==================================================
    case ($url === 'admin/stock'):

        $controller = new StockAdminController();

        $controller->index();

        break;

    // ==================================================
    // ADMIN ANALYTICS
    // ==================================================
    case ($url === 'admin/analytics'):

        $controller = new AnalyticsAdminController();

        $controller->index();

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

                <a
                    href="' . BASE_URL . '"
                    style="
                        text-decoration: none;
                        color: black;
                        border: 1px solid black;
                        padding: 12px 24px;
                    "
                >
                    Volver al inicio
                </a>

            </main>
        ';

        break;
}