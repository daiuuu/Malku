<?php

class EnviosDevolucionesController {
    public function index() {

        // ============================= TÍTULO =============================
        $titulo = 'Envíos y Devoluciones | Malku';

        // ============================= CSS ESPECÍFICO =============================
        $css = 'public/envios_devoluciones.css';

        // ============================= HEADER =============================
        require_once __DIR__ .
            '/../../views/layouts/header.php';

        // ============================= VIEW =============================
        require_once __DIR__ .
            '/../../views/public/envios/index.php';

        // ============================= FOOTER =============================
        require_once __DIR__ .
            '/../../views/layouts/footer.php';
    }
}