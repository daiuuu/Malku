CREATE TABLE carrito (

    id INT PRIMARY KEY AUTO_INCREMENT,

    usuario_id INT NOT NULL,

    estado ENUM('activo', 'abandonado', 'finalizado')
    DEFAULT 'activo',

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_carrito_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE

);