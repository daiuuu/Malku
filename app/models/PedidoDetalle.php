<?php

require_once __DIR__ .
    '/../../config/database.php';

class PedidoDetalle
{
    private $conexion;

    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();
    }

    // ================= CREAR =================
    public function crear(
        $pedidoId,
        $productoId,
        $cantidad,
        $precio
    )
    {
        try
        {
            $sql = "
                INSERT INTO pedido_detalles
                (
                    pedido_id,
                    producto_id,
                    cantidad,
                    precio
                )
                VALUES
                (
                    :pedido_id,
                    :producto_id,
                    :cantidad,
                    :precio
                )
            ";

            $stmt =
                $this->conexion->prepare($sql);

            return $stmt->execute([
                ':pedido_id' => $pedidoId,
                ':producto_id' => $productoId,
                ':cantidad' => $cantidad,
                ':precio' => $precio
            ]);
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