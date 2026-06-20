<?php

require_once __DIR__ . '/../../repositories/ProductoRepository.php';
require_once __DIR__ . '/../../repositories/CategoriaRepository.php';

class ProductoAdminController
{
    private $repo;
    private $catRepo;

    public function __construct()
    {
        $this->repo    = new ProductoRepository();
        $this->catRepo = new CategoriaRepository();
    }

    public function index()
    {
        $productos = $this->repo->obtenerTodos();
        $css       = 'admin/admin.css?v=2';
        $titulo    = 'Productos | Admin Malku';
        require_once __DIR__ . '/../../views/admin/productos/index.php';
    }

    public function crear()
    {
        $categorias = $this->catRepo->obtenerActivas();
        $css        = 'admin/admin.css?v=2';
        $titulo     = 'Nuevo Producto | Admin Malku';
        require_once __DIR__ . '/../../views/admin/productos/crear.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/productos');
            exit;
        }

        $datos = [
            'categoria_id'     => (int)($_POST['categoria_id'] ?? 0),
            'nombre'           => trim($_POST['nombre'] ?? ''),
            'slug'             => $this->slugify(trim($_POST['nombre'] ?? '')),
            'descripcion'      => trim($_POST['descripcion'] ?? ''),
            'precio'           => (float)($_POST['precio'] ?? 0),
            'stock'            => (int)($_POST['stock'] ?? 0),
            'destacado'        => isset($_POST['destacado']) ? 1 : 0,
            'estado'           => $_POST['estado'] ?? 'activo',
            'materiales'       => trim($_POST['materiales'] ?? ''),
            'cuidados'         => trim($_POST['cuidados'] ?? ''),
            'imagen_principal' => '',
        ];

        if (empty($datos['nombre']) || $datos['precio'] <= 0) {
            $_SESSION['admin_error'] = 'Nombre y precio son obligatorios.';
            header('Location: ' . BASE_URL . '/admin/productos/crear');
            exit;
        }

        $this->repo->crear($datos);
        $id = (new Database())->conectar()->lastInsertId();

        if (!empty($_FILES['imagen']['name'])) {
            $imagen = $this->subirImagen($_FILES['imagen'], $id);
            if ($imagen) {
                $this->repo->actualizarImagen($id, $imagen);
            }
        }

        $_SESSION['admin_ok'] = 'Producto creado correctamente.';
        header('Location: ' . BASE_URL . '/admin/productos');
        exit;
    }

    public function editar($id)
    {
        $producto   = $this->repo->obtenerPorId($id);
        $categorias = $this->catRepo->obtenerActivas();

        if (!$producto) {
            header('Location: ' . BASE_URL . '/admin/productos');
            exit;
        }

        $css    = 'admin/admin.css?v=2';
        $titulo = 'Editar Producto | Admin Malku';
        require_once __DIR__ . '/../../views/admin/productos/editar.php';
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/productos');
            exit;
        }

        $id    = (int)($_POST['id'] ?? 0);
        $datos = [
            'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
            'nombre'       => trim($_POST['nombre'] ?? ''),
            'slug'         => $this->slugify(trim($_POST['nombre'] ?? '')),
            'descripcion'  => trim($_POST['descripcion'] ?? ''),
            'precio'       => (float)($_POST['precio'] ?? 0),
            'stock'        => (int)($_POST['stock'] ?? 0),
            'destacado'    => isset($_POST['destacado']) ? 1 : 0,
            'estado'       => $_POST['estado'] ?? 'activo',
            'materiales'   => trim($_POST['materiales'] ?? ''),
            'cuidados'     => trim($_POST['cuidados'] ?? ''),
        ];

        $this->repo->actualizar($id, $datos);

        if (!empty($_FILES['imagen']['name'])) {
            $imagen = $this->subirImagen($_FILES['imagen'], $id);
            if ($imagen) {
                $this->repo->actualizarImagen($id, $imagen);
            }
        }

        $_SESSION['admin_ok'] = 'Producto actualizado.';
        header('Location: ' . BASE_URL . '/admin/productos');
        exit;
    }

    public function eliminar()
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->cambiarEstado($id, 'oculto');
        }
        $_SESSION['admin_ok'] = 'Producto desactivado.';
        header('Location: ' . BASE_URL . '/admin/productos');
        exit;
    }

    private function slugify($texto)
    {
        $texto = mb_strtolower($texto, 'UTF-8');
        $texto = str_replace(['á','é','í','ó','ú','ñ','ü'], ['a','e','i','o','u','n','u'], $texto);
        $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);
        $texto = preg_replace('/[\s-]+/', '-', trim($texto));
        return $texto;
    }

    private function subirImagen($file, $productoId)
    {
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($ext, $allowed) || $file['error'] !== UPLOAD_ERR_OK) return null;

        $dir = ROOT_PATH . '/public/assets/img/productos/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $nombre = 'producto-' . $productoId . '-' . time() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . $nombre)) {
            return BASE_URL . '/assets/img/productos/' . $nombre;
        }
        return null;
    }
}
