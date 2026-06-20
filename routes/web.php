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

/*
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
*/

// ======================================================
// CONTROLLERS ADMIN
// ======================================================

/*
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
*/

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
    // PANEL ADMIN
    // ==================================================
    case ($url === 'admin'):

        require_once __DIR__ .
            '/../app/middleware/AuthMiddleware.php';

        AuthMiddleware::verificar();

        AuthMiddleware::esAdmin();

        $titulo = 'Panel Administrativo | Malku';

        $css = 'admin/dashboard.css';

        require_once __DIR__ .
            '/../app/views/admin/dashboard/index.php';

        break;

    // ==================================================
    // PANEL USUARIO
    // ==================================================
    case ($url === 'usuario'):

        $controller =
            new DashboardUsuarioController();

        $controller->index();

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