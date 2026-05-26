<?php

// ================= SESIÓN =================
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

// ================= ROLES =================
define('ROL_ADMIN', 'admin');

define('ROL_USUARIO', 'usuario');

// ================= REDIRECCIONES ==========
define(
    'LOGIN_REDIRECT',
    BASE_URL . '/login'
);

define(
    'HOME_REDIRECT',
    BASE_URL
);