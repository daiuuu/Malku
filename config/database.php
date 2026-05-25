<?php

class Database
{
    private $HOST = 'localhost';

    private $DB_NAME = 'malku';

    private $USER = 'root';

    private $PASSWORD = '';

    private $CHARSET = 'utf8mb4';

    private $conexion = null;

    // ================= CONECTAR =================
    public function conectar()
    {
        try {

            $DSN = "mysql:host={$this->HOST};dbname={$this->DB_NAME};charset={$this->CHARSET}";

            $this->conexion = new PDO(
                $DSN,
                $this->USER,
                $this->PASSWORD
            );

            // ================= CONFIGURACIONES PDO =================    
            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $this->conexion->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            $this->conexion->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

            return $this->conexion;

        } catch (PDOException $error) {

            die(
                'Error de conexión a la base de datos: ' .
                $error->getMessage()
            );
        }
    }
}