<?php

require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../models/Carrito.php';
require_once __DIR__ . '/../../services/PedidoService.php';
require_once __DIR__ . '/../../repositories/CuponRepository.php';

class CheckoutController
{
    private $pedidoService;
    private $cuponRepo;

    public function __construct()
    {
        $this->pedidoService = new PedidoService();
        $this->cuponRepo     = new CuponRepository();
    }

    // ================= INDEX =================
    public function index()
    {
        AuthMiddleware::verificar();

        $carritoModel = new Carrito();
        $productos    = $carritoModel->obtenerProductos();

        if (empty($productos)) {
            header('Location: ' . BASE_URL . '/carrito');
            exit;
        }

        $subtotal = 0;
        foreach ($productos as $producto) {
            $subtotal += $producto['precio'] * $producto['cantidad'];
        }

        // Coupon from session
        $cuponAplicado = $_SESSION['cupon'] ?? null;
        $descuento     = 0;
        $cuponError    = $_SESSION['cupon_error'] ?? null;
        unset($_SESSION['cupon_error']);

        if ($cuponAplicado) {
            $error = $this->cuponRepo->validar(
                $cuponAplicado['codigo'],
                $subtotal,
                $_SESSION['usuario']['id']
            );
            if ($error) {
                unset($_SESSION['cupon']);
                $cuponAplicado = null;
                $cuponError    = $error;
            } else {
                $cuponData = $this->cuponRepo->obtenerPorCodigo($cuponAplicado['codigo']);
                $descuento = $this->cuponRepo->calcularDescuento($cuponData, $subtotal);
                $_SESSION['cupon']['descuento'] = $descuento;
            }
        }

        $total = max(0, $subtotal - $descuento);

        $titulo = 'Checkout | Malku';
        $css    = 'public/checkout.css';

        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/checkout/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= APLICAR CUPÓN =================
    public function aplicarCupon()
    {
        AuthMiddleware::verificar();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/checkout');
            exit;
        }

        $codigo = trim($_POST['codigo'] ?? '');

        if (!$codigo) {
            header('Location: ' . BASE_URL . '/checkout');
            exit;
        }

        // Calculate current subtotal
        $carritoModel = new Carrito();
        $productos    = $carritoModel->obtenerProductos();
        $subtotal     = 0;
        foreach ($productos as $p) {
            $subtotal += $p['precio'] * $p['cantidad'];
        }

        $error = $this->cuponRepo->validar($codigo, $subtotal, $_SESSION['usuario']['id']);

        if ($error) {
            $_SESSION['cupon_error'] = $error;
        } else {
            $cupon     = $this->cuponRepo->obtenerPorCodigo($codigo);
            $descuento = $this->cuponRepo->calcularDescuento($cupon, $subtotal);
            $_SESSION['cupon'] = [
                'id'        => $cupon['id'],
                'codigo'    => $cupon['codigo'],
                'tipo'      => $cupon['tipo'],
                'valor'     => $cupon['valor'],
                'descuento' => $descuento,
            ];
        }

        header('Location: ' . BASE_URL . '/checkout');
        exit;
    }

    // ================= QUITAR CUPÓN =================
    public function quitarCupon()
    {
        unset($_SESSION['cupon']);
        header('Location: ' . BASE_URL . '/checkout');
        exit;
    }

    // ================= PROCESAR =================
    public function procesar()
    {
        AuthMiddleware::verificar();

        $usuarioId     = $_SESSION['usuario']['id'];
        $cuponAplicado = $_SESSION['cupon'] ?? null;
        $descuento     = 0;

        if ($cuponAplicado) {
            // Re-validate before creating the order
            $carritoModel = new Carrito();
            $productos    = $carritoModel->obtenerProductos();
            $subtotal     = 0;
            foreach ($productos as $p) {
                $subtotal += $p['precio'] * $p['cantidad'];
            }

            $error = $this->cuponRepo->validar($cuponAplicado['codigo'], $subtotal, $usuarioId);
            if (!$error) {
                $cuponData = $this->cuponRepo->obtenerPorCodigo($cuponAplicado['codigo']);
                $descuento = $this->cuponRepo->calcularDescuento($cuponData, $subtotal);
            }
        }

        $pedidoId = $this->pedidoService->crearPedido($usuarioId, $descuento);

        if ($pedidoId) {
            // Mark coupon as used
            if ($cuponAplicado && $descuento > 0) {
                $this->cuponRepo->incrementarUso($cuponAplicado['id']);
            }
            unset($_SESSION['cupon']);

            header('Location: ' . BASE_URL . '/checkout/exito');
            exit;
        }

        header('Location: ' . BASE_URL . '/checkout');
        exit;
    }

    // ================= ÉXITO =================
    public function exito()
    {
        AuthMiddleware::verificar();

        $titulo = 'Compra realizada';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/checkout/exito.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}
