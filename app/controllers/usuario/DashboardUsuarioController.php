<?php

require_once __DIR__ .
    '/../../middleware/AuthMiddleware.php';

require_once __DIR__ .
    '/../../models/Pedido.php';

class DashboardUsuarioController
{
    private $pedidoModel;

    // ================= CONSTRUCTOR =================
    public function __construct()
    {
        $this->pedidoModel =
            new Pedido();
    }

    // ================= INDEX =================
    public function index()
    {
        // ================= VERIFICAR SESIÓN =================
        AuthMiddleware::verificar();

        // ================= DATOS USUARIO =================
        $usuario =
            $_SESSION['usuario'];

        $usuarioId =
            $usuario['id'];

        // ================= ÚLTIMO PEDIDO =================
        $ultimoPedido =
            $this->pedidoModel
                ->obtenerUltimoPorUsuario(
                    $usuarioId
                );

        // ================= ESTADÍSTICAS =================
        $totalPedidos =
            $this->pedidoModel
                ->contarPorUsuario(
                    $usuarioId
                );

        $totalFavoritos = 0;

        $totalDirecciones = 0;

        $totalProductosComprados = 0;

        // ================= METADATA =================
        $titulo =
            'Mi cuenta | Malku';

        $css =
            'usuario/dashboard.css';

        // ================= VISTA =================
        require_once __DIR__ .
            '/../../views/usuario/dashboard/index.php';
    }
}
