<?php

class CuponAdminController
{
    public function index()
    {
        $titulo = 'Cupones | Admin Malku';
        require_once __DIR__ . '/../../views/admin/cupones/index.php';
    }
}
