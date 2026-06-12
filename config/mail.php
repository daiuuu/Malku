<?php

/*
--------------------------------------------------------------------------
CONFIGURACIÓN DE CORREO - MALKU
--------------------------------------------------------------------------
Para Gmail:
1. Activá la verificación en dos pasos en tu cuenta Google.
2. Entrá a: myaccount.google.com → Seguridad → Contraseñas de aplicaciones.
3. Generá una contraseña de aplicación (16 caracteres sin espacios).
4. Pegala en MAIL_PASSWORD debajo.
--------------------------------------------------------------------------
*/

/* ============================= */
/* SMTP */
/* ============================= */

define('MAIL_HOST',      'smtp.gmail.com');
define('MAIL_PORT',      587);
define('MAIL_SEGURIDAD', 'tls');

/* ============================= */
/* CREDENCIALES */
/* ============================= */

define('MAIL_USUARIO',   'tu@gmail.com');
define('MAIL_PASSWORD',  'xxxx xxxx xxxx xxxx');

/* ============================= */
/* REMITENTE */
/* ============================= */

define('MAIL_FROM',      'tu@gmail.com');
define('MAIL_FROM_NAME', 'Malku');
define('MAIL_CHARSET',   'UTF-8');
