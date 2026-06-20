<?php

require_once __DIR__ . '/../../repositories/CategoriaRepository.php';

class CategoriaAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new CategoriaRepository();
    }

    public function index()
    {
        $categorias = $this->repo->obtenerTodas();
        $css        = 'admin/admin.css?v=2';
        $titulo     = 'Categorías | Admin Malku';
        require_once __DIR__ . '/../../views/admin/categorias/index.php';
    }

    public function crear()
    {
        $css    = 'admin/admin.css?v=2';
        $titulo = 'Nueva Categoría | Admin Malku';
        require_once __DIR__ . '/../../views/admin/categorias/crear.php';
    }

    public function guardar()
    {
        $nombre = trim($_POST['nombre'] ?? '');
        if (empty($nombre)) {
            $_SESSION['admin_error'] = 'El nombre es obligatorio.';
            header('Location: ' . BASE_URL . '/admin/categorias/crear');
            exit;
        }

        $slug = mb_strtolower($nombre, 'UTF-8');
        $slug = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', trim($slug));

        $this->repo->crear([
            'nombre'      => $nombre,
            'slug'        => $slug,
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'estado'      => $_POST['estado'] ?? 'activa',
        ]);

        $_SESSION['admin_ok'] = 'Categoría creada.';
        header('Location: ' . BASE_URL . '/admin/categorias');
        exit;
    }

    public function editar($id)
    {
        $categoria = $this->repo->obtenerPorId($id);
        if (!$categoria) {
            header('Location: ' . BASE_URL . '/admin/categorias');
            exit;
        }
        $css    = 'admin/admin.css?v=2';
        $titulo = 'Editar Categoría | Admin Malku';
        require_once __DIR__ . '/../../views/admin/categorias/editar.php';
    }

    public function actualizar()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');

        $slug = mb_strtolower($nombre, 'UTF-8');
        $slug = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', trim($slug));

        $this->repo->actualizar($id, [
            'nombre'      => $nombre,
            'slug'        => $slug,
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'estado'      => $_POST['estado'] ?? 'activa',
        ]);

        $_SESSION['admin_ok'] = 'Categoría actualizada.';
        header('Location: ' . BASE_URL . '/admin/categorias');
        exit;
    }

    public function eliminar()
    {
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->cambiarEstado($id, 'oculta');
        }
        $_SESSION['admin_ok'] = 'Categoría desactivada.';
        header('Location: ' . BASE_URL . '/admin/categorias');
        exit;
    }
}
