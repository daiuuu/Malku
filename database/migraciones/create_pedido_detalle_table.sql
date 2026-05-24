CREATE TABLE pedido_detalle (

    id INT PRIMARY KEY AUTO_INCREMENT,

    pedido_id INT NOT NULL,

    producto_id INT NOT NULL,

    nombre_producto VARCHAR(150) NOT NULL,

    precio_unitario DECIMAL(10,2) NOT NULL,

    cantidad INT NOT NULL DEFAULT 1,

    subtotal DECIMAL(10,2) GENERATED ALWAYS AS
    (cantidad * precio_unitario) STORED,

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_detalle_pedido
    FOREIGN KEY (pedido_id)
    REFERENCES pedidos(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_detalle_producto_pedido
    FOREIGN KEY (producto_id)
    REFERENCES productos(id)

);