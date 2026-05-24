CREATE TABLE membresias (
    id INT PRIMARY KEY AUTO_INCREMENT,

    usuario_id INT NOT NULL,

    tipo ENUM(
        'basica',
        'premium',
        'exclusive'
    ) DEFAULT 'basica',

    fecha_inicio DATETIME NOT NULL,

    fecha_expiracion DATETIME NOT NULL,

    estado ENUM(
        'activa',
        'vencida',
        'cancelada'
    ) DEFAULT 'activa',

    renovacion_automatica BOOLEAN DEFAULT FALSE,

    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);