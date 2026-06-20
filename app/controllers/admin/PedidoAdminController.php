<?php

require_once __DIR__ . '/../../repositories/PedidoRepository.php';

class PedidoAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PedidoRepository();
    }

    public function index()
    {
        $pedidos = $this->repo->obtenerTodos();
        $titulo  = 'Pedidos | Admin Malku';
        require_once __DIR__ . '/../../views/admin/pedidos/index.php';
    }

    public function detalle($id)
    {
        $pedido  = $this->repo->obtenerPorId($id);
        $detalle = $this->repo->obtenerDetalle($id);

        if (!$pedido) {
            header('Location: ' . BASE_URL . '/admin/pedidos');
            exit;
        }

        $titulo = 'Pedido #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' | Admin Malku';
        require_once __DIR__ . '/../../views/admin/pedidos/detalle.php';
    }

    public function cambiarEstado()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $estados = ['pendiente','pagado','preparando','despachado','entregado','cancelado'];

        if ($id && in_array($estado, $estados)) {
            $this->repo->cambiarEstado($id, $estado);
        }

        header('Location: ' . BASE_URL . '/admin/pedidos/' . $id);
        exit;
    }
}
