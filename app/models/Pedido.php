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