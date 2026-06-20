<?php

require_once __DIR__ . '/../../config/database.php';

class CuponRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
        $this->inicializar();
    }

    private function inicializar()
    {
        // If the old stub table exists without usuario_id, drop and recreate it
        $tiene = $this->db->query("
            SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME   = 'cupones'
              AND COLUMN_NAME  = 'usuario_id'
        ")->fetchColumn();

        if (!$tiene) {
            $this->db->exec("DROP TABLE IF EXISTS cupones");
        }

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS cupones (
                id               INT AUTO_INCREMENT PRIMARY KEY,
                codigo           VARCHAR(50)  NOT NULL UNIQUE,
                tipo             ENUM('porcentaje','monto_fijo') NOT NULL DEFAULT 'porcentaje',
                valor            DECIMAL(10,2) NOT NULL,
                minimo_compra    DECIMAL(10,2) DEFAULT 0,
                usos_maximos     INT DEFAULT NULL,
                usos_actuales    INT DEFAULT 0,
                usuario_id       INT DEFAULT NULL,
                activo           TINYINT(1) DEFAULT 1,
                fecha_expiracion DATE DEFAULT NULL,
                origen           ENUM('manual','regalo_membresia','giftcard') DEFAULT 'manual',
                nota             VARCHAR(255) DEFAULT NULL,
                creado_en        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    public function obtenerTodos()
    {
        return $this->db->query("
            SELECT c.*, u.nombre, u.apellido, u.email
            FROM cupones c
            LEFT JOIN usuarios u ON c.usuario_id = u.id
            ORDER BY c.creado_en DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cupones WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCodigo($codigo)
    {
        $stmt = $this->db->prepare("SELECT * FROM cupones WHERE codigo = :codigo");
        $stmt->execute([':codigo' => strtoupper(trim($codigo))]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM cupones
            WHERE usuario_id = :uid
            ORDER BY creado_en DESC
        ");
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear(array $datos)
    {
        $stmt = $this->db->prepare("
            INSERT INTO cupones
                (codigo, tipo, valor, minimo_compra, usos_maximos, usuario_id, activo, fecha_expiracion, origen, nota)
            VALUES
                (:codigo, :tipo, :valor, :minimo, :maximos, :uid, :activo, :expira, :origen, :nota)
        ");
        return $stmt->execute([
            ':codigo'  => strtoupper(trim($datos['codigo'])),
            ':tipo'    => $datos['tipo'],
            ':valor'   => (float)$datos['valor'],
            ':minimo'  => (float)($datos['minimo_compra'] ?? 0),
            ':maximos' => (isset($datos['usos_maximos']) && $datos['usos_maximos'] !== '') ? (int)$datos['usos_maximos'] : null,
            ':uid'     => !empty($datos['usuario_id']) ? (int)$datos['usuario_id'] : null,
            ':activo'  => isset($datos['activo']) ? (int)$datos['activo'] : 1,
            ':expira'  => !empty($datos['fecha_expiracion']) ? $datos['fecha_expiracion'] : null,
            ':origen'  => $datos['origen'] ?? 'manual',
            ':nota'    => $datos['nota'] ?? null,
        ]);
    }

    public function actualizar($id, array $datos)
    {
        $stmt = $this->db->prepare("
            UPDATE cupones SET
                codigo           = :codigo,
                tipo             = :tipo,
                valor            = :valor,
                minimo_compra    = :minimo,
                usos_maximos     = :maximos,
                activo           = :activo,
                fecha_expiracion = :expira,
                nota             = :nota
            WHERE id = :id
        ");
        return $stmt->execute([
            ':codigo'  => strtoupper(trim($datos['codigo'])),
            ':tipo'    => $datos['tipo'],
            ':valor'   => (float)$datos['valor'],
            ':minimo'  => (float)($datos['minimo_compra'] ?? 0),
            ':maximos' => (isset($datos['usos_maximos']) && $datos['usos_maximos'] !== '') ? (int)$datos['usos_maximos'] : null,
            ':activo'  => (int)($datos['activo'] ?? 0),
            ':expira'  => !empty($datos['fecha_expiracion']) ? $datos['fecha_expiracion'] : null,
            ':nota'    => $datos['nota'] ?? null,
            ':id'      => $id,
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM cupones WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function incrementarUso($id)
    {
        $stmt = $this->db->prepare("UPDATE cupones SET usos_actuales = usos_actuales + 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Returns null if valid, error string if not
    public function validar($codigo, $total, $usuarioId = null)
    {
        $cupon = $this->obtenerPorCodigo($codigo);

        if (!$cupon)           return 'El código no existe.';
        if (!$cupon['activo']) return 'El cupón está inactivo.';

        if ($cupon['fecha_expiracion'] && $cupon['fecha_expiracion'] < date('Y-m-d')) {
            return 'El cupón venció el ' . date('d/m/Y', strtotime($cupon['fecha_expiracion'])) . '.';
        }

        if ($cupon['usos_maximos'] !== null && $cupon['usos_actuales'] >= $cupon['usos_maximos']) {
            return 'El cupón ya no tiene usos disponibles.';
        }

        if ($cupon['minimo_compra'] > 0 && $total < $cupon['minimo_compra']) {
            return 'El mínimo de compra para este cupón es $' . number_format($cupon['minimo_compra'], 0, ',', '.') . '.';
        }

        if ($cupon['usuario_id'] !== null && (int)$cupon['usuario_id'] !== (int)$usuarioId) {
            return 'Este cupón no está disponible para tu cuenta.';
        }

        return null;
    }

    public function calcularDescuento(array $cupon, float $total): float
    {
        if ($cupon['tipo'] === 'porcentaje') {
            return round($total * $cupon['valor'] / 100);
        }
        return min($total, (float)$cupon['valor']);
    }
}
