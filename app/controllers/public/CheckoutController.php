<?php

require_once __DIR__ .
    '/../../middleware/AuthMiddleware.php';

require_once __DIR__ .
    '/../../models/Carrito.php';

require_once __DIR__ .
    '/../../services/PedidoService.php';

class CheckoutController
{
    private $pedidoService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->pedidoService =
            new PedidoService();
    }

    // ================= INDEX =================
    public function index()
    {
        // ================= LOGIN OBLIGATORIO =================
        AuthMiddleware::verificar();

        // ================= CARRITO =================
        $carritoModel = new Carrito();

        $productos =
            $carritoModel->obtenerProductos();

        // ================= VALIDAR =================
        if(empty($productos))
        {
            header(
                'Location: ' .
                BASE_URL .
                '/carrito'
            );

            exit;
        }

        // ================= TOTAL =================
        $total = 0;

        foreach($productos as $producto)
        {
            $total +=
                $producto['precio']
                * $producto['cantidad'];
        }

        // ================= METADATA =================
        $titulo = 'Checkout | Malku';

        $css = 'public/checkout.css';

        // ================= VIEW =================
        require_once __DIR__ .
            '/../../views/public/checkout/index.php';
    }

    // ================= PROCESAR =================
    public function procesar()
    {
        // ================= LOGIN OBLIGATORIO =================
        AuthMiddleware::verificar();

        $usuarioId =
            $_SESSION['usuario']['id'];

        // ================= CREAR PEDIDO =================
        $pedidoId =
            $this->pedidoService
                ->crearPedido($usuarioId);

        // ================= REDIRECT =================
        if($pedidoId)
        {
            header(
                'Location: ' .
                BASE_URL .
                '/checkout/exito'
            );

            exit;
        }

        header(
            'Location: ' .
            BASE_URL .
            '/checkout'
        );

        exit;
    }

    // ================= ÉXITO =================
    public function exito()
    {
        AuthMiddleware::verificar();

        $titulo = 'Compra realizada';

        require_once __DIR__ .
            '/../../views/public/checkout/exito.php';
    }
}