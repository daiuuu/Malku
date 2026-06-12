<?php

class Carrito
{
    // ================= OBTENER CARRITO =================
    public function obtenerCarrito()
    {
        if(!isset($_SESSION['carrito']))
        {
            $_SESSION['carrito'] = [];
        }

        return $_SESSION['carrito'];
    }

    // ================= AGREGAR PRODUCTO =================
    public function agregarProducto(
        $producto
    )
    {
        if(!isset($_SESSION['carrito']))
        {
            $_SESSION['carrito'] = [];
        }

        $id = $producto['id'];

        // ================= EXISTE =================
        if(isset($_SESSION['carrito'][$id]))
        {
            $_SESSION['carrito'][$id]['cantidad'] +=
                $producto['cantidad'];
        }
        else
        {
            $_SESSION['carrito'][$id] = $producto;
        }
    }

    // ================= ACTUALIZAR CANTIDAD ============
    public function actualizarCantidad(
        $idProducto,
        $cantidad
    )
    {
        if(
            isset($_SESSION['carrito'][$idProducto])
        )
        {
            if($cantidad <= 0)
            {
                unset($_SESSION['carrito'][$idProducto]);
            }
            else
            {
                $_SESSION['carrito'][$idProducto]['cantidad'] =
                    $cantidad;
            }
        }
    }

    // ================= ELIMINAR PRODUCTO ==============
    public function eliminarProducto(
        $idProducto
    )
    {
        if(
            isset($_SESSION['carrito'][$idProducto])
        )
        {
            unset($_SESSION['carrito'][$idProducto]);
        }
    }

    // ================= LIMPIAR CARRITO ================
    public function vaciarCarrito()
    {
        $_SESSION['carrito'] = [];
    }

    // ================= TOTAL ==========================
    public function obtenerTotal()
    {
        $total = 0;

        if(isset($_SESSION['carrito']))
        {
            foreach($_SESSION['carrito'] as $item)
            {
                $total += (
                    $item['precio'] *
                    $item['cantidad']
                );
            }
        }

        return $total;
    }

    // ================= CANTIDAD ITEMS =================
    public function obtenerCantidadItems()
    {
        $cantidad = 0;

        if(isset($_SESSION['carrito']))
        {
            foreach($_SESSION['carrito'] as $item)
            {
                $cantidad += $item['cantidad'];
            }
        }

        return $cantidad;
    }

    // ================= OBTENER PRODUCTOS ==============
    public function obtenerProductos()
    {
        return $this->obtenerCarrito();
    }
}