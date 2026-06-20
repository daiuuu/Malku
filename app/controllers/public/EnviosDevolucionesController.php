<?php

require_once __DIR__ . '/../../repositories/ConfiguracionRepository.php';
require_once __DIR__ . '/../../repositories/PreguntaFrecuenteRepository.php';

class EnviosDevolucionesController {
    public function index() {
        $titulo  = 'Envíos y Devoluciones | Malku';
        $css     = 'public/envios_devoluciones.css';
        $cfgRepo = new ConfiguracionRepository();
        $cfg     = $cfgRepo->obtenerGrupo('envios');

        $faqRepo   = new PreguntaFrecuenteRepository();
        $preguntas = $faqRepo->obtenerActivas();

        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/public/envios/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}
