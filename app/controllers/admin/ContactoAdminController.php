<?php

require_once __DIR__ . '/../../repositories/ContactoRepository.php';

class ContactoAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ContactoRepository();
    }

    public function index()
    {
        $mensajes = $this->repo->obtenerTodos();
        $titulo   = 'Mensajes | Admin Malku';
        require_once __DIR__ . '/../../views/admin/contacto/index.php';
    }

    public function cambiarEstado()
    {
        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';

        if ($id && in_array($estado, ['pendiente', 'leido', 'respondido'])) {
            $this->repo->cambiarEstado($id, $estado);
        }

        header('Location: ' . BASE_URL . '/admin/contacto');
        exit;
    }
}
