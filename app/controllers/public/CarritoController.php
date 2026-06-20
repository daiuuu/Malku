<?php

require_once __DIR__ . '/../../services/CarritoService.php';
require_once __DIR__ . '/../../repositories/CarritoCompartidoRepository.php';

class CarritoController
{
    private $carritoService;
    private $compartidoRepo;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->carritoService = new CarritoService();
        $this->compartidoRepo = new CarritoCompartidoRepository();
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

    // ================= COMPARTIR (AJAX) ============
    public function compartir()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Método inválido']);
            exit;
        }

        $carrito = $this->carritoService->obtenerCarrito();

        if (empty($carrito)) {
            echo json_encode(['error' => 'El carrito está vacío']);
            exit;
        }

        $usuarioId = $_SESSION['usuario']['id']     ?? null;
        $nombre    = $_SESSION['usuario']['nombre'] ?? null;

        $codigo = $this->compartidoRepo->crear([
            'usuario_id' => $usuarioId,
            'nombre'     => $nombre,
            'items'      => array_values($carrito),
        ]);

        echo json_encode([
            'url'    => BASE_URL . '/carrito/compartido/' . $codigo,
            'codigo' => $codigo,
        ]);
        exit;
    }

    // ================= VER COMPARTIDO ==============
    public function verCompartido(string $codigo)
    {
        $lista = $this->compartidoRepo->obtenerPorCodigo($codigo);

        if (!$lista) {
            renderError(404, 'Lista no encontrada',
                'Esta lista compartida no existe o fue desactivada.');
            return;
        }

        $items = $lista['items'];
        $total = array_reduce(
            $items,
            fn($carry, $i) => $carry + ($i['precio'] * $i['cantidad']),
            0
        );
        $propietario = $lista['nombre'];

        $titulo = 'Lista compartida' . ($propietario ? ' de ' . $propietario : '') . ' | Malku';
        $css    = 'public/carrito.css';

        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/carrito/compartido.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= AGREGAR DESDE COMPARTIDO ====
    public function agregarDesdeCompartido(string $codigo)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/carrito/compartido/' . $codigo);
            exit;
        }

        $lista = $this->compartidoRepo->obtenerPorCodigo($codigo);

        if (!$lista) {
            header('Location: ' . BASE_URL . '/carrito');
            exit;
        }

        $seleccionados = $_POST['items'] ?? [];
        if (!is_array($seleccionados)) $seleccionados = [];

        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];

        $agregados = 0;
        foreach ($lista['items'] as $item) {
            if (!in_array((string)$item['id'], $seleccionados, true)) continue;

            $key = $item['id'];
            if (isset($_SESSION['carrito'][$key])) {
                $_SESSION['carrito'][$key]['cantidad'] += (int)$item['cantidad'];
            } else {
                $_SESSION['carrito'][$key] = $item;
            }
            $agregados++;
        }

        $_SESSION['carrito_exito'] = $agregados > 0
            ? ($agregados === 1 ? '1 producto agregado al carrito.' : "$agregados productos agregados al carrito.")
            : 'No seleccionaste ningún producto.';

        header('Location: ' . BASE_URL . '/carrito');
        exit;
    }
}