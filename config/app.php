<?php

/*
--------------------------------------------------------------------------
CONFIGURACIÓN GENERAL DE LA APLICACIÓN
--------------------------------------------------------------------------
Este archivo contiene constantes y configuraciones globales
que se utilizan en todo el proyecto Malku.
*/

/* ============================= */
/* ENTORNO */
/* ============================= */

define('APP_NAME', 'Malku');

define('APP_ENV', 'development');

/*
--------------------------------------------------------------------------
URL BASE
--------------------------------------------------------------------------
Ruta principal del proyecto en localhost.
Ajustar si cambia la carpeta del proyecto.
*/

if(!defined('BASE_URL'))
{
    define(
        'BASE_URL',
        'http://localhost/Proyecto-Ecommerce-Niki/public'
    );
}

/* ============================= */
/* ZONA HORARIA */
/* ============================= */

date_default_timezone_set('America/Argentina/Buenos_Aires');

/* ============================= */
/* SESIONES */
/* ============================= */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================= */
/* CONFIGURACIÓN DE ERRORES */
/* ============================= */

if (APP_ENV === 'development') {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

} else {

    ini_set('display_errors', 0);

}

/* ============================= */
/* RUTAS IMPORTANTES */
/* ============================= */

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app');

define('PUBLIC_PATH', ROOT_PATH . '/public');

define('STORAGE_PATH', ROOT_PATH . '/storage');

define('UPLOADS_PATH', STORAGE_PATH . '/uploads');

/* ============================= */
/* ASSETS */
/* ============================= */

define('CSS_PATH', BASE_URL . '/assets/css');

define('JS_PATH', BASE_URL . '/assets/js');

define('IMG_PATH', BASE_URL . '/assets/img');

/* ============================= */
/* CONFIGURACIÓN DE SUBIDAS */
/* ============================= */

define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB

define('ALLOWED_IMAGE_EXTENSIONS', [
    'jpg',
    'jpeg',
    'png',
    'webp'
]);

/* ============================= */
/* ROLES */
/* ============================= */

define('ROL_ADMIN', 'admin');

define('ROL_CLIENTE', 'cliente');

/* ============================= */
/* ESTADOS */
/* ============================= */

define('USUARIO_ACTIVO', 'activo');

define('USUARIO_BLOQUEADO', 'bloqueado');

/* ============================= */
/* MENSAJES GENERALES */
/* ============================= */

define('ERROR_404', 'La página solicitada no existe.');

define('ERROR_500', 'Ocurrió un error interno.');

define('LOGIN_REQUIRED', 'Debes iniciar sesión.');