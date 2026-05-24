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