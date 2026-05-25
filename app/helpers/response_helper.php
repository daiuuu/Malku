<?php

// ================= RESPUESTA JSON =================
function responseJson(
    $datos = [],
    $codigo = 200
)
{
    http_response_code($codigo);

    header(
        'Content-Type: application/json; charset=utf-8'
    );

    echo json_encode(
        $datos,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit;
}

// ================= RESPUESTA EXITOSA =================
function responseSuccess(
    $mensaje = 'Operación realizada correctamente',
    $datos = []
)
{
    responseJson([
        'success' => true,
        'message' => $mensaje,
        'data' => $datos
    ]);
}

// ================= RESPUESTA ERROR =================
function responseError(
    $mensaje = 'Ocurrió un error',
    $codigo = 400
)
{
    responseJson([
        'success' => false,
        'message' => $mensaje
    ], $codigo);
}

// ================= RESPUESTA VALIDACIÓN =================
function responseValidation(
    $errores = []
)
{
    responseJson([
        'success' => false,
        'errors' => $errores
    ], 422);
}

// ================= RESPUESTA NOT FOUND =================
function responseNotFound(
    $mensaje = 'Recurso no encontrado'
)
{
    responseJson([
        'success' => false,
        'message' => $mensaje
    ], 404);
}

// ================= RESPUESTA NO AUTORIZADA =================
function responseUnauthorized(
    $mensaje = 'No autorizado'
)
{
    responseJson([
        'success' => false,
        'message' => $mensaje
    ], 401);
}