<?php

/*
--------------------------------------------------------------------------
CONFIGURACIÓN DE MERCADO PAGO — MALKU
--------------------------------------------------------------------------
1. Entrá a https://www.mercadopago.com.ar/developers/panel
2. Creá una aplicación
3. En "Credenciales de prueba" copiá el Access Token (empieza con TEST-)
4. Para producción, usá las credenciales de "Credenciales de producción"
--------------------------------------------------------------------------
*/

/* ============================= */
/* MODO: 'sandbox' o 'produccion' */
/* ============================= */

define('MP_MODO', 'sandbox');

/* ============================= */
/* CREDENCIALES                  */
/* ============================= */

// Access Token de PRUEBA (empieza con TEST-)
define('MP_ACCESS_TOKEN_SANDBOX',    'TEST-0000000000000000-000000-00000000000000000000000000000000-000000000');

// Access Token de PRODUCCIÓN (empieza con APP_USR-)
define('MP_ACCESS_TOKEN_PRODUCCION', 'APP_USR-tu-token-de-produccion');

// Token activo según el modo
define('MP_ACCESS_TOKEN', MP_MODO === 'produccion'
    ? MP_ACCESS_TOKEN_PRODUCCION
    : MP_ACCESS_TOKEN_SANDBOX
);

/* ============================= */
/* CONTACTO WHATSAPP             */
/* ============================= */

// Número con código de país SIN el + (54 = Argentina)
define('WHATSAPP_NUMERO', '5491100000000');
