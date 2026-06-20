<?php

require_once __DIR__ . '/../../config/database.php';

class DireccionRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
    }

    public function obtenerPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM direcciones WHERE usuario_id = :uid ORDER BY principal DESC, id ASC
        ");
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id, $usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM direcciones WHERE id = :id AND usuario_id = :uid LIMIT 1
        ");
        $stmt->execute([':id' => $id, ':uid' => $usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contar($usuarioId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM direcciones WHERE usuario_id = :uid");
        $stmt->execute([':uid' => $usuarioId]);
        return (int)$stmt->fetchColumn();
    }

    public function crear($datos)
    {
        if ($datos['principal']) {
            $this->db->prepare("UPDATE direcciones SET principal = 0 WHERE usuario_id = :uid")
                ->execute([':uid' => $datos['usuario_id']]);
        }
        $stmt = $this->db->prepare("
            INSERT INTO direcciones
                (usuario_id, nombre_recibe, telefono, calle, numero, piso, departamento,
                 ciudad, provincia, codigo_postal, referencia, principal)
            VALUES
                (:uid, :nombre_recibe, :telefono, :calle, :numero, :piso, :depto,
                 :ciudad, :provincia, :cp, :referencia, :principal)
        ");
        return $stmt->execute([
            ':uid'          => $datos['usuario_id'],
            ':nombre_recibe'=> $datos['nombre_recibe'],
            ':telefono'     => $datos['telefono'],
            ':calle'        => $datos['calle'],
            ':numero'       => $datos['numero'],
            ':piso'         => $datos['piso'] ?? null,
            ':depto'        => $datos['departamento'] ?? null,
            ':ciudad'       => $datos['ciudad'],
            ':provincia'    => $datos['provincia'],
            ':cp'           => $datos['codigo_postal'],
            ':referencia'   => $datos['referencia'] ?? null,
            ':principal'    => $datos['principal'] ? 1 : 0,
        ]);
    }

    public function actualizar($id, $usuarioId, $datos)
    {
        if ($datos['principal']) {
            $this->db->prepare("UPDATE direcciones SET principal = 0 WHERE usuario_id = :uid")
                ->execute([':uid' => $usuarioId]);
        }
        $stmt = $this->db->prepare("
            UPDATE direcciones
            SET nombre_recibe = :nombre_recibe, telefono = :telefono,
                calle = :calle, numero = :numero, piso = :piso, departamento = :depto,
                ciudad = :ciudad, provincia = :provincia, codigo_postal = :cp,
                referencia = :referencia, principal = :principal
            WHERE id = :id AND usuario_id = :uid
        ");
        return $stmt->execute([
            ':nombre_recibe'=> $datos['nombre_recibe'],
            ':telefono'     => $datos['telefono'],
            ':calle'        => $datos['calle'],
            ':numero'       => $datos['numero'],
            ':piso'         => $datos['piso'] ?? null,
            ':depto'        => $datos['departamento'] ?? null,
            ':ciudad'       => $datos['ciudad'],
            ':provincia'    => $datos['provincia'],
            ':cp'           => $datos['codigo_postal'],
            ':referencia'   => $datos['referencia'] ?? null,
            ':principal'    => $datos['principal'] ? 1 : 0,
            ':id'           => $id,
            ':uid'          => $usuarioId,
        ]);
    }

    public function eliminar($id, $usuarioId)
    {
        $stmt = $this->db->prepare("DELETE FROM direcciones WHERE id = :id AND usuario_id = :uid");
        return $stmt->execute([':id' => $id, ':uid' => $usuarioId]);
    }

    public function marcarPrincipal($id, $usuarioId)
    {
        $this->db->prepare("UPDATE direcciones SET principal = 0 WHERE usuario_id = :uid")
            ->execute([':uid' => $usuarioId]);
        $stmt = $this->db->prepare("UPDATE direcciones SET principal = 1 WHERE id = :id AND usuario_id = :uid");
        return $stmt->execute([':id' => $id, ':uid' => $usuarioId]);
    }
}
