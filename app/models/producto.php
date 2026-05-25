<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/ProductoService.php';

class Producto
{
    private $conexion;
    private $productoService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();

        $this->productoService =
            new ProductoService(
                $this->conexion
            );
    }

    // ================= DETALLE =====================
    public function obtenerPorId($id)
    {
        return $this->productoService
            ->obtenerDetalleProducto($id);
    }

    // ================= RELACIONADOS ================
    public function obtenerRelacionados(
        $categoriaId,
        $productoId
    )
    {
        return $this->productoService
            ->obtenerRelacionados(
                $categoriaId,
                $productoId
            );
    }
}