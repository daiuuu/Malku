<?php

require_once __DIR__ . '/../../config/database.php';

class UsuarioRepository
{
    private $conexion;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();
    }

    // ================= BUSCAR POR EMAIL =================
    public function buscarPorEmail(
        $email
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                SELECT *
                FROM usuarios
                WHERE email = :email
                LIMIT 1
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND =================
            $stmt->bindParam(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            // ================= EXECUTE ==============
            $stmt->execute();

            // ================= RETURN ===============
            return $stmt->fetch(
                PDO::FETCH_ASSOC
            );
        }
        catch(PDOException $e)
        {
            error_log(
                'Error buscarPorEmail(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= CREAR USUARIO =================
    public function crear(
        $datos
    )
    {
        try
        {
            // ================= HASH =================
            $passwordHash =
                password_hash(
                    $datos['password'],
                    PASSWORD_DEFAULT
                );

            // ================= SQL ==================
            $sql = "
                INSERT INTO usuarios
                (
                    nombre,
                    apellido,
                    email,
                    password,
                    rol,
                    estado,
                    email_verificado
                )
                VALUES
                (
                    :nombre,
                    :apellido,
                    :email,
                    :password,
                    'cliente',
                    'activo',
                    0
                )
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ================
            $stmt->bindParam(
                ':nombre',
                $datos['nombre'],
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':apellido',
                $datos['apellido'],
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':email',
                $datos['email'],
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':password',
                $passwordHash,
                PDO::PARAM_STR
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error crear(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= ACTUALIZAR ÚLTIMO ACCESO =================
    public function actualizarUltimoAcceso(
        $id
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                UPDATE usuarios
                SET ultimo_acceso = NOW()
                WHERE id = :id
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND =================
            $stmt->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error actualizarUltimoAcceso(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= GUARDAR TOKEN RECUPERACIÓN =================
    public function guardarTokenRecuperacion(
        $email,
        $token
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                UPDATE usuarios
                SET token_recuperacion = :token
                WHERE email = :email
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ================
            $stmt->bindParam(
                ':token',
                $token,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error guardarTokenRecuperacion(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= BUSCAR POR TOKEN =================
    public function buscarPorToken(
        $token
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                SELECT *
                FROM usuarios
                WHERE token_recuperacion = :token
                LIMIT 1
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND =================
            $stmt->bindParam(
                ':token',
                $token,
                PDO::PARAM_STR
            );

            // ================= EXECUTE ==============
            $stmt->execute();

            // ================= RETURN ===============
            return $stmt->fetch(
                PDO::FETCH_ASSOC
            );
        }
        catch(PDOException $e)
        {
            error_log(
                'Error buscarPorToken(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= ACTUALIZAR CONTRASEÑA =================
    public function actualizarPassword(
        $id,
        $passwordHash
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                UPDATE usuarios
                SET
                    password   = :password,
                    updated_at = NOW()
                WHERE id = :id
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ================
            $stmt->bindParam(
                ':password',
                $passwordHash,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error actualizarPassword(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= LIMPIAR TOKEN =================
    public function limpiarTokenRecuperacion(
        $id
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                UPDATE usuarios
                SET token_recuperacion = NULL
                WHERE id = :id
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND =================
            $stmt->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error limpiarTokenRecuperacion(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= ACTUALIZAR PERFIL =================
    public function actualizarPerfil($id, $nombre, $apellido, $email, $telefono)
    {
        $stmt = $this->conexion->prepare("
            UPDATE usuarios
            SET nombre = :nombre, apellido = :apellido, email = :email,
                telefono = :telefono, updated_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':nombre'   => $nombre,
            ':apellido' => $apellido,
            ':email'    => $email,
            ':telefono' => $telefono,
            ':id'       => $id,
        ]);
    }

    // ================= OBTENER POR ID =================
    public function obtenerPorId(
        $id
    )
    {
        try
        {
            // ================= SQL ==================
            $sql = "
                SELECT *
                FROM usuarios
                WHERE id = :id
                LIMIT 1
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BIND =================
            $stmt->bindParam(
                ':id',
                $id,
                PDO::PARAM_INT
            );

            // ================= EXECUTE ==============
            $stmt->execute();

            // ================= RETURN ===============
            return $stmt->fetch(
                PDO::FETCH_ASSOC
            );
        }
        catch(PDOException $e)
        {
            error_log(
                'Error obtenerPorId(): ' .
                $e->getMessage()
            );

            return false;
        }
    }
}
