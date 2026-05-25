<?php

require_once __DIR__ . '/../../services/CarritoService.php';

class CarritoController
{
    private $carritoService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->carritoService =
            new CarritoService();
    }

    // ================= INDEX =======================
    public function index()
    {
        // ================= TÍTULO ===================
        $titulo = 'Malku - Carrito';

        // ================= CSS ======================
        $css = 'public/carrito.css';

        // ================= CARRITO ==================
        $carrito =
            $this->carritoService->obtenerCarrito();

        // ================= TOTAL ====================
        $total =
            $this->carritoService->obtenerTotal();

        // ================= ITEMS ====================
        $cantidadItems =
            $this->carritoService
                ->obtenerCantidadItems();

        // ================= VIEW =====================
        require_once __DIR__ .
            '/../../views/public/carrito/index.php';
    }

    // ================= AGREGAR =====================
    public function agregar()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header(
                'Location: ' .
                BASE_URL .
                '/coleccion'
            );

            exit;
        }

        $idProducto =
            (int) ($_POST['producto_id'] ?? 0);

        $cantidad =
            (int) ($_POST['cantidad'] ?? 1);

        $agregado =
            $this->carritoService
                ->agregarProducto(
                    $idProducto,
                    $cantidad
                );

        if($agregado)
        {
            $_SESSION['carrito_exito'] =
                'Producto agregado al carrito.';
        }
        else
        {
            $_SESSION['carrito_error'] =
                'No se pudo agregar el producto.';
        }

        header(
            'Location: ' .
            BASE_URL .
            '/carrito'
        );

        exit;
    }

    // ================= ACTUALIZAR ==================
    public function actualizar()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header(
                'Location: ' .
                BASE_URL .
                '/carrito'
            );

            exit;
        }

        $idProducto =
            (int) ($_POST['producto_id'] ?? 0);

        $cantidad =
            (int) ($_POST['cantidad'] ?? 1);

        $this->carritoService
            ->actualizarCantidad(
                $idProducto,
                $cantidad
            );

        header(
            'Location: ' .
            BASE_URL .
            '/carrito'
        );

        exit;
    }

    // ================= ELIMINAR ====================
    public function eliminar()
    {
        $idProducto =
            (int) ($_GET['id'] ?? 0);

        $this->carritoService
            ->eliminarProducto(
                $idProducto
            );

        header(
            'Location: ' .
            BASE_URL .
            '/carrito'
        );

        exit;
    }
}