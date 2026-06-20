<?php

require_once __DIR__ . '/../../repositories/ContactoRepository.php';
require_once __DIR__ . '/../../services/MailService.php';

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
        $css      = 'admin/admin.css?v=2';
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

    public function responder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/contacto');
            exit;
        }

        $id        = (int)($_POST['id'] ?? 0);
        $respuesta = trim($_POST['respuesta'] ?? '');

        if (!$id || empty($respuesta)) {
            $_SESSION['admin_error'] = 'La respuesta no puede estar vacía.';
            header('Location: ' . BASE_URL . '/admin/contacto');
            exit;
        }

        $mensaje = $this->repo->obtenerPorId($id);

        if (!$mensaje) {
            header('Location: ' . BASE_URL . '/admin/contacto');
            exit;
        }

        $mail    = new MailService();
        $enviado = $mail->enviarRespuestaContacto(
            $mensaje['email'],
            $mensaje['nombre'],
            $mensaje['asunto'],
            $respuesta
        );

        if ($enviado) {
            $this->repo->cambiarEstado($id, 'respondido');
            $_SESSION['admin_ok'] = 'Respuesta enviada a ' . htmlspecialchars($mensaje['nombre']) . '.';
        } else {
            $_SESSION['admin_error'] = 'No se pudo enviar el email. Verificá la configuración de correo.';
        }

        header('Location: ' . BASE_URL . '/admin/contacto');
        exit;
    }
}
