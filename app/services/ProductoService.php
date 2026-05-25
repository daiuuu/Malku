<?php

require_once __DIR__ . '/../repositories/ProductoRepository.php';

class ProductoService
{
    private $productoRepository;

    // ================= CONSTRUCTOR =================
    public function __construct($conexion)
    {
        $this->productoRepository =
            new ProductoRepository($conexion);
    }

    // ================= DETALLE =====================
    public function obtenerDetalleProducto($id)
    {
        return $this->productoRepository
            ->obtenerPorId($id);
    }

    // ================= RELACIONADOS ================
    public function obtenerRelacionados(
        $categoriaId,
        $productoId
    )
    {
        return $this->productoRepository
            ->obtenerRelacionados(
                $categoriaId,
                $productoId
            );
    }
}