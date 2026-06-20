<?php

require_once __DIR__ . '/../../config/database.php';

class PreguntaFrecuenteRepository
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conectar();
        $this->inicializar();
    }

    private function inicializar()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS preguntas_frecuentes (
                id       INT AUTO_INCREMENT PRIMARY KEY,
                pregunta VARCHAR(500) NOT NULL,
                respuesta TEXT        NOT NULL,
                orden    INT          NOT NULL DEFAULT 0,
                activo   TINYINT(1)   NOT NULL DEFAULT 1,
                creado_en TIMESTAMP   DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function obtenerTodas(): array
    {
        return $this->db
            ->query("SELECT * FROM preguntas_frecuentes ORDER BY orden ASC, id ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerActivas(): array
    {
        return $this->db
            ->query("SELECT * FROM preguntas_frecuentes WHERE activo = 1 ORDER BY orden ASC, id ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM preguntas_frecuentes WHERE id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function crear(array $datos): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO preguntas_frecuentes (pregunta, respuesta, orden, activo)
            VALUES (:pregunta, :respuesta, :orden, :activo)
        ");
        $stmt->execute([
            ':pregunta'  => $datos['pregunta'],
            ':respuesta' => $datos['respuesta'],
            ':orden'     => (int)($datos['orden'] ?? 0),
            ':activo'    => isset($datos['activo']) ? 1 : 0,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->db->prepare("
            UPDATE preguntas_frecuentes
            SET pregunta  = :pregunta,
                respuesta = :respuesta,
                orden     = :orden,
                activo    = :activo
            WHERE id = :id
        ");
        return $stmt->execute([
            ':pregunta'  => $datos['pregunta'],
            ':respuesta' => $datos['respuesta'],
            ':orden'     => (int)($datos['orden'] ?? 0),
            ':activo'    => isset($datos['activo']) ? 1 : 0,
            ':id'        => $id,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM preguntas_frecuentes WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }
}
