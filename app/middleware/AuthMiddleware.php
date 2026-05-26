<?php

class AuthMiddleware
{
    // ================= VERIFICAR LOGIN =================
    public static function verificar()
    {
        if(
            !isset($_SESSION['usuario'])
        )
        {
            $_SESSION['auth_error'] =
                'Debes iniciar sesión.';

            header(
                'Location: ' .
                BASE_URL .
                '/login'
            );

            exit;
        }
    }

    // ================= INVITADO =================
    public static function invitado()
    {
        if(
            isset($_SESSION['usuario'])
        )
        {
            header(
                'Location: ' .
                BASE_URL
            );

            exit;
        }
    }
}