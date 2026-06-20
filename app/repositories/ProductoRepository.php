<?php

require_once __DIR__ . '/../../config/database.php';

class ProductoRepository
{
    private $conexion;

    public function __construct($conexion = null)
    {
        if ($conexion) {
            $this->conexion = $conexion;
        } else {
            $this->conexion = (new Database())->conectar();
        }
    }

    public function obtenerTodos()
    {
        return $this->conexion->query("
            SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            ORDER BY p.fecha_creacion DESC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->conexion->prepare("
            SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = :id LIMIT 1
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerRelacionados($categoriaId, $productoId)
    {
        $stmt = $this->conexion->prepare("
            SELECT * FROM productos
            WHERE categoria_id = :categoria_id
            AND id != :producto_id
            AND estado = 'activo'
            LIMIT 4
        ");
        $stmt->bindParam(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar()
    {
        return (int)$this->conexion->query(
            "SELECT COUNT(*) FROM productos WHERE estado = 'activo'"
        )->fetchColumn();
    }

    public function masMostrados($limite = 5)
    {
        $stmt = $this->conexion->prepare("
            SELECT p.nombre, COALESCE(SUM(pd.cantidad), 0) AS total_vendido
            FROM productos p
            LEFT JOIN pedido_detalle pd ON pd.producto_id = p.id
            GROUP BY p.id
            ORDER BY total_vendido DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function stockBajo($umbral = 5)
    {
        $stmt = $this->conexion->prepare("
            SELECT * FROM productos
            WHERE stock <= :umbral AND estado != 'oculto'
            ORDER BY stock ASC
        ");
        $stmt->execute([':umbral' => $umbral]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($datos)
    {
        $stmt = $this->conexion->prepare("
            INSERT INTO productos
            (categoria_id, nombre, slug, descripcion, precio, stock, imagen_principal, destacado, estado, materiales, cuidados)
            VALUES
            (:categoria_id, :nombre, :slug, :descripcion, :precio, :stock, :imagen, :destacado, :estado, :materiales, :cuidados)
        ");
        return $stmt->execute([
            ':categoria_id' => $datos['categoria_id'],
            ':nombre'       => $datos['nombre'],
            ':slug'         => $datos['slug'],
            ':descripcion'  => $datos['descripcion'],
            ':precio'       => $datos['precio'],
            ':stock'        => $datos['stock'],
            ':imagen'       => $datos['imagen_principal'] ?? '',
            ':destacado'    => $datos['destacado'] ?? 0,
            ':estado'       => $datos['estado'] ?? 'activo',
            ':materiales'   => $datos['materiales'] ?? null,
            ':cuidados'     => $datos['cuidados'] ?? null,
        ]);
    }

    public function actualizar($id, $datos)
    {
        $stmt = $this->conexion->prepare("
            UPDATE productos SET
                categoria_id        = :categoria_id,
                nombre              = :nombre,
                slug                = :slug,
                descripcion         = :descripcion,
                precio              = :precio,
                stock               = :stock,
                destacado           = :destacado,
                estado              = :estado,
                materiales          = :materiales,
                cuidados            = :cuidados,
                fecha_actualizacion = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':categoria_id' => $datos['categoria_id'],
            ':nombre'       => $datos['nombre'],
            ':slug'         => $datos['slug'],
            ':descripcion'  => $datos['descripcion'],
            ':precio'       => $datos['precio'],
            ':stock'        => $datos['stock'],
            ':destacado'    => $datos['destacado'] ?? 0,
            ':estado'       => $datos['estado'],
            ':materiales'   => $datos['materiales'] ?? null,
            ':cuidados'     => $datos['cuidados'] ?? null,
            ':id'           => $id,
        ]);
    }

    public function actualizarImagen($id, $imagen)
    {
        $stmt = $this->conexion->prepare("UPDATE productos SET imagen_principal = :img WHERE id = :id");
        return $stmt->execute([':img' => $imagen, ':id' => $id]);
    }

    public function cambiarEstado($id, $estado)
    {
        $stmt = $this->conexion->prepare("UPDATE productos SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    public function ajustarStock($id, $cantidad)
    {
        $stmt = $this->conexion->prepare("UPDATE productos SET stock = stock + :cantidad WHERE id = :id");
        return $stmt->execute([':cantidad' => $cantidad, ':id' => $id]);
    }
}
