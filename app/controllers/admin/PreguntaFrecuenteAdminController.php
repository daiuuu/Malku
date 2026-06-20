<?php

require_once __DIR__ . '/../../repositories/PreguntaFrecuenteRepository.php';

class PreguntaFrecuenteAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PreguntaFrecuenteRepository();
    }

    // ================= LISTADO =================
    public function index()
    {
        $preguntas   = $this->repo->obtenerTodas();
        $flash_ok    = $_SESSION['admin_ok']    ?? null;
        $flash_error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_ok'], $_SESSION['admin_error']);

        $titulo = 'Preguntas Frecuentes | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/preguntas/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= CREAR (GET) =================
    public function crear()
    {
        $pregunta = null;

        $titulo = 'Nueva pregunta | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/preguntas/form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GUARDAR (POST) =================
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/preguntas');
            exit;
        }

        $preguntaTexto = trim($_POST['pregunta'] ?? '');
        $respuesta     = trim($_POST['respuesta'] ?? '');

        if (!$preguntaTexto || !$respuesta) {
            $_SESSION['admin_error'] = 'La pregunta y la respuesta son obligatorias.';
            header('Location: ' . BASE_URL . '/admin/preguntas/crear');
            exit;
        }

        $this->repo->crear([
            'pregunta'  => $preguntaTexto,
            'respuesta' => $respuesta,
            'orden'     => (int)($_POST['orden'] ?? 0),
            'activo'    => isset($_POST['activo']) ? 1 : 0,
        ]);

        $_SESSION['admin_ok'] = 'Pregunta creada correctamente.';
        header('Location: ' . BASE_URL . '/admin/preguntas');
        exit;
    }

    // ================= EDITAR (GET) =================
    public function editar(int $id)
    {
        $pregunta = $this->repo->obtenerPorId($id);
        if (!$pregunta) {
            header('Location: ' . BASE_URL . '/admin/preguntas');
            exit;
        }

        $titulo = 'Editar pregunta | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/preguntas/form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= ACTUALIZAR (POST) =================
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/preguntas');
            exit;
        }

        $id            = (int)($_POST['id'] ?? 0);
        $preguntaTexto = trim($_POST['pregunta'] ?? '');
        $respuesta     = trim($_POST['respuesta'] ?? '');

        if (!$id || !$preguntaTexto || !$respuesta) {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/preguntas');
            exit;
        }

        $this->repo->actualizar($id, [
            'pregunta'  => $preguntaTexto,
            'respuesta' => $respuesta,
            'orden'     => (int)($_POST['orden'] ?? 0),
            'activo'    => isset($_POST['activo']) ? 1 : 0,
        ]);

        $_SESSION['admin_ok'] = 'Pregunta actualizada.';
        header('Location: ' . BASE_URL . '/admin/preguntas');
        exit;
    }

    // ================= ELIMINAR (POST) =================
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/preguntas');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->eliminar($id);
            $_SESSION['admin_ok'] = 'Pregunta eliminada.';
        }

        header('Location: ' . BASE_URL . '/admin/preguntas');
        exit;
    }
}
