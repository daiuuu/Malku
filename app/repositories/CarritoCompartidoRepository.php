<?php

require_once __DIR__ . '/../../config/database.php';

class CarritoCompartidoRepository
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
            CREATE TABLE IF NOT EXISTS carritos_compartidos (
                id          INT AUTO_INCREMENT PRIMARY KEY,
                codigo      VARCHAR(16)  NOT NULL UNIQUE,
                usuario_id  INT          NULL,
                nombre      VARCHAR(120) NULL,
                items       LONGTEXT     NOT NULL,
                creado_en   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
                activo      TINYINT(1)   NOT NULL DEFAULT 1
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public function crear(array $datos): string
    {
        $codigo = $this->generarCodigo();

        $stmt = $this->db->prepare("
            INSERT INTO carritos_compartidos
                (codigo, usuario_id, nombre, items)
            VALUES
                (:codigo, :usuario_id, :nombre, :items)
        ");

        $stmt->execute([
            ':codigo'     => $codigo,
            ':usuario_id' => $datos['usuario_id'] ?? null,
            ':nombre'     => $datos['nombre']     ?? null,
            ':items'      => json_encode($datos['items'], JSON_UNESCAPED_UNICODE),
        ]);

        return $codigo;
    }

    public function obtenerPorCodigo(string $codigo): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM carritos_compartidos
            WHERE codigo = :codigo AND activo = 1
            LIMIT 1
        ");
        $stmt->execute([':codigo' => $codigo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        $row['items'] = json_decode($row['items'], true) ?? [];
        return $row;
    }

    private function generarCodigo(): string
    {
        do {
            $codigo = strtoupper(substr(md5(uniqid((string)rand(), true)), 0, 8));
            $check  = $this->db->prepare(
                "SELECT id FROM carritos_compartidos WHERE codigo = ?"
            );
            $check->execute([$codigo]);
        } while ($check->fetch());

        return $codigo;
    }
}
