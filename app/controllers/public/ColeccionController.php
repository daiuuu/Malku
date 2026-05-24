<?php

require_once __DIR__ . '/../../models/producto.php';
require_once __DIR__ . '/../../models/categoria.php';

class ColeccionController
{
    public function index()
    {
        // ================= TÍTULO DINÁMICO ==============
        $titulo = "Malku - Colección";

        // ================= CSS ESPECÍFICO ===============
        $css = "public/coleccion.css";

        // ================= MODELOS ======================
        $productoModel = new Producto();
        $categoriaModel = new Categoria();

        // ================= FILTROS ======================
        $buscar = $_GET['buscar'] ?? null;
        $categoria = $_GET['categoria'] ?? null;
        $orden = $_GET['orden'] ?? 'nuevos';

        $pagina = isset($_GET['pagina'])
            ? (int) $_GET['pagina']
            : 1;

        $limite = 6;

        $offset = ($pagina - 1) * $limite;

        // ================= PRODUCTOS ====================
        $productos = $productoModel->obtenerColeccion(
            $buscar,
            $categoria,
            $orden,
            $limite,
            $offset
        );

        // ================= TOTAL PRODUCTOS ==============
        $totalProductos = $productoModel->contarProductos(
            $buscar,
            $categoria
        );

        // ================= PAGINACIÓN ===================
        $hayMasProductos = (
            ($offset + $limite) < $totalProductos
        );

        // ================= CATEGORÍAS ===================
        $categorias = $categoriaModel->obtenerTodas();

        // ================= CARGAR VISTA =================
        require_once __DIR__ . '/../../views/public/coleccion/index.php';
    }
}