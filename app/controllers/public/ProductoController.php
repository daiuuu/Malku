<?php

require_once __DIR__ .
    '/../../models/Producto.php';

class ProductoController
{
    // ================= DETALLE PRODUCTO =================
    public function detalle($slug)
    {
        // ================= MODELO =====================
        $productoModel = new Producto();

        // ================= PRODUCTO ===================
        $producto =
            $productoModel->obtenerPorSlug($slug);

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