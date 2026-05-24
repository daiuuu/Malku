CREATE TABLE favoritos (

    id INT PRIMARY KEY AUTO_INCREMENT,

    usuario_id INT NOT NULL,

    producto_id INT NOT NULL,

    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_favorito_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_favorito_producto
    FOREIGN KEY (producto_id)
    REFERENCES productos(id)
    ON DELETE CASCADE

);