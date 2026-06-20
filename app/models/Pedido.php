<?php

require_once __DIR__ .
    '/../../config/database.php';

class Pedido
{
    private $conexion;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();
    }

    // ================= ÚLTIMO PEDIDO POR USUARIO =================
    public function obtenerUltimoPorUsuario(
        $usuarioId
    )
    {
        try
        {
            $sql = "
                SELECT *
                FROM pedidos
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_pedido DESC
                LIMIT 1
            ";

            $stmt =
                $this->conexion->prepare($sql);

            $stmt->bindParam(
                ':usuario_id',
                $usuarioId,
                PDO::PARAM_INT
            );

            $stmt->execute();

            return $stmt->fetch(
                PDO::FETCH_ASSOC
            );
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerUltimoPorUsuario(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= CONTAR POR USUARIO =================
    public function contarPorUsuario(
        $usuarioId
    )
    {
        try
        {
            $sql = "
                SELECT COUNT(*) AS total
                FROM pedidos
                WHERE usuario_id = :usuario_id
            ";

            $stmt =
                $this->conexion->prepare($sql);

            $stmt->bindParam(
                ':usuario_id',
                $usuarioId,
                PDO::PARAM_INT
            );

            $stmt->execute();

            $fila = $stmt->fetch(
                PDO::FETCH_ASSOC
            );

            return (int)($fila['total'] ?? 0);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error contarPorUsuario(): ' .
                $e->getMessage()
            );

            return 0;
        }
    }

    // ================= CREAR =================
    public function crear(
        $usuarioId,
        $total
    )
    {
        try
        {
            $sql = "
                INSERT INTO pedidos
                (
                    usuario_id,
                    total,
                    estado,
                    fecha_creacion
                )
                VALUES
                (
                    :usuario_id,
                    :total,
                    'pendiente',
                    NOW()
                )
            ";

            $stmt =
                $this->conexion->prepare($sql);

            $stmt->execute([
                ':usuario_id' => $usuarioId,
                ':total' => $total
            ]);

            return
                $this->conexion->lastInsertId();
        }
        catch(PDOException $e)
        {
            error_log(
                $e->getMessage()
            );

            return false;
        }
    }
}