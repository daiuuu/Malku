<?php

class NosotrosController
{
    public function index()
    {
        // ================= TÍTULO DINÁMICO =================
        $titulo = "Malku - Nosotros";

        // ================= CSS ESPECÍFICO =================
        $css = "public/nosotros.css";

        // ================= CARGAR VISTA =================
        require_once __DIR__ . '/../../views/public/nosotros/index.php';
    }
}