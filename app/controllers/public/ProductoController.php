<?php

require_once __DIR__ . '/../../models/Producto.php';
require_once __DIR__ . '/../../repositories/FavoritoRepository.php';

class ProductoController
{
    // ================= DETALLE PRODUCTO =================
    public function detalle($slug)
    {
        $productoModel = new Producto();
        $producto      = $productoModel->obtenerPorSlug($slug);

        if (!$producto) {
            header('Location: ' . BASE_URL . '/coleccion');
            exit;
        }

        $relacionados = $productoModel->obtenerRelacionados(
            $producto['categoria_id'],
            $producto['id']
        );

        $logueado = isset($_SESSION['usuario']);
        $esFav    = false;

        if ($logueado) {
            $favRepo = new FavoritoRepository();
            $esFav   = (bool) $favRepo->existe(
                (int) $_SESSION['usuario']['id'],
                (int) $producto['id']
            );
        }

        $titulo = 'Malku — ' . $producto['nombre'];
        $css    = 'public/productos.css';

        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/coleccion/detalle.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}