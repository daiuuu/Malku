<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../services/ProductoService.php';

class Producto
{
    private $conexion;

    private $productoService;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();

        $this->productoService =
            new ProductoService(
                $this->conexion
            );
    }

    // ================= DETALLE POR ID =================
    public function obtenerPorId($id)
    {
        return $this->productoService
            ->obtenerDetalleProducto($id);
    }

    // ================= DETALLE POR SLUG =================
    public function obtenerPorSlug($slug)
    {
        try
        {
            // ================= SQL =================
            $sql = "
                SELECT
                    p.*,
                    c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c
                    ON p.categoria_id = c.id
                WHERE p.slug = :slug
                LIMIT 1
            ";

            // ================= PREPARAR =============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= EJECUTAR =============
            $stmt->execute([
                ':slug' => $slug
            ]);

            // ================= RETORNO ==============
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerPorSlug(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= RELACIONADOS =================
    public function obtenerRelacionados(
        $categoriaId,
        $productoId
    )
    {
        return $this->productoService
            ->obtenerRelacionados(
                $categoriaId,
                $productoId
            );
    }

    // ================= OBTENER PRODUCTO POR ID =================
    public function obtenerProductoPorId(
        $id
    )
    {
        try
        {
            // ================= SQL =================
            $sql = "
                SELECT
                    p.*,
                    c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c
                    ON p.categoria_id = c.id
                WHERE p.id = :id
                LIMIT 1
            ";

            // ================= PREPARAR ============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= EJECUTAR ============
            $stmt->execute([
                ':id' => $id
            ]);

            // ================= RETORNO =============
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerProductoPorId(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= COLECCIÓN =================
    public function obtenerColeccion(
        $buscar = '',
        $categoria = null,
        $orden = 'nuevos',
        $limite = 6,
        $offset = 0
    )
    {
        try
        {
            // ================= SQL BASE =================
            $sql = "
                SELECT
                    p.*,
                    c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c
                    ON p.categoria_id = c.id
                WHERE 1 = 1
            ";

            // ================= BÚSQUEDA =================
            if(!empty($buscar))
            {
                $sql .= "
                    AND (
                        p.nombre LIKE :buscar
                        OR p.descripcion LIKE :buscar
                    )
                ";
            }

            // ================= CATEGORÍA ================
            if(!empty($categoria))
            {
                $sql .= "
                    AND p.categoria_id = :categoria
                ";
            }

            // ================= ORDEN ====================
            switch($orden)
            {
                case 'precio_asc':

                    $sql .= "
                        ORDER BY p.precio ASC
                    ";

                    break;

                case 'precio_desc':

                    $sql .= "
                        ORDER BY p.precio DESC
                    ";

                    break;

                default:

                    $sql .= "
                        ORDER BY p.id DESC
                    ";

                    break;
            }

            // ================= PAGINACIÓN ===============
            $sql .= "
                LIMIT :limite
                OFFSET :offset
            ";

            // ================= PREPARAR =================
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ====================
            if(!empty($buscar))
            {
                $buscarLike =
                    "%{$buscar}%";

                $stmt->bindParam(
                    ':buscar',
                    $buscarLike,
                    PDO::PARAM_STR
                );
            }

            if(!empty($categoria))
            {
                $stmt->bindParam(
                    ':categoria',
                    $categoria,
                    PDO::PARAM_INT
                );
            }

            $stmt->bindParam(
                ':limite',
                $limite,
                PDO::PARAM_INT
            );

            $stmt->bindParam(
                ':offset',
                $offset,
                PDO::PARAM_INT
            );

            // ================= EJECUTAR =================
            $stmt->execute();

            // ================= RETORNO ==================
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerColeccion(): ' .
                $e->getMessage()
            );

            return [];
        }
    }

    // ================= CONTAR PRODUCTOS =================
    public function contarProductos(
        $buscar = '',
        $categoria = null
    )
    {
        try
        {
            // ================= SQL ======================
            $sql = "
                SELECT COUNT(*) AS total
                FROM productos p
                WHERE 1 = 1
            ";

            // ================= BÚSQUEDA =================
            if(!empty($buscar))
            {
                $sql .= "
                    AND (
                        p.nombre LIKE :buscar
                        OR p.descripcion LIKE :buscar
                    )
                ";
            }

            // ================= CATEGORÍA ================
            if(!empty($categoria))
            {
                $sql .= "
                    AND p.categoria_id = :categoria
                ";
            }

            // ================= PREPARAR =================
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ====================
            if(!empty($buscar))
            {
                $buscarLike =
                    "%{$buscar}%";

                $stmt->bindParam(
                    ':buscar',
                    $buscarLike,
                    PDO::PARAM_STR
                );
            }

            if(!empty($categoria))
            {
                $stmt->bindParam(
                    ':categoria',
                    $categoria,
                    PDO::PARAM_INT
                );
            }

            // ================= EJECUTAR =================
            $stmt->execute();

            // ================= RESULTADO ================
            $resultado =
                $stmt->fetch(PDO::FETCH_ASSOC);

            return (int)
                $resultado['total'];
        }
        catch(PDOException $e)
        {
            error_log(
                'Error contarProductos(): ' .
                $e->getMessage()
            );

            return 0;
        }
    }

    // ================= DESTACADOS =================
    public function obtenerDestacados(
        $limite = 4
    )
    {
        try
        {
            // ================= SQL =================
            $sql = "
                SELECT
                    p.*,
                    c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c
                    ON p.categoria_id = c.id
                WHERE p.destacado = 1
                ORDER BY p.id DESC
                LIMIT :limite
            ";

            // ================= PREPARAR ============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND ================
            $stmt->bindParam(
                ':limite',
                $limite,
                PDO::PARAM_INT
            );

            // ================= EJECUTAR ============
            $stmt->execute();

            // ================= RETORNO =============
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerDestacados(): ' .
                $e->getMessage()
            );

            return [];
        }
    }
}