CREATE TABLE categorias (

    id INT PRIMARY KEY AUTO_INCREMENT,

    nombre VARCHAR(100) NOT NULL UNIQUE,

    slug VARCHAR(120) NOT NULL UNIQUE,

    descripcion TEXT,

    imagen VARCHAR(255),

    estado ENUM('activa', 'oculta') DEFAULT 'activa',

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);