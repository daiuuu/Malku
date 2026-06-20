<?php

require_once __DIR__ . '/../../config/database.php';

class PedidoRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function obtenerTodos()
    {
        return $this->db->query("
            SELECT p.*, u.nombre, u.apellido, u.email
            FROM pedidos p
            LEFT JOIN usuarios u ON p.usuario_id = u.id
            ORDER BY p.fecha_creacion DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, u.nombre, u.apellido, u.email, u.telefono
            FROM pedidos p
            LEFT JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.id = :id LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDetalle($pedidoId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM pedido_detalle WHERE pedido_id = :id ORDER BY id ASC
        ");
        $stmt->execute([':id' => $pedidoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado($id, $estado)
    {
        $stmt = $this->db->prepare("UPDATE pedidos SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    public function contarHoy()
    {
        return (int)$this->db->query(
            "SELECT COUNT(*) FROM pedidos WHERE DATE(fecha_creacion) = CURDATE()"
        )->fetchColumn();
    }

    public function totalMes()
    {
        $val = $this->db->query(
            "SELECT COALESCE(SUM(total),0) FROM pedidos
             WHERE MONTH(fecha_creacion) = MONTH(NOW())
             AND YEAR(fecha_creacion) = YEAR(NOW())"
        )->fetchColumn();
        return (float)$val;
    }

    public function totalMesAnterior()
    {
        $val = $this->db->query(
            "SELECT COALESCE(SUM(total),0) FROM pedidos
             WHERE MONTH(fecha_creacion) = MONTH(NOW() - INTERVAL 1 MONTH)
             AND YEAR(fecha_creacion) = YEAR(NOW() - INTERVAL 1 MONTH)"
        )->fetchColumn();
        return (float)$val;
    }

    public function ultimosCinco()
    {
        return $this->db->query("
            SELECT p.*, u.nombre, u.apellido
            FROM pedidos p
            LEFT JOIN usuarios u ON p.usuario_id = u.id
            ORDER BY p.fecha_creacion DESC LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ventasPorMes()
    {
        return $this->db->query("
            SELECT
                MONTH(fecha_creacion) AS mes,
                YEAR(fecha_creacion) AS anio,
                COUNT(*) AS cantidad,
                SUM(total) AS total
            FROM pedidos
            WHERE fecha_creacion >= NOW() - INTERVAL 12 MONTH
            GROUP BY YEAR(fecha_creacion), MONTH(fecha_creacion)
            ORDER BY anio ASC, mes ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}
