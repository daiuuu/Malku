<?php

require_once __DIR__ . '/../../repositories/ConfiguracionRepository.php';

class EnviosDevolucionesController {
    public function index() {
        $titulo  = 'Envíos y Devoluciones | Malku';
        $css     = 'public/envios_devoluciones.css';
        $cfgRepo = new ConfiguracionRepository();
        $cfg     = $cfgRepo->obtenerGrupo('envios');

        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/envios/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}
