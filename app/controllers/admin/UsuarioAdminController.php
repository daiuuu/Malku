<?php

require_once __DIR__ . '/../../repositories/UsuarioRepository.php';

class UsuarioAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UsuarioRepository();
    }

    public function index()
    {
        try {
            $db       = (new Database())->conectar();
            $usuarios = $db->query(
                "SELECT * FROM usuarios ORDER BY fecha_registro DESC"
            )->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $usuarios = [];
        }

        $css    = 'admin/admin.css?v=2';
        $titulo = 'Usuarios | Admin Malku';
        require_once __DIR__ . '/../../views/admin/usuarios/index.php';
    }

    public function cambiarRol()
    {
        $id  = (int)($_POST['id'] ?? 0);
        $rol = $_POST['rol'] ?? '';

        if ($id && in_array($rol, ['admin', 'cliente'])) {
            try {
                $db = (new Database())->conectar();
                $s  = $db->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
                $s->execute([':rol' => $rol, ':id' => $id]);
            } catch (Exception $e) {}
        }

        $_SESSION['admin_ok'] = 'Rol actualizado.';
        header('Location: ' . BASE_URL . '/admin/usuarios');
        exit;
    }

    public function cambiarEstado()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';

        if ($id && in_array($estado, ['activo', 'bloqueado'])) {
            try {
                $db = (new Database())->conectar();
                $s  = $db->prepare("UPDATE usuarios SET estado = :estado WHERE id = :id");
                $s->execute([':estado' => $estado, ':id' => $id]);
            } catch (Exception $e) {}
        }

        $_SESSION['admin_ok'] = 'Estado de usuario actualizado.';
        header('Location: ' . BASE_URL . '/admin/usuarios');
        exit;
    }
}
