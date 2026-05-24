CREATE TABLE pedidos (

    id INT PRIMARY KEY AUTO_INCREMENT,

    usuario_id INT NOT NULL,

    codigo VARCHAR(50) NOT NULL UNIQUE,

    estado ENUM(
        'pendiente',
        'pagado',
        'enviado',
        'entregado',
        'cancelado'
    ) DEFAULT 'pendiente',

    metodo_pago ENUM(
        'mercadopago',
        'transferencia',
        'tarjeta'
    ) NOT NULL,

    subtotal DECIMAL(10,2) NOT NULL,

    descuento DECIMAL(10,2) DEFAULT 0,

    costo_envio DECIMAL(10,2) DEFAULT 0,

    total DECIMAL(10,2) NOT NULL,

    observaciones TEXT,

    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_pedido_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)

);