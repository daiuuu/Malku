CREATE TABLE carrito_detalle (

    id INT PRIMARY KEY AUTO_INCREMENT,

    carrito_id INT NOT NULL,

    producto_id INT NOT NULL,

    cantidad INT NOT NULL DEFAULT 1,

    precio_unitario DECIMAL(10,2) NOT NULL,

    subtotal DECIMAL(10,2) GENERATED ALWAYS AS
    (cantidad * precio_unitario) STORED,

    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_detalle_carrito
    FOREIGN KEY (carrito_id)
    REFERENCES carrito(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_detalle_producto
    FOREIGN KEY (producto_id)
    REFERENCES productos(id)
    ON DELETE CASCADE

);