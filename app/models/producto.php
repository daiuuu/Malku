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

    // ================= OBTENER PRODUCTO POR ID =================
    public function obtenerProductoPorId(
        $id
    )
    {
        try
        {
            // ================= SQL =================
            $sql = "
                SELECT
                    p.*,
                    c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c
                    ON p.categoria_id = c.id
                WHERE p.id = :id
                LIMIT 1
            ";

            // ================= PREPARAR ============
            $stmt = $this->conexion->prepare($sql);

            // ================= BIND ================
            $stmt->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );

            // ================= EJECUTAR ============
            $stmt->execute();

            // ================= RETORNO =============
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerProductoPorId(): ' .
                $e->getMessage()
            );

            return false;
        }
    }
}