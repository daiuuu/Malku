<?php

require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
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
        AuthMiddleware::invitado();

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
        AuthMiddleware::invitado();

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

        // ================= REDIRECT POR ROL =================
        $rol =
            $_SESSION['usuario']['rol'];

        if($rol === 'admin')
        {
            header(
                'Location: ' .
                BASE_URL .
                '/admin'
            );
        }
        else
        {
            header(
                'Location: ' .
                BASE_URL .
                '/usuario'
            );
        }

        exit;
    }

    // ================= REGISTRO POST ===============
    public function guardarRegistro()
    {
        $nombre =
            trim($_POST['nombre'] ?? '');

        $apellido =
            trim($_POST['apellido'] ?? '');

        $email =
            trim($_POST['email'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        $resultado =
            $this->authService
                ->registrar(
                    $nombre,
                    $apellido,
                    $email,
                    $password
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
            'Cuenta creada correctamente. Podés iniciar sesión.';

        header(
            'Location: ' .
            BASE_URL .
            '/login'
        );

        exit;
    }

    // ================= RECUPERAR PASSWORD VIEW ====
    public function recuperarPassword()
    {
        AuthMiddleware::invitado();

        $titulo =
            'Malku - Recuperar Contraseña';

        $css =
            'auth/recuperar_password.css';

        require_once __DIR__ .
            '/../../views/public/auth/recuperar_password.php';
    }

    // ================= RECUPERAR PASSWORD POST ====
    public function enviarRecuperacion()
    {
        $email =
            trim($_POST['email'] ?? '');

        $resultado =
            $this->authService
                ->iniciarRecuperacion(
                    $email
                );

        if(!$resultado['success'])
        {
            $_SESSION['recuperar_error'] =
                $resultado['message'];

            header(
                'Location: ' .
                BASE_URL .
                '/recuperar-password'
            );

            exit;
        }

        $_SESSION['recuperar_exito'] =
            $resultado['message'];

        header(
            'Location: ' .
            BASE_URL .
            '/recuperar-password'
        );

        exit;
    }

    // ================= NUEVA PASSWORD VIEW ========
    public function mostrarNuevaPassword()
    {
        $token =
            trim($_GET['token'] ?? '');

        if(empty($token))
        {
            header(
                'Location: ' .
                BASE_URL .
                '/recuperar-password'
            );

            exit;
        }

        $titulo =
            'Malku - Nueva Contraseña';

        $css =
            'auth/recuperar_password.css';

        require_once __DIR__ .
            '/../../views/public/auth/nueva_password.php';
    }

    // ================= NUEVA PASSWORD POST ========
    public function procesarNuevaPassword()
    {
        $token =
            trim($_POST['token'] ?? '');

        $password =
            trim($_POST['password'] ?? '');

        $confirmPassword =
            trim($_POST['confirm_password'] ?? '');

        $resultado =
            $this->authService
                ->restablecerPassword(
                    $token,
                    $password,
                    $confirmPassword
                );

        if(!$resultado['success'])
        {
            $_SESSION['nueva_password_error'] =
                $resultado['message'];

            header(
                'Location: ' .
                BASE_URL .
                '/nueva-password?token=' .
                urlencode($token)
            );

            exit;
        }

        $_SESSION['login_exito'] =
            $resultado['message'];

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
