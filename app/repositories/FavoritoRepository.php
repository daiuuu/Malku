<?php

require_once __DIR__ . '/../../config/database.php';

class FavoritoRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function obtenerPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT f.id AS favorito_id, f.fecha_agregado,
                   p.id AS producto_id, p.nombre, p.slug, p.precio,
                   p.imagen_principal, p.estado
            FROM favoritos f
            JOIN productos p ON f.producto_id = p.id
            WHERE f.usuario_id = :uid
            ORDER BY f.fecha_agregado DESC
        ");
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar($usuarioId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favoritos WHERE usuario_id = :uid");
        $stmt->execute([':uid' => $usuarioId]);
        return (int)$stmt->fetchColumn();
    }

    public function existe($usuarioId, $productoId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favoritos WHERE usuario_id = :uid AND producto_id = :pid");
        $stmt->execute([':uid' => $usuarioId, ':pid' => $productoId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function agregar($usuarioId, $productoId)
    {
        if ($this->existe($usuarioId, $productoId)) return true;
        $stmt = $this->db->prepare("INSERT INTO favoritos (usuario_id, producto_id) VALUES (:uid, :pid)");
        return $stmt->execute([':uid' => $usuarioId, ':pid' => $productoId]);
    }

    public function eliminar($favoritoId, $usuarioId)
    {
        $stmt = $this->db->prepare("DELETE FROM favoritos WHERE id = :id AND usuario_id = :uid");
        return $stmt->execute([':id' => $favoritoId, ':uid' => $usuarioId]);
    }
}
