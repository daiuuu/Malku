<?php

require_once __DIR__ . '/../../config/database.php';

class ConfiguracionRepository
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
            CREATE TABLE IF NOT EXISTS configuracion (
                clave   VARCHAR(100) PRIMARY KEY,
                valor   TEXT,
                grupo   VARCHAR(50) NOT NULL DEFAULT ''
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $defaults = [
            // contacto
            ['contacto_email',         'hola@malku.com',              'contacto'],
            ['contacto_telefono',       '+54 9 11 6454-7751',          'contacto'],
            ['contacto_telefono_wa',    '5491164547751',               'contacto'],
            ['contacto_direccion',      'Av. General Paz 1240',        'contacto'],
            ['contacto_ciudad',         'Buenos Aires, Argentina',     'contacto'],
            ['contacto_horario',        'Lun—Vie, 10am—6pm',          'contacto'],
            ['contacto_instagram',      '#',                           'contacto'],
            ['contacto_facebook',       '#',                           'contacto'],
            // envios
            ['envios_ba_precio',        'Gratis en compras +$250.000', 'envios'],
            ['envios_ba_desc',          'Entregas dentro de 24 a 72 horas hábiles mediante logística premium y seguimiento en tiempo real.', 'envios'],
            ['envios_nacional_precio',  'Calculado al finalizar compra', 'envios'],
            ['envios_nacional_desc',    'Cobertura en todo el país con tiempos estimados entre 3 y 7 días hábiles según la provincia.', 'envios'],
            ['envios_compromiso',       'Creemos que el lujo nunca debe existir a costa de la tierra. Todos los pedidos MALKU utilizan materiales reciclables y procesos de logística responsables que reducen el impacto ambiental.', 'envios'],
            ['dev_intro',               'Queremos que cada pieza MALKU forme parte de tu historia. Si algo no resulta exactamente como esperabas, ofrecemos un proceso de cambio simple y respetuoso.', 'envios'],
            ['dev_ventana_dias',        '14',                          'envios'],
            ['dev_ventana_desc',        'Los productos pueden devolverse dentro de los 14 días posteriores a la entrega, siempre que conserven su estado original y etiquetas intactas.', 'envios'],
            ['dev_reembolso_desc',      'Una vez inspeccionada la pieza, el reintegro será procesado al método de pago original dentro de los siguientes 5 a 7 días hábiles.', 'envios'],
            ['dev_cambios_desc',        'Para cambios de talle o color, recomendamos iniciar el proceso apenas recibas tu pedido para garantizar disponibilidad.', 'envios'],
            ['dev_atencion_desc',       'Acompañamos cada solicitud de manera individual para preservar la experiencia artesanal de la marca.', 'envios'],
        ];

        $stmt = $this->db->prepare(
            "INSERT IGNORE INTO configuracion (clave, valor, grupo) VALUES (:clave, :valor, :grupo)"
        );
        foreach ($defaults as $d) {
            $stmt->execute([':clave' => $d[0], ':valor' => $d[1], ':grupo' => $d[2]]);
        }
    }

    public function obtenerGrupo($grupo)
    {
        $stmt = $this->db->prepare("SELECT clave, valor FROM configuracion WHERE grupo = :grupo");
        $stmt->execute([':grupo' => $grupo]);
        $rows   = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['clave']] = $row['valor'];
        }
        return $result;
    }

    public function guardarGrupo($grupo, array $datos)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO configuracion (clave, valor, grupo) VALUES (:clave, :valor, :grupo)
             ON DUPLICATE KEY UPDATE valor = VALUES(valor)"
        );
        foreach ($datos as $clave => $valor) {
            $stmt->execute([':clave' => $clave, ':valor' => $valor, ':grupo' => $grupo]);
        }
        return true;
    }
}
