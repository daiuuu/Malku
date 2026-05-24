<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Contacto.php';

class ContactoRepository
{
    private $conexion;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $database = new Database();

        $this->conexion = $database->conectar();
    }

    // ================= GUARDAR =================
    public function guardar(Contacto $contacto)
    {
        try
        {
            $sql = "
                INSERT INTO contacto
                (
                    nombre,
                    email,
                    asunto,
                    mensaje
                )
                VALUES
                (
                    :nombre,
                    :email,
                    :asunto,
                    :mensaje
                )
            ";

            $stmt = $this->conexion->prepare($sql);

            $stmt->bindParam(
                ':nombre',
                $contacto->getNombre(),
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':email',
                $contacto->getEmail(),
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':asunto',
                $contacto->getAsunto(),
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                ':mensaje',
                $contacto->getMensaje(),
                PDO::PARAM_STR
            );

            return $stmt->execute();
        }
        catch(PDOException $e)
        {
            error_log(
                'Error ContactoRepository: ' .
                $e->getMessage()
            );

            return false;
        }
    }
}