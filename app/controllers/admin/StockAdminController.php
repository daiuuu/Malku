<?php

require_once __DIR__ . '/../../repositories/ProductoRepository.php';

class StockAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ProductoRepository();
    }

    public function index()
    {
        $productos = $this->repo->obtenerTodos();
        $css       = 'admin/admin.css?v=2';
        $titulo    = 'Stock | Admin Malku';
        require_once __DIR__ . '/../../views/admin/stock/index.php';
    }

    public function ajustar()
    {
        $id       = (int)($_POST['id'] ?? 0);
        $cantidad = (int)($_POST['cantidad'] ?? 0);

        if ($id && $cantidad !== 0) {
            $this->repo->ajustarStock($id, $cantidad);
            $_SESSION['admin_ok'] = 'Stock ajustado.';
        }

        header('Location: ' . BASE_URL . '/admin/stock');
        exit;
    }
}
