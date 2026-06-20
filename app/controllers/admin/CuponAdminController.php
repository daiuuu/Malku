<?php

class CuponAdminController
{
    public function index()
    {
        $css    = 'admin/admin.css?v=2';
        $titulo = 'Cupones | Admin Malku';
        require_once __DIR__ . '/../../views/admin/cupones/index.php';
    }
}
