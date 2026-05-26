<?php

// ================= INICIAR SESIÓN =================
if (session_status() === PHP_SESSION_NONE) {

    session_start();
}

// ================= GUARDAR DATOS EN SESIÓN =================
function setSession($clave, $valor)
{
    $_SESSION[$clave] = $valor;
}

// ================= OBTENER DATO DE SESIÓN =================
function getSession($clave)
{
    return $_SESSION[$clave] ?? null;
}

// ================= ELIMINAR DATO DE SESIÓN =================
function removeSession($clave)
{
    if (isset($_SESSION[$clave])) {

        unset($_SESSION[$clave]);
    }
}

// ================= VERIFICAR LOGIN =================
function usuarioLogueado()
{
    return isset($_SESSION['usuario']);
}

// ================= OBTENER USUARIO LOGUEADO =================
function usuario()
{
    return $_SESSION['usuario'] ?? null;
}

// ================= CERRAR SESIÓN =================
function cerrarSesion()
{
    session_unset();
    session_destroy();
}

// ================= FLASH MESSAGE =================
function setFlash($tipo, $mensaje)
{
    $_SESSION['flash'] = [
        'tipo' => $tipo,
        'mensaje' => $mensaje
    ];
}

function getFlash()
{
    if (!isset($_SESSION['flash'])) {

        return null;
    }

    $flash = $_SESSION['flash'];

    unset($_SESSION['flash']);

    return $flash;
}