<?php

require_once __DIR__ . '/../models/Categoria.php';

class CategoriaRepository
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new Categoria();
    }

    // ================= LISTAR CATEGORÍAS =================
    public function listar()
    {
        return $this->categoriaModel->obtenerTodas();
    }

    // ================= BUSCAR POR ID =================
    public function buscarPorId($id)
    {
        return $this->categoriaModel->obtenerPorId($id);
    }

    // ================= CREAR =================
    public function crear($datos)
    {
        return $this->categoriaModel->crear($datos);
    }

    // ================= ACTUALIZAR =================
    public function actualizar($id, $datos)
    {
        return $this->categoriaModel->actualizar(
            $id,
            $datos
        );
    }

    // ================= ELIMINAR =================
    public function eliminar($id)
    {
        return $this->categoriaModel->eliminar($id);
    }

    // ================= CONTAR PRODUCTOS =================
    public function contarProductos($categoriaId)
    {
        return $this->categoriaModel->contarProductos(
            $categoriaId
        );
    }
}