<?php

require_once __DIR__ . '/../repositories/UsuarioRepository.php';
require_once __DIR__ . '/MailService.php';

class AuthService
{
    private $usuarioRepo;
    private $mailService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->usuarioRepo =
            new UsuarioRepository();

        $this->mailService =
            new MailService();
    }

    // ================= REGISTRO ====================
    public function registrar(
        $nombre,
        $apellido,
        $email,
        $password
    )
    {
        // ================= VALIDACIONES =============
        if(
            empty($nombre) ||
            empty($email) ||
            empty($password)
        )
        {
            return [
                'success' => false,
                'message' =>
                    'Todos los campos son obligatorios.'
            ];
        }

        if(
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        )
        {
            return [
                'success' => false,
                'message' =>
                    'El email ingresado no es válido.'
            ];
        }

        if(strlen($password) < 6)
        {
            return [
                'success' => false,
                'message' =>
                    'La contraseña debe tener al menos 6 caracteres.'
            ];
        }

        // ================= EXISTE ===================
        $existe =
            $this->usuarioRepo
                ->buscarPorEmail($email);

        if($existe)
        {
            return [
                'success' => false,
                'message' =>
                    'El email ya está registrado.'
            ];
        }

        // ================= CREAR ====================
        $creado =
            $this->usuarioRepo
                ->crear([
                    'nombre'   => $nombre,
                    'apellido' => $apellido,
                    'email'    => $email,
                    'password' => $password
                ]);

        if(!$creado)
        {
            return [
                'success' => false,
                'message' =>
                    'No se pudo crear la cuenta. Intentá más tarde.'
            ];
        }

        return [
            'success' => true
        ];
    }

    // ================= LOGIN =======================
    public function login(
        $email,
        $password
    )
    {
        // ================= VALIDACIONES =============
        if(empty($email) || empty($password))
        {
            return [
                'success' => false,
                'message' =>
                    'Completá todos los campos.'
            ];
        }

        // ================= USUARIO ==================
        $usuario =
            $this->usuarioRepo
                ->buscarPorEmail($email);

        if(!$usuario)
        {
            return [
                'success' => false,
                'message' =>
                    'Credenciales inválidas.'
            ];
        }

        // ================= ESTADO ===================
        if($usuario['estado'] !== 'activo')
        {
            return [
                'success' => false,
                'message' =>
                    'Tu cuenta está inactiva. Contactate con soporte.'
            ];
        }

        // ================= PASSWORD =================
        if(
            !password_verify(
                $password,
                $usuario['password']
            )
        )
        {
            return [
                'success' => false,
                'message' =>
                    'Credenciales inválidas.'
            ];
        }

        // ================= SESIÓN ===================
        $_SESSION['usuario'] = [
            'id'       => $usuario['id'],
            'nombre'   => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'email'    => $usuario['email'],
            'rol'      => $usuario['rol']
        ];

        // ================= ÚLTIMO ACCESO ============
        $this->usuarioRepo
            ->actualizarUltimoAcceso(
                $usuario['id']
            );

        return [
            'success' => true
        ];
    }

    // ================= RECUPERAR CONTRASEÑA =======
    public function iniciarRecuperacion(
        $email
    )
    {
        // ================= VALIDAR =================
        if(
            empty($email) ||
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        )
        {
            return [
                'success' => false,
                'message' =>
                    'Ingresá un correo electrónico válido.'
            ];
        }

        // ================= MENSAJE GENÉRICO ========
        $mensajeExito =
            'Si el correo existe en nuestro sistema, recibirás las instrucciones en breve.';

        // ================= BUSCAR USUARIO ==========
        $usuario =
            $this->usuarioRepo
                ->buscarPorEmail($email);

        if(!$usuario)
        {
            return [
                'success' => true,
                'message' => $mensajeExito
            ];
        }

        // ================= GENERAR TOKEN ===========
        $token =
            bin2hex(
                random_bytes(32)
            );

        // ================= GUARDAR TOKEN ===========
        $guardado =
            $this->usuarioRepo
                ->guardarTokenRecuperacion(
                    $email,
                    $token
                );

        if(!$guardado)
        {
            return [
                'success' => false,
                'message' =>
                    'Ocurrió un error. Intentá más tarde.'
            ];
        }

        // ================= ENVIAR EMAIL =============
        $enviado =
            $this->mailService
                ->enviarRecuperacion(
                    $email,
                    $usuario['nombre'],
                    $token
                );

        if(!$enviado['success'])
        {
            error_log(
                'AuthService::iniciarRecuperacion() - ' .
                'Error al enviar email: ' .
                ($enviado['error'] ?? 'desconocido')
            );

            return [
                'success' => false,
                'message' =>
                    'No se pudo enviar el correo. ' .
                    'Verificá tu dirección o intentá más tarde.'
            ];
        }

        return [
            'success' => true,
            'message' => $mensajeExito
        ];
    }

    // ================= RESTABLECER CONTRASEÑA ======
    public function restablecerPassword(
        $token,
        $password,
        $confirmPassword
    )
    {
        // ================= VALIDAR CAMPOS ===========
        if(
            empty($token) ||
            empty($password) ||
            empty($confirmPassword)
        )
        {
            return [
                'success' => false,
                'message' =>
                    'Todos los campos son obligatorios.'
            ];
        }

        if($password !== $confirmPassword)
        {
            return [
                'success' => false,
                'message' =>
                    'Las contraseñas no coinciden.'
            ];
        }

        if(strlen($password) < 6)
        {
            return [
                'success' => false,
                'message' =>
                    'La contraseña debe tener al menos 6 caracteres.'
            ];
        }

        // ================= BUSCAR TOKEN =============
        $usuario =
            $this->usuarioRepo
                ->buscarPorToken($token);

        if(!$usuario)
        {
            return [
                'success' => false,
                'message' =>
                    'El enlace es inválido o ya fue utilizado.'
            ];
        }

        // ================= HASH =====================
        $passwordHash =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );

        // ================= ACTUALIZAR ===============
        $actualizado =
            $this->usuarioRepo
                ->actualizarPassword(
                    $usuario['id'],
                    $passwordHash
                );

        if(!$actualizado)
        {
            return [
                'success' => false,
                'message' =>
                    'No se pudo actualizar la contraseña. Intentá más tarde.'
            ];
        }

        // ================= LIMPIAR TOKEN ============
        $this->usuarioRepo
            ->limpiarTokenRecuperacion(
                $usuario['id']
            );

        return [
            'success' => true,
            'message' =>
                'Contraseña actualizada correctamente. Ya podés iniciar sesión.'
        ];
    }

    // ================= LOGOUT ======================
    public function logout()
    {
        session_unset();

        session_destroy();
    }
}
