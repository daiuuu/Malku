<?php

require_once __DIR__ . '/../../models/Producto.php';
require_once __DIR__ . '/../../models/Categoria.php';
require_once __DIR__ . '/../../repositories/CategoriaRepository.php';
require_once __DIR__ . '/../../repositories/FavoritoRepository.php';

class ColeccionController
{
    // Sort slugs used in clean URLs
    private static $SORT_SLUGS = [
        'precio-asc'  => 'precio_asc',
        'precio-desc' => 'precio_desc',
        'destacados'  => 'destacados',
    ];

    public function index($slug1 = null, $slug2 = null)
    {
        $titulo = "Malku - Colección";
        $css    = "public/coleccion.css";

        $productoModel  = new Producto();
        $categoriaModel = new Categoria();
        $categoriaRepo  = new CategoriaRepository();

        // Detect which slug is the sort and which is the category
        $categoriaSlug = null;
        $orden         = 'nuevos';

        if ($slug1 !== null && $slug2 !== null) {
            // Two segments: first is always category, second is always sort
            $categoriaSlug = $slug1;
            $orden = self::$SORT_SLUGS[$slug2] ?? 'nuevos';
        } elseif ($slug1 !== null) {
            // One segment: could be sort-only or category-only
            if (isset(self::$SORT_SLUGS[$slug1])) {
                $orden = self::$SORT_SLUGS[$slug1];
            } else {
                $categoriaSlug = $slug1;
            }
        }

        // Backward compat: ?orden= → redirect to clean URL
        if (isset($_GET['orden']) && $_GET['orden'] !== 'nuevos') {
            $sortMap = array_flip(self::$SORT_SLUGS);
            $sortSlug = $sortMap[$_GET['orden']] ?? null;
            if ($sortSlug) {
                $path = BASE_URL . '/coleccion';
                if ($categoriaSlug) $path .= '/' . $categoriaSlug;
                $path .= '/' . $sortSlug;
                $extra = [];
                if (!empty($_GET['buscar'])) $extra['buscar'] = $_GET['buscar'];
                if (!empty($_GET['pagina'])) $extra['pagina'] = $_GET['pagina'];
                if ($extra) $path .= '?' . http_build_query($extra);
                header('Location: ' . $path, true, 302);
                exit;
            }
        }

        // Backward compat: ?categoria=3 → redirect to /coleccion/{slug}
        if (!$categoriaSlug && isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
            $cat = $categoriaRepo->obtenerPorId((int) $_GET['categoria']);
            if ($cat && !empty($cat['slug'])) {
                header('Location: ' . BASE_URL . '/coleccion/' . $cat['slug'], true, 301);
                exit;
            }
        }

        $buscar = trim($_GET['buscar'] ?? '');

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

        $productos       = $productoModel->obtenerColeccion($buscar, $categoriaId, $orden, $limite, $offset);
        $totalProductos  = $productoModel->contarProductos($buscar, $categoriaId);
        $hayMasProductos = ($offset + $limite) < $totalProductos;

        $categorias = $categoriaModel->obtenerTodas();

        $favoritosIds = [];
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] !== 'admin') {
            $favRepo      = new FavoritoRepository();
            $favoritosIds = $favRepo->obtenerProductoIdsPorUsuario((int) $_SESSION['usuario']['id']);
        }

        // Build current page URL for the favoritos toggle redirect
        $currentPageUrl = BASE_URL . '/coleccion';
        if ($categoriaSlug) $currentPageUrl .= '/' . $categoriaSlug;
        if ($orden && $orden !== 'nuevos') {
            $sortMap = array_flip(self::$SORT_SLUGS);
            if (isset($sortMap[$orden])) $currentPageUrl .= '/' . $sortMap[$orden];
        }
        if ($buscar) $currentPageUrl .= '?buscar=' . urlencode($buscar);

        // Expose sort slug for JS URL building in the view
        $ordenSlug = ($orden !== 'nuevos') ? (array_flip(self::$SORT_SLUGS)[$orden] ?? '') : '';

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
