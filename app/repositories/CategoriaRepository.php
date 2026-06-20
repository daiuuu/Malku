<?php

require_once __DIR__ . '/../../config/database.php';

class CategoriaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function obtenerTodas()
    {
        return $this->db->query("
            SELECT c.*, COUNT(p.id) AS total_productos
            FROM categorias c
            LEFT JOIN productos p ON p.categoria_id = c.id AND p.estado != 'oculto'
            GROUP BY c.id
            ORDER BY c.nombre ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerActivas()
    {
        return $this->db->query("
            SELECT * FROM categorias WHERE estado = 'activa' ORDER BY nombre ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorSlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos)
    {
        $stmt = $this->db->prepare("
            INSERT INTO categorias (nombre, slug, descripcion, imagen, estado)
            VALUES (:nombre, :slug, :descripcion, :imagen, :estado)
        ");
        return $stmt->execute([
            ':nombre'      => $datos['nombre'],
            ':slug'        => $datos['slug'],
            ':descripcion' => $datos['descripcion'] ?? null,
            ':imagen'      => $datos['imagen'] ?? null,
            ':estado'      => $datos['estado'] ?? 'activa',
        ]);
    }

    public function actualizar($id, $datos)
    {
        $stmt = $this->db->prepare("
            UPDATE categorias SET
                nombre      = :nombre,
                slug        = :slug,
                descripcion = :descripcion,
                estado      = :estado
            WHERE id = :id
        ");
        return $stmt->execute([
            ':nombre'      => $datos['nombre'],
            ':slug'        => $datos['slug'],
            ':descripcion' => $datos['descripcion'] ?? null,
            ':estado'      => $datos['estado'],
            ':id'          => $id,
        ]);
    }

    public function cambiarEstado($id, $estado)
    {
        $stmt = $this->db->prepare("UPDATE categorias SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }
}
