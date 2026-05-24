CREATE TABLE cupones (
    id INT PRIMARY KEY AUTO_INCREMENT,

    codigo VARCHAR(50) NOT NULL UNIQUE,

    descripcion VARCHAR(255),

    tipo ENUM('porcentaje', 'fijo') NOT NULL,

    valor DECIMAL(10,2) NOT NULL,

    monto_minimo DECIMAL(10,2) DEFAULT 0,

    usos_maximos INT DEFAULT NULL,

    usos_actuales INT DEFAULT 0,

    fecha_inicio DATETIME NOT NULL,
    fecha_expiracion DATETIME NOT NULL,

    estado ENUM('activo', 'inactivo') DEFAULT 'activo',

    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);