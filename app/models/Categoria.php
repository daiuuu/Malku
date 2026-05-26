<?php

require_once __DIR__ . '/../../config/database.php';

class Categoria
{
    private $conexion;

    public function __construct()
    {
        $database = new Database();

        $this->conexion = $database->conectar();
    }

    // ================= OBTENER TODAS LAS CATEGORÍAS =================
    public function obtenerTodas()
    {
        $sql = "
            SELECT
                *
            FROM categorias
            ORDER BY nombre ASC
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    // ================= OBTENER CATEGORÍA POR ID =================
    public function obtenerPorId($id)
    {
        $sql = "
            SELECT
                *
            FROM categorias
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(
            ':id',
            $id,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetch();
    }

    // ================= CREAR CATEGORÍA =================
    public function crear($datos)
    {
        $sql = "
            INSERT INTO categorias
            (
                nombre,
                slug,
                descripcion
            )
            VALUES
            (
                :nombre,
                :slug,
                :descripcion
            )
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':slug' => $datos['slug'],
            ':descripcion' => $datos['descripcion']
        ]);
    }

    // ================= ACTUALIZAR CATEGORÍA =================
    public function actualizar($id, $datos)
    {
        $sql = "
            UPDATE categorias
            SET
                nombre = :nombre,
                slug = :slug,
                descripcion = :descripcion
            WHERE id = :id
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':slug' => $datos['slug'],
            ':descripcion' => $datos['descripcion']
        ]);
    }

    // ================= ELIMINAR CATEGORÍA =================
    public function eliminar($id)
    {
        $sql = "
            DELETE FROM categorias
            WHERE id = :id
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    // ================= CONTAR PRODUCTOS DE LA CATEGORÍA =================
    public function contarProductos($categoriaId)
    {
        $sql = "
            SELECT
                COUNT(*) as total
            FROM productos
            WHERE categoria_id = :categoria_id
        ";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute([
            ':categoria_id' => $categoriaId
        ]);

        $resultado = $stmt->fetch();

        return $resultado['total'];
    }
}