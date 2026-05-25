<?php

if (!defined('BASE_URL')) {

    $PROTOCOLO = (
        isset($_SERVER['HTTPS']) &&
        $_SERVER['HTTPS'] === 'on'
    )
        ? 'https://'
        : 'http://';

    $HOST = $_SERVER['HTTP_HOST'];

    $PASTA_PROYECTO = '/Proyecto-Ecommerce-Niki/public';

    define(
        'BASE_URL',
        $PROTOCOLO . $HOST . $PASTA_PROYECTO
    );
}

// ================= GENERAR URL =================
function url($ruta = '')
{
    return BASE_URL . '/' . ltrim($ruta, '/');
}

// ================= REDIRECCIONAR =================
function redirect($ruta = '')
{
    header('Location: ' . url($ruta));
    exit;
}

// ================= ASSETS =================
function asset($ruta = '')
{
    return BASE_URL . '/assets/' . ltrim($ruta, '/');
}

// ================= STORAGE =================
function storage($ruta = '')
{
    return BASE_URL . '/storage/' . ltrim($ruta, '/');
}