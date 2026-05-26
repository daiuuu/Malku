<?php

require_once __DIR__ . '/../../services/AuthService.php';

class AuthController
{
    private $authService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->authService =
            new AuthService();
    }

    // ================= LOGIN VIEW ==================
    public function login()
    {
        $titulo =
            'Malku - Iniciar Sesión';

        $css =
            'auth/login.css';

        require_once __DIR__ .
            '/../../views/public/auth/login.php';
    }

    // ================= REGISTRO VIEW ===============
    public function registro()
    {
        $titulo =
            'Malku - Registro';

        $css =
            'auth/registro.css';

        require_once __DIR__ .
            '/../../views/public/auth/registro.php';
    }

    // ================= LOGIN POST ==================
    public function autenticar()
    {
        $email =
            trim($_POST['email'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        $resultado =
            $this->authService
                ->login(
                    $email,
                    $password
                );

        if(!$resultado['success'])
        {
            $_SESSION['login_error'] =
                $resultado['message'];

            header(
                'Location: ' .
                BASE_URL .
                '/login'
            );

            exit;
        }

        header(
            'Location: ' .
            BASE_URL
        );

        exit;
    }

    // ================= REGISTRO POST ===============
    public function guardarRegistro()
    {
        $nombre =
            trim($_POST['nombre'] ?? '');

        $email =
            trim($_POST['email'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        $newsletter =
            isset($_POST['newsletter'])
            ? 1
            : 0;

        $resultado =
            $this->authService
                ->registrar(
                    $nombre,
                    $email,
                    $password,
                    $newsletter
                );

        if(!$resultado['success'])
        {
            $_SESSION['registro_error'] =
                $resultado['message'];

            header(
                'Location: ' .
                BASE_URL .
                '/registro'
            );

            exit;
        }

        $_SESSION['registro_exito'] =
            'Cuenta creada correctamente.';

        header(
            'Location: ' .
            BASE_URL .
            '/login'
        );

        exit;
    }

    // ================= LOGOUT ======================
    public function logout()
    {
        $this->authService->logout();

        header(
            'Location: ' .
            BASE_URL
        );

        exit;
    }
}