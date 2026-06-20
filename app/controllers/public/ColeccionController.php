<?php

require_once __DIR__ . '/../../models/Producto.php';
require_once __DIR__ . '/../../models/Categoria.php';
require_once __DIR__ . '/../../repositories/CategoriaRepository.php';
require_once __DIR__ . '/../../repositories/FavoritoRepository.php';

class ColeccionController
{
    public function index($categoriaSlug = null)
    {
        $titulo = "Malku - Colección";
        $css    = "public/coleccion.css";

        $productoModel = new Producto();
        $categoriaModel = new Categoria();
        $categoriaRepo  = new CategoriaRepository();

        // Backward compat: ?categoria=3 → redirect to /coleccion/{slug}
        if (!$categoriaSlug && isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
            $cat = $categoriaRepo->obtenerPorId((int) $_GET['categoria']);
            if ($cat && !empty($cat['slug'])) {
                $extra = [];
                if (!empty($_GET['orden']))  $extra['orden']  = $_GET['orden'];
                if (!empty($_GET['buscar'])) $extra['buscar'] = $_GET['buscar'];
                $qs = $extra ? '?' . http_build_query($extra) : '';
                header('Location: ' . BASE_URL . '/coleccion/' . $cat['slug'] . $qs, true, 301);
                exit;
            }
        }

        $buscar = trim($_GET['buscar'] ?? '');
        $orden  = $_GET['orden'] ?? 'nuevos';

        // Resolve category slug → ID
        $categoriaId     = null;
        $categoriaActual = null;
        if ($categoriaSlug) {
            $categoriaActual = $categoriaRepo->obtenerPorSlug($categoriaSlug);
            if (!$categoriaActual) {
                renderError(404, 'Categoría no encontrada', 'La categoría que buscás no existe o fue eliminada.');
                return;
            }
            $categoriaId = $categoriaActual['id'];
        }

        $pagina  = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
        $limite  = 6;
        $offset  = ($pagina - 1) * $limite;

        $productos      = $productoModel->obtenerColeccion($buscar, $categoriaId, $orden, $limite, $offset);
        $totalProductos = $productoModel->contarProductos($buscar, $categoriaId);
        $hayMasProductos = ($offset + $limite) < $totalProductos;

        $categorias = $categoriaModel->obtenerTodas();

        $favoritosIds = [];
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] !== 'admin') {
            $favRepo      = new FavoritoRepository();
            $favoritosIds = $favRepo->obtenerProductoIdsPorUsuario((int) $_SESSION['usuario']['id']);
        }

        // Build current page URL for redirects (e.g. favoritos toggle)
        $currentPageUrl = BASE_URL . '/coleccion' . ($categoriaSlug ? '/' . $categoriaSlug : '');
        $extraParams = [];
        if ($buscar) $extraParams['buscar'] = $buscar;
        if ($orden && $orden !== 'nuevos') $extraParams['orden'] = $orden;
        if ($extraParams) $currentPageUrl .= '?' . http_build_query($extraParams);

        require_once __DIR__ . '/../../views/public/coleccion/index.php';
    }

    public function buscar()
    {
        $productoModel = new Producto();

        $buscar        = trim($_GET['buscar'] ?? '');
        $categoriaSlug = $_GET['categoria_slug'] ?? null;
        $orden         = $_GET['orden'] ?? 'nuevos';
        $pagina        = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
        $limite        = 6;
        $offset        = ($pagina - 1) * $limite;

        $categoriaId = null;
        if ($categoriaSlug) {
            $categoriaRepo = new CategoriaRepository();
            $cat = $categoriaRepo->obtenerPorSlug($categoriaSlug);
            if ($cat) $categoriaId = $cat['id'];
        }

        $productos      = $productoModel->obtenerColeccion($buscar, $categoriaId, $orden, $limite, $offset);
        $totalProductos = $productoModel->contarProductos($buscar, $categoriaId);

        $result = [];
        foreach ($productos as $producto) {
            $result[] = [
                'id'               => $producto['id'],
                'nombre'           => $producto['nombre'],
                'slug'             => $producto['slug'],
                'precio'           => (float) $producto['precio'],
                'imagen_principal' => $producto['imagen_principal'],
                'categoria_nombre' => $producto['categoria_nombre'] ?? '',
                'destacado'        => isset($producto['destacado']) ? (bool) $producto['destacado'] : false,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'productos' => $result,
            'total'     => $totalProductos,
            'page'      => $pagina,
            'hasMore'   => ($offset + $limite) < $totalProductos,
        ]);
        exit;
    }
}
