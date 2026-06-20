<?php

require_once __DIR__ .
    '/../models/Pedido.php';

require_once __DIR__ .
    '/../models/PedidoDetalle.php';

require_once __DIR__ .
    '/../models/Carrito.php';

require_once __DIR__ .
    '/../models/Producto.php';

class PedidoService
{
    // ================= CREAR PEDIDO =================
    public function crearPedido($usuarioId, $descuento = 0)
    {
        $carritoModel =
            new Carrito();

        $pedidoModel =
            new Pedido();

        $detalleModel =
            new PedidoDetalle();

        $productoModel =
            new Producto();

        // ================= PRODUCTOS =================
        $productos =
            $carritoModel->obtenerProductos();

        if(empty($productos))
        {
            return false;
        }

        // ================= TOTAL =================
        $total = 0;

        foreach($productos as $producto)
        {
            $total +=
                $producto['precio']
                * $producto['cantidad'];
        }

        // ================= CREAR PEDIDO =================
        $totalFinal = max(0, $total - (float)$descuento);

        $pedidoId =
            $pedidoModel->crear(
                $usuarioId,
                $totalFinal
            );

        if(!$pedidoId)
        {
            return false;
        }

        // ================= DETALLES =================
        foreach($productos as $producto)
        {
            $detalleModel->crear(
                $pedidoId,
                $producto['id'],
                $producto['cantidad'],
                $producto['precio']
            );

            // ================= DESCONTAR STOCK =================
            $productoModel->descontarStock(
                $producto['id'],
                $producto['cantidad']
            );
        }

        // ================= LIMPIAR CARRITO =================
        unset($_SESSION['carrito']);

        return $pedidoId;
    }
}