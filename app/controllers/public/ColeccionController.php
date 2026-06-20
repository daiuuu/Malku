<?php

require_once __DIR__ . '/../../models/Producto.php';
require_once __DIR__ . '/../../models/Categoria.php';
require_once __DIR__ . '/../../repositories/FavoritoRepository.php';

class ColeccionController
{
    public function index()
    {
        // ================= TÍTULO DINÁMICO =================
        $titulo = "Malku - Colección";

        // ================= CSS ESPECÍFICO ==================
        $css = "public/coleccion.css";

        // ================= MODELOS =========================
        $productoModel = new Producto();

        $categoriaModel = new Categoria();

        // ================= FILTROS =========================
        $buscar = trim($_GET['buscar'] ?? '');

        $categoria = $_GET['categoria'] ?? null;

        $orden = $_GET['orden'] ?? 'nuevos';

        // ================= PAGINACIÓN ======================
        $pagina = isset($_GET['pagina'])
            ? max(1, (int) $_GET['pagina'])
            : 1;

        $limite = 6;

        $offset = ($pagina - 1) * $limite;

        // ================= PRODUCTOS =======================
        $productos = $productoModel->obtenerColeccion(
            $buscar,
            $categoria,
            $orden,
            $limite,
            $offset
        );

        // ================= TOTAL PRODUCTOS =================
        $totalProductos = $productoModel->contarProductos(
            $buscar,
            $categoria
        );

        // ================= PAGINACIÓN ======================
        $hayMasProductos =
            ($offset + $limite) < $totalProductos;

        // ================= CATEGORÍAS ======================
        $categorias = $categoriaModel->obtenerTodas();

        // ================= FAVORITOS DEL USUARIO ===========
        $favoritosIds = [];
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] !== 'admin') {
            $favRepo      = new FavoritoRepository();
            $favoritosIds = $favRepo->obtenerProductoIdsPorUsuario((int)$_SESSION['usuario']['id']);
        }

        // ================= CARGAR VISTA ====================
        require_once __DIR__ .
            '/../../views/public/coleccion/index.php';
    }

    public function buscar()
    {
        $productoModel = new Producto();

        $buscar = trim($_GET['buscar'] ?? '');
        $categoria = $_GET['categoria'] ?? null;
        $orden = $_GET['orden'] ?? 'nuevos';
        $pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;

        $limite = 6;
        $offset = ($pagina - 1) * $limite;

        $productos = $productoModel->obtenerColeccion(
            $buscar,
            $categoria,
            $orden,
            $limite,
            $offset
        );

        $totalProductos = $productoModel->contarProductos(
            $buscar,
            $categoria
        );

        $result = [];

        foreach ($productos as $producto) {
            $result[] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'slug' => $producto['slug'],
                'precio' => (float) $producto['precio'],
                'imagen_principal' => $producto['imagen_principal'],
                'categoria_nombre' => $producto['categoria_nombre'] ?? '',
                'destacado' => isset($producto['destacado']) ? (bool) $producto['destacado'] : false,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'productos' => $result,
            'total' => $totalProductos,
            'page' => $pagina,
            'hasMore' => ($offset + $limite) < $totalProductos,
        ]);
        exit;
    }
}