CREATE TABLE producto_imagenes (

    id INT PRIMARY KEY AUTO_INCREMENT,

    producto_id INT NOT NULL,

    imagen VARCHAR(255) NOT NULL,

    alt VARCHAR(150),

    orden_imagen INT DEFAULT 1,

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_imagen_producto
    FOREIGN KEY (producto_id)
    REFERENCES productos(id)
    ON DELETE CASCADE

);