<?php

require_once __DIR__ . '/../../repositories/ConfiguracionRepository.php';

class ConfiguracionAdminController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ConfiguracionRepository();
    }

    public function contacto()
    {
        $config = $this->repo->obtenerGrupo('contacto');
        $css    = 'admin/admin.css?v=2';
        $titulo = 'Datos de Contacto | Admin Malku';
        require_once __DIR__ . '/../../views/admin/configuracion/contacto.php';
    }

    public function guardarContacto()
    {
        $campos = [
            'contacto_email', 'contacto_telefono', 'contacto_telefono_wa',
            'contacto_direccion', 'contacto_ciudad', 'contacto_horario',
            'contacto_instagram', 'contacto_facebook',
        ];
        $datos = [];
        foreach ($campos as $campo) {
            $datos[$campo] = trim($_POST[$campo] ?? '');
        }
        $this->repo->guardarGrupo('contacto', $datos);
        $_SESSION['admin_ok'] = 'Datos de contacto actualizados.';
        header('Location: ' . BASE_URL . '/admin/configuracion/contacto');
        exit;
    }

    public function envios()
    {
        $config = $this->repo->obtenerGrupo('envios');
        $css    = 'admin/admin.css?v=2';
        $titulo = 'Envíos y Devoluciones | Admin Malku';
        require_once __DIR__ . '/../../views/admin/configuracion/envios.php';
    }

    public function guardarEnvios()
    {
        $campos = [
            'envios_ba_precio', 'envios_ba_desc',
            'envios_nacional_precio', 'envios_nacional_desc',
            'envios_compromiso', 'dev_intro',
            'dev_ventana_dias', 'dev_ventana_desc',
            'dev_reembolso_desc', 'dev_cambios_desc', 'dev_atencion_desc',
        ];
        $datos = [];
        foreach ($campos as $campo) {
            $datos[$campo] = trim($_POST[$campo] ?? '');
        }
        $this->repo->guardarGrupo('envios', $datos);
        $_SESSION['admin_ok'] = 'Políticas de envíos y devoluciones actualizadas.';
        header('Location: ' . BASE_URL . '/admin/configuracion/envios');
        exit;
    }
}
