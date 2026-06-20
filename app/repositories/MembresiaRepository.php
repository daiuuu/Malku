<?php

require_once __DIR__ . '/../../config/database.php';

class MembresiaRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
        $this->inicializarBeneficios();
    }

    // ── Crea la tabla y siembra los beneficios por defecto si no existen ──
    private function inicializarBeneficios()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS membresia_beneficios (
                id         INT AUTO_INCREMENT PRIMARY KEY,
                tier       ENUM('bronce','plata','oro') NOT NULL,
                titulo     VARCHAR(200) NOT NULL,
                descripcion TEXT,
                icono      VARCHAR(10) DEFAULT '✦',
                orden      INT DEFAULT 0,
                creado_en  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        $total = (int)$this->db->query("SELECT COUNT(*) FROM membresia_beneficios")->fetchColumn();
        if ($total > 0) return;

        $this->db->exec("
            INSERT INTO membresia_beneficios (tier, titulo, descripcion, icono, orden) VALUES
            ('bronce', 'Acceso al catálogo completo',  'Navegá toda la colección sin restricciones.',                     '✦', 1),
            ('bronce', 'Historial de compras',          'Consultá todos tus pedidos y su estado en tiempo real.',          '✦', 2),
            ('bronce', 'Favoritos ilimitados',           'Guardá las piezas que más te gustan para después.',              '✦', 3),
            ('plata',  'Todos los beneficios Bronce',   'Más los beneficios exclusivos del nivel Plata.',                  '✦', 1),
            ('plata',  'Envío bonificado',               'Envío gratuito en compras superiores a \$150.000.',              '✦', 2),
            ('plata',  'Acceso anticipado',              'Conocé las nuevas colecciones antes que nadie.',                 '✦', 3),
            ('oro',    'Todos los beneficios Plata',    'Más el nivel más alto de fidelidad de Malku.',                    '✦', 1),
            ('oro',    'Envío siempre gratis',           'Sin monto mínimo, en todo el país.',                             '✦', 2),
            ('oro',    'Servicio personalizado',         'Atención prioritaria y asesoramiento exclusivo.',                '✦', 3)
        ");
    }

    public function obtenerTodosConUsuarios()
    {
        return $this->db->query("
            SELECT
                u.id, u.nombre, u.apellido, u.email, u.estado AS usuario_estado,
                (
                    SELECT COALESCE(SUM(p.total), 0)
                    FROM pedidos p
                    WHERE p.usuario_id = u.id
                    AND p.estado IN ('pagado', 'enviado', 'entregado')
                ) AS total_gastado,
                (SELECT m.id           FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS membresia_id,
                (SELECT m.tipo         FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS membresia_tipo,
                (SELECT m.fecha_inicio FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS membresia_inicio,
                (SELECT m.fecha_expiracion FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS membresia_expiracion,
                (SELECT m.estado       FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS membresia_estado,
                (SELECT m.renovacion_automatica FROM membresias m WHERE m.usuario_id = u.id ORDER BY m.creado_en DESC LIMIT 1) AS renovacion_automatica
            FROM usuarios u
            WHERE u.rol = 'cliente'
            ORDER BY total_gastado DESC, u.nombre ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM membresias WHERE usuario_id = :uid ORDER BY creado_en DESC LIMIT 1
        ");
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerActivaPorUsuario($usuarioId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM membresias
            WHERE usuario_id = :uid
              AND estado = 'activa'
              AND (fecha_expiracion IS NULL OR fecha_expiracion > NOW())
            ORDER BY creado_en DESC LIMIT 1
        ");
        $stmt->execute([':uid' => $usuarioId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearOActualizar(array $datos)
    {
        $existente = $this->obtenerPorUsuario($datos['usuario_id']);

        if ($existente) {
            $stmt = $this->db->prepare("
                UPDATE membresias SET
                    tipo                 = :tipo,
                    fecha_inicio         = :fecha_inicio,
                    fecha_expiracion     = :fecha_expiracion,
                    estado               = :estado,
                    renovacion_automatica = :renovacion
                WHERE id = :id
            ");
            return $stmt->execute([
                ':tipo'             => $datos['tipo'],
                ':fecha_inicio'     => $datos['fecha_inicio'],
                ':fecha_expiracion' => $datos['fecha_expiracion'],
                ':estado'           => $datos['estado'],
                ':renovacion'       => $datos['renovacion_automatica'],
                ':id'               => $existente['id'],
            ]);
        }

        $stmt = $this->db->prepare("
            INSERT INTO membresias
                (usuario_id, tipo, fecha_inicio, fecha_expiracion, estado, renovacion_automatica)
            VALUES
                (:uid, :tipo, :fecha_inicio, :fecha_expiracion, :estado, :renovacion)
        ");
        return $stmt->execute([
            ':uid'              => $datos['usuario_id'],
            ':tipo'             => $datos['tipo'],
            ':fecha_inicio'     => $datos['fecha_inicio'],
            ':fecha_expiracion' => $datos['fecha_expiracion'],
            ':estado'           => $datos['estado'],
            ':renovacion'       => $datos['renovacion_automatica'],
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM membresias WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        $stmt = $this->db->prepare("UPDATE membresias SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    // ── BENEFICIOS ──────────────────────────────────────────────────────────

    public function obtenerBeneficios()
    {
        return $this->db->query("
            SELECT * FROM membresia_beneficios ORDER BY
                FIELD(tier,'bronce','plata','oro'), orden ASC, id ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBeneficiosPorTier($tier)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM membresia_beneficios
            WHERE tier = :tier ORDER BY orden ASC, id ASC
        ");
        $stmt->execute([':tier' => $tier]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBeneficioPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM membresia_beneficios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearBeneficio(array $datos)
    {
        $stmt = $this->db->prepare("
            INSERT INTO membresia_beneficios (tier, titulo, descripcion, icono, orden)
            VALUES (:tier, :titulo, :descripcion, :icono, :orden)
        ");
        return $stmt->execute([
            ':tier'        => $datos['tier'],
            ':titulo'      => $datos['titulo'],
            ':descripcion' => $datos['descripcion'] ?? null,
            ':icono'       => $datos['icono'] ?? '✦',
            ':orden'       => (int)($datos['orden'] ?? 0),
        ]);
    }

    public function actualizarBeneficio($id, array $datos)
    {
        $stmt = $this->db->prepare("
            UPDATE membresia_beneficios
            SET tier = :tier, titulo = :titulo, descripcion = :descripcion,
                icono = :icono, orden = :orden
            WHERE id = :id
        ");
        return $stmt->execute([
            ':tier'        => $datos['tier'],
            ':titulo'      => $datos['titulo'],
            ':descripcion' => $datos['descripcion'] ?? null,
            ':icono'       => $datos['icono'] ?? '✦',
            ':orden'       => (int)($datos['orden'] ?? 0),
            ':id'          => $id,
        ]);
    }

    public function eliminarBeneficio($id)
    {
        $stmt = $this->db->prepare("DELETE FROM membresia_beneficios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
