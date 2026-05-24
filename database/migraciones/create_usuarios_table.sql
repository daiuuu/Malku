CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,

    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    telefono VARCHAR(30),

    rol ENUM('cliente', 'admin') DEFAULT 'cliente',

    estado ENUM('activo', 'bloqueado') DEFAULT 'activo',

    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    ultimo_acceso TIMESTAMP NULL
);

ALTER TABLE usuarios

ADD foto_perfil VARCHAR(255) AFTER telefono,

ADD email_verificado BOOLEAN DEFAULT FALSE AFTER estado,

ADD token_recuperacion VARCHAR(255) AFTER email_verificado,

MODIFY estado ENUM(
    'activo',
    'bloqueado',
    'pendiente'
) DEFAULT 'activo',

ADD updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
ON UPDATE CURRENT_TIMESTAMP AFTER ultimo_acceso;