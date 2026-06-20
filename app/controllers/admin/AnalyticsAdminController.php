<?php

require_once __DIR__ . '/../../repositories/PedidoRepository.php';
require_once __DIR__ . '/../../repositories/ProductoRepository.php';

class AnalyticsAdminController
{
    public function index()
    {
        $pedidoRepo   = new PedidoRepository();
        $productoRepo = new ProductoRepository();

        $ventasMes    = $pedidoRepo->totalMes();
        $pedidosHoy   = $pedidoRepo->contarHoy();
        $masVendidos  = $productoRepo->masMostrados(10);
        $ventasPorMes = $pedidoRepo->ventasPorMes();

        try {
            $db = (new Database())->conectar();
            $nuevosEsteMes = (int)$db->query(
                "SELECT COUNT(*) FROM usuarios WHERE MONTH(fecha_registro) = MONTH(NOW()) AND YEAR(fecha_registro) = YEAR(NOW())"
            )->fetchColumn();
            $totalUsuarios = (int)$db->query(
                "SELECT COUNT(*) FROM usuarios WHERE rol != 'admin'"
            )->fetchColumn();
            $ventasHoy = (float)$db->query(
                "SELECT COALESCE(SUM(total),0) FROM pedidos WHERE DATE(fecha_creacion) = CURDATE()"
            )->fetchColumn();
            $ventasSemana = (float)$db->query(
                "SELECT COALESCE(SUM(total),0) FROM pedidos WHERE fecha_creacion >= NOW() - INTERVAL 7 DAY"
            )->fetchColumn();
        } catch (Exception $e) {
            $nuevosEsteMes = 0;
            $totalUsuarios = 0;
            $ventasHoy     = 0;
            $ventasSemana  = 0;
        }

        $titulo = 'Analytics | Admin Malku';
        require_once __DIR__ . '/../../views/admin/analisis/index.php';
    }
}
