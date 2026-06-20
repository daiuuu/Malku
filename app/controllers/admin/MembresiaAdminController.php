<?php

require_once __DIR__ . '/../../repositories/MembresiaRepository.php';
require_once __DIR__ . '/../../repositories/UsuarioRepository.php';

class MembresiaAdminController
{
    private $repo;
    private $usuarioRepo;

    private const TIPO_LABELS = [
        'basica'    => ['label' => 'Bronce', 'key' => 'bronce'],
        'premium'   => ['label' => 'Plata',  'key' => 'plata'],
        'exclusive' => ['label' => 'Oro',    'key' => 'oro'],
    ];

    public function __construct()
    {
        $this->repo        = new MembresiaRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    private function tierDesdeGasto($total)
    {
        if ($total >= 500000) return ['label' => 'Oro',    'key' => 'oro'];
        if ($total >= 200000) return ['label' => 'Plata',  'key' => 'plata'];
        return                        ['label' => 'Bronce', 'key' => 'bronce'];
    }

    // ================= LISTADO =================
    public function index()
    {
        $usuarios = $this->repo->obtenerTodosConUsuarios();

        foreach ($usuarios as &$u) {
            $u['tier_auto']   = $this->tierDesdeGasto((float)$u['total_gastado']);
            $u['tier_manual'] = !empty($u['membresia_tipo'])
                ? (self::TIPO_LABELS[$u['membresia_tipo']] ?? ['label' => ucfirst($u['membresia_tipo']), 'key' => ''])
                : null;
        }
        unset($u);

        $flash_ok    = $_SESSION['admin_ok']    ?? null;
        $flash_error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_ok'], $_SESSION['admin_error']);

        $titulo = 'Membresías | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/membresias/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= FORMULARIO ASIGNAR =================
    public function asignar($usuarioId)
    {
        $usuario = $this->usuarioRepo->obtenerPorId($usuarioId);
        if (!$usuario || $usuario['rol'] === 'admin') {
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $membresia = $this->repo->obtenerPorUsuario($usuarioId);

        $titulo = ($membresia ? 'Editar' : 'Asignar') . ' Membresía | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/membresias/asignar.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GUARDAR =================
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $tipos   = ['basica', 'premium', 'exclusive'];
        $estados = ['activa', 'vencida', 'cancelada'];

        $datos = [
            'usuario_id'           => (int)($_POST['usuario_id']    ?? 0),
            'tipo'                 => $_POST['tipo']                 ?? 'basica',
            'fecha_inicio'         => $_POST['fecha_inicio']         ?? date('Y-m-d'),
            'fecha_expiracion'     => $_POST['fecha_expiracion']     ?? date('Y-m-d', strtotime('+1 year')),
            'estado'               => $_POST['estado']               ?? 'activa',
            'renovacion_automatica'=> isset($_POST['renovacion_automatica']) ? 1 : 0,
        ];

        if (!$datos['usuario_id'] || !in_array($datos['tipo'], $tipos) || !in_array($datos['estado'], $estados)) {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $this->repo->crearOActualizar($datos);
        $_SESSION['admin_ok'] = 'Membresía guardada correctamente.';
        header('Location: ' . BASE_URL . '/admin/membresias');
        exit;
    }

    // ================= ELIMINAR =================
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->eliminar($id);
            $_SESSION['admin_ok'] = 'Membresía eliminada.';
        }

        header('Location: ' . BASE_URL . '/admin/membresias');
        exit;
    }

    // ================= CAMBIAR ESTADO =================
    public function cambiarEstado()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $id     = (int)($_POST['id']     ?? 0);
        $estado = $_POST['estado']       ?? '';

        if ($id && in_array($estado, ['activa', 'vencida', 'cancelada'])) {
            $this->repo->cambiarEstado($id, $estado);
            $_SESSION['admin_ok'] = 'Estado actualizado.';
        }

        header('Location: ' . BASE_URL . '/admin/membresias');
        exit;
    }

    // ================= BENEFICIOS — LISTADO =================
    public function beneficios()
    {
        $beneficios = $this->repo->obtenerBeneficios();

        $porTier = ['bronce' => [], 'plata' => [], 'oro' => []];
        foreach ($beneficios as $b) {
            $porTier[$b['tier']][] = $b;
        }

        $flash_ok    = $_SESSION['admin_ok']    ?? null;
        $flash_error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_ok'], $_SESSION['admin_error']);

        $titulo = 'Beneficios de membresía | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/membresias/beneficios.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= BENEFICIOS — CREAR (GET form) =================
    public function beneficioCrear()
    {
        $tierPre = $_GET['tier'] ?? 'bronce';
        $titulo  = 'Nuevo beneficio | Admin Malku';
        $css     = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/membresias/beneficio_form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= BENEFICIOS — GUARDAR (POST) =================
    public function beneficioGuardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $tiers  = ['bronce', 'plata', 'oro'];
        $tier   = $_POST['tier']   ?? '';
        $titulo = trim($_POST['titulo'] ?? '');

        if (!in_array($tier, $tiers) || $titulo === '') {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $this->repo->crearBeneficio([
            'tier'        => $tier,
            'titulo'      => $titulo,
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'icono'       => trim($_POST['icono'] ?? '✦') ?: '✦',
            'orden'       => (int)($_POST['orden'] ?? 0),
        ]);

        $_SESSION['admin_ok'] = 'Beneficio creado correctamente.';
        header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
        exit;
    }

    // ================= BENEFICIOS — EDITAR (GET form) =================
    public function beneficioEditar($id)
    {
        $beneficio = $this->repo->obtenerBeneficioPorId($id);
        if (!$beneficio) {
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $titulo = 'Editar beneficio | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/membresias/beneficio_form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= BENEFICIOS — ACTUALIZAR (POST) =================
    public function beneficioActualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $id     = (int)($_POST['id'] ?? 0);
        $tiers  = ['bronce', 'plata', 'oro'];
        $tier   = $_POST['tier']   ?? '';
        $tituloCampo = trim($_POST['titulo'] ?? '');

        if (!$id || !in_array($tier, $tiers) || $tituloCampo === '') {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $this->repo->actualizarBeneficio($id, [
            'tier'        => $tier,
            'titulo'      => $tituloCampo,
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'icono'       => trim($_POST['icono'] ?? '✦') ?: '✦',
            'orden'       => (int)($_POST['orden'] ?? 0),
        ]);

        $_SESSION['admin_ok'] = 'Beneficio actualizado.';
        header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
        exit;
    }

    // ================= BENEFICIOS — ELIMINAR (POST) =================
    public function beneficioEliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->eliminarBeneficio($id);
            $_SESSION['admin_ok'] = 'Beneficio eliminado.';
        }

        header('Location: ' . BASE_URL . '/admin/membresias/beneficios');
        exit;
    }
}
