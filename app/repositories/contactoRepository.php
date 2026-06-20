<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Contacto.php';

class ContactoRepository
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Database())->conectar();
    }

    public function guardar(Contacto $contacto)
    {
        try {
            $stmt = $this->conexion->prepare("
                INSERT INTO contacto (nombre, email, asunto, mensaje)
                VALUES (:nombre, :email, :asunto, :mensaje)
            ");
            return $stmt->execute([
                ':nombre'  => $contacto->getNombre(),
                ':email'   => $contacto->getEmail(),
                ':asunto'  => $contacto->getAsunto(),
                ':mensaje' => $contacto->getMensaje()
            ]);
        } catch (PDOException $e) {
            error_log('Error ContactoRepository::guardar(): ' . $e->getMessage());
            return false;
        }
    }

    public function obtenerTodos()
    {
        return $this->conexion->query(
            "SELECT * FROM contacto ORDER BY fecha_envio DESC"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPendientes()
    {
        return (int)$this->conexion->query(
            "SELECT COUNT(*) FROM contacto WHERE estado = 'pendiente'"
        )->fetchColumn();
    }

    public function cambiarEstado($id, $estado)
    {
        $stmt = $this->conexion->prepare("UPDATE contacto SET estado = :estado WHERE id = :id");
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }
}
