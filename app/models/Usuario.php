<?php

require_once __DIR__ . '/../../config/database.php';

class Usuario
{
    private $conexion;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion =
            $database->conectar();
    }

    // ================= CREAR USUARIO ==============
    public function crearUsuario(
        $nombre,
        $email,
        $password,
        $newsletter
    )
    {
        try
        {
            // ================= HASH =================
            $passwordHash =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

            // ================= SQL ==================
            $sql = "
                INSERT INTO usuarios
                (
                    nombre,
                    email,
                    password,
                    newsletter,
                    rol
                )
                VALUES
                (
                    :nombre,
                    :email,
                    :password,
                    :newsletter,
                    'usuario'
                )
            ";

            // ================= PREPARE ==============
            $stmt =
                $this->conexion->prepare($sql);

            // ================= BINDS ================
            $stmt->bindParam(
                ':nombre',
                $nombre,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':email',
                $email,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':password',
                $passwordHash,
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':newsletter',
                $newsletter,
                PDO::PARAM_INT
            );

            // ================= EXECUTE ==============
            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error crearUsuario(): ' .
                $e->getMessage()
            );

            return false;
        }
    }

    // ================= BUSCAR EMAIL ==============
    public function obtenerUsuarioPorEmail(
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
                'Error obtenerUsuarioPorEmail(): ' .
                $e->getMessage()
            );

            return false;
        }
    }
}