<?php

class Contacto
{
    private $nombre;
    private $email;
    private $asunto;
    private $mensaje;

    // ================= CONSTRUCTOR =================
    public function __construct(
        $nombre,
        $email,
        $asunto,
        $mensaje
    )
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->asunto = $asunto;
        $this->mensaje = $mensaje;
    }

    // ================= GETTERS =================
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAsunto()
    {
        return $this->asunto;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }
}