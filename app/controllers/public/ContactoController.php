<?php

require_once __DIR__ . '/../../models/Contacto.php';

require_once __DIR__ . '/../../repositories/ContactoRepository.php';

require_once __DIR__ . '/../../services/MailService.php';

class ContactoController
{
    // ================= INDEX =================
    public function index()
    {
        $titulo = 'Malku - Contacto';

        $css = 'public/contacto.css';

        require_once __DIR__ .
            '/../../views/public/contacto/index.php';
    }

    // ================= ENVIAR =================
    public function enviar()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header(
                'Location: ' .
                BASE_URL .
                '/contacto'
            );
            exit;
        }

        // ================= DATOS =================
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $asunto = trim($_POST['asunto'] ?? '');
        $mensaje = trim($_POST['mensaje'] ?? '');

        // ================= VALIDACIONES =================
        if(
            empty($nombre) ||
            empty($email) ||
            empty($asunto) ||
            empty($mensaje)
        )
        {
            $_SESSION['contacto_error'] =
                'Todos los campos son obligatorios.';

            header(
                'Location: ' .
                BASE_URL .
                '/contacto'
            );

            exit;
        }

        // ================= MODELO =================
        $contacto = new Contacto(
            $nombre,
            $email,
            $asunto,
            $mensaje
        );

        // ================= REPOSITORY =================
        $contactoRepository =
            new ContactoRepository();

        $guardado =
            $contactoRepository->guardar($contacto);

        // ================= MAIL =================
        if($guardado)
        {
            $mailService = new MailService();

            $mailService->enviarConsultaContacto(
                $contacto
            );

            $mailService->enviarConfirmacionUsuario(
                $contacto
            );

            $_SESSION['contacto_exito'] =
                'Tu consulta fue enviada correctamente.';
        }
        else
        {
            $_SESSION['contacto_error'] =
                'Ocurrió un error al enviar la consulta.';
        }

        // ================= REDIRECCIÓN =================
        header(
            'Location: ' .
            BASE_URL .
            '/contacto'
        );

        exit;
    }
}