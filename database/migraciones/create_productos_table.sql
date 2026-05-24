CREATE TABLE productos (

    id INT PRIMARY KEY AUTO_INCREMENT,

    categoria_id INT NOT NULL,

    nombre VARCHAR(150) NOT NULL,

    slug VARCHAR(180) NOT NULL UNIQUE,

    descripcion TEXT NOT NULL,

    precio DECIMAL(10,2) NOT NULL,

    stock INT DEFAULT 0,

    imagen_principal VARCHAR(255) NOT NULL,

    destacado BOOLEAN DEFAULT FALSE,

    estado ENUM('activo', 'oculto', 'agotado') DEFAULT 'activo',

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_producto_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)

);