CREATE TABLE stock_movimientos (
    id INT PRIMARY KEY AUTO_INCREMENT,

    producto_id INT NOT NULL,

    tipo_movimiento ENUM(
        'entrada',
        'salida',
        'ajuste'
    ) NOT NULL,

    cantidad INT NOT NULL,

    stock_anterior INT NOT NULL,
    stock_nuevo INT NOT NULL,

    motivo VARCHAR(255),

    usuario_admin_id INT,

    fecha_movimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (producto_id)
        REFERENCES productos(id)
        ON DELETE CASCADE,

    FOREIGN KEY (usuario_admin_id)
        REFERENCES usuarios(id)
        ON DELETE SET NULL
);