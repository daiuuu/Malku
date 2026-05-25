<?php

class ProductoRepository
{
    private $conexion;

    // ================= CONSTRUCTOR =================
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // ================= OBTENER POR ID ==============
    public function obtenerPorId($id)
    {
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

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(
            ':id',
            $id,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= RELACIONADOS =================
    public function obtenerRelacionados(
        $categoriaId,
        $productoId
    )
    {
        $sql = "
            SELECT *
            FROM productos
            WHERE categoria_id = :categoria_id
            AND id != :producto_id
            LIMIT 4
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(
            ':categoria_id',
            $categoriaId,
            PDO::PARAM_INT
        );

        $stmt->bindParam(
            ':producto_id',
            $productoId,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}