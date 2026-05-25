<?php

require_once __DIR__ . '/../../models/producto.php';

class HomeController
{
    public function index()
    {
        // ================= TÍTULO DINÁMICO =================
        $titulo = "Malku - Home";

        // ================= CSS ESPECÍFICO ==================
        $css = "public/inicio.css";

        // ================= MODELO PRODUCTO =================
        $productoModel = new Producto();

        // ================= PRODUCTOS DESTACADOS ============
        $productosDestacados = $productoModel->obtenerDestacados(4);

        // ================= CARGAR VISTA ====================
        require_once __DIR__ . '/../../views/public/home/index.php';
    }

}