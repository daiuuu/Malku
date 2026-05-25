<?php

require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoService
{
    private $carritoModel;
    private $productoModel;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->carritoModel = new Carrito();

        $this->productoModel = new Producto();
    }

    // ================= AGREGAR =====================
    public function agregarProducto(
        $idProducto,
        $cantidad = 1
    )
    {
        // ================= PRODUCTO =================
        $producto =
            $this->productoModel
                ->obtenerProductoPorId($idProducto);

        if(!$producto)
        {
            return false;
        }

        // ================= ITEM =====================
        $item = [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'imagen' => $producto['imagen_principal'],
            'cantidad' => $cantidad,
            'color' => $producto['color'] ?? 'Natural',
            'talle' => 'Único'
        ];

        $this->carritoModel->agregarProducto($item);

        return true;
    }

    // ================= ACTUALIZAR ==================
    public function actualizarCantidad(
        $idProducto,
        $cantidad
    )
    {
        $this->carritoModel->actualizarCantidad(
            $idProducto,
            $cantidad
        );
    }

    // ================= ELIMINAR ====================
    public function eliminarProducto(
        $idProducto
    )
    {
        $this->carritoModel->eliminarProducto(
            $idProducto
        );
    }

    // ================= OBTENER =====================
    public function obtenerCarrito()
    {
        return $this->carritoModel->obtenerCarrito();
    }

    // ================= TOTAL =======================
    public function obtenerTotal()
    {
        return $this->carritoModel->obtenerTotal();
    }

    // ================= ITEMS =======================
    public function obtenerCantidadItems()
    {
        return $this->carritoModel
            ->obtenerCantidadItems();
    }
}