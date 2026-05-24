CREATE TABLE contacto (
    id INT PRIMARY KEY AUTO_INCREMENT,

    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),

    email VARCHAR(150) NOT NULL,
    telefono VARCHAR(30),

    asunto VARCHAR(150),
    
    mensaje TEXT NOT NULL,

    estado ENUM('pendiente', 'leido', 'respondido') DEFAULT 'pendiente',

    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);