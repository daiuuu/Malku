<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthService
{
    private $usuarioModel;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->usuarioModel =
            new Usuario();
    }

    // ================= REGISTRO ====================
    public function registrar(
        $nombre,
        $email,
        $password,
        $newsletter
    )
    {
        // ================= EXISTE ===================
        $usuarioExistente =
            $this->usuarioModel
                ->obtenerUsuarioPorEmail(
                    $email
                );

        if($usuarioExistente)
        {
            return [
                'success' => false,
                'message' =>
                    'El email ya está registrado.'
            ];
        }

        // ================= CREAR ====================
        $creado =
            $this->usuarioModel
                ->crearUsuario(
                    $nombre,
                    $email,
                    $password,
                    $newsletter
                );

        if(!$creado)
        {
            return [
                'success' => false,
                'message' =>
                    'No se pudo crear la cuenta.'
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
        // ================= USUARIO ==================
        $usuario =
            $this->usuarioModel
                ->obtenerUsuarioPorEmail(
                    $email
                );

        if(!$usuario)
        {
            return [
                'success' => false,
                'message' =>
                    'Credenciales inválidas.'
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
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol']
        ];

        return [
            'success' => true
        ];
    }

    // ================= LOGOUT ======================
    public function logout()
    {
        unset($_SESSION['usuario']);

        session_destroy();
    }
}