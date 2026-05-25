<?php

require_once __DIR__ . '/../../models/Producto.php';

class ProductoController
{
    public function detalle()
    {
        // ================= VALIDAR ID =================
        if(!isset($_GET['id']))
        {
            header(
                'Location: ' .
                BASE_URL .
                '/coleccion'
            );
            exit;
        }

        $id = (int) $_GET['id'];

        // ================= MODELO =====================
        $productoModel = new Producto();

        // ================= PRODUCTO ===================
        $producto =
            $productoModel->obtenerPorId($id);

        // ================= VALIDAR ====================
        if(!$producto)
        {
            header(
                'Location: ' .
                BASE_URL .
                '/coleccion'
            );
            exit;
        }

        // ================= RELACIONADOS ===============
        $relacionados =
            $productoModel->obtenerRelacionados(
                $producto['categoria_id'],
                $producto['id']
            );

        // ================= METADATA ===================
        $titulo =
            'Malku - ' .
            $producto['nombre'];

        $css = "public/productos.css";

        // ================= VIEW =======================
        require_once __DIR__ .
            '/../../views/public/coleccion/detalle.php';
    }
}