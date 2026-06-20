<?php

require_once __DIR__ . '/../../repositories/PedidoRepository.php';
require_once __DIR__ . '/../../repositories/ProductoRepository.php';
require_once __DIR__ . '/../../repositories/UsuarioRepository.php';
require_once __DIR__ . '/../../repositories/ContactoRepository.php';

class DashboardAdminController
{
    public function index()
    {
        $pedidoRepo   = new PedidoRepository();
        $productoRepo = new ProductoRepository();
        $usuarioRepo  = new UsuarioRepository();
        $contactoRepo = new ContactoRepository();

        $pedidosHoy         = $pedidoRepo->contarHoy();
        $ventasMes          = $pedidoRepo->totalMes();
        $ventasMesAnterior  = $pedidoRepo->totalMesAnterior();
        $productosActivos   = $productoRepo->contar();
        $mensajesPendientes = $contactoRepo->contarPendientes();
        $ultimosPedidos     = $pedidoRepo->ultimosCinco();
        $masVendidos        = $productoRepo->masMostrados(5);

        $cambioPct = 0;
        if ($ventasMesAnterior > 0) {
            $cambioPct = round((($ventasMes - $ventasMesAnterior) / $ventasMesAnterior) * 100, 1);
        }

        try {
            $db = (new Database())->conectar();
            $totalUsuarios = (int)$db->query(
                "SELECT COUNT(*) FROM usuarios WHERE rol = 'cliente' OR rol = ''"
            )->fetchColumn();
        } catch (Exception $e) {
            $totalUsuarios = 0;
        }

        $css   = 'admin/admin.css?v=2';
        $titulo = 'Dashboard | Admin Malku';
        require_once __DIR__ . '/../../views/admin/dashboard/index.php';
    }
}
