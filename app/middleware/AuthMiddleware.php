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
    }

    // ================= ES ADMIN =================
    public static function esAdmin()
    {
        if(
            !isset($_SESSION['usuario']) ||
            $_SESSION['usuario']['rol'] !== 'admin'
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
