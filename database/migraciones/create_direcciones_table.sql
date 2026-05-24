CREATE TABLE direcciones (

    id INT PRIMARY KEY AUTO_INCREMENT,

    usuario_id INT NOT NULL,

    nombre_recibe VARCHAR(120) NOT NULL,

    telefono VARCHAR(30) NOT NULL,

    calle VARCHAR(150) NOT NULL,

    numero VARCHAR(20) NOT NULL,

    piso VARCHAR(20),

    departamento VARCHAR(20),

    ciudad VARCHAR(100) NOT NULL,

    provincia VARCHAR(100) NOT NULL,

    codigo_postal VARCHAR(20) NOT NULL,

    pais VARCHAR(100) DEFAULT 'Argentina',

    referencia TEXT,

    principal BOOLEAN DEFAULT FALSE,

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_direccion_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE

);