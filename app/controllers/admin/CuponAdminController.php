<?php

require_once __DIR__ . '/../../repositories/CuponRepository.php';
require_once __DIR__ . '/../../repositories/UsuarioRepository.php';

class CuponAdminController
{
    private $repo;
    private $usuarioRepo;

    public function __construct()
    {
        $this->repo        = new CuponRepository();
        $this->usuarioRepo = new UsuarioRepository();
    }

    // ================= LISTADO =================
    public function index()
    {
        $cupones = $this->repo->obtenerTodos();

        $flash_ok    = $_SESSION['admin_ok']    ?? null;
        $flash_error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_ok'], $_SESSION['admin_error']);

        $titulo = 'Cupones | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/cupones/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= CREAR (GET form) =================
    public function crear()
    {
        $usuarioId = (int)($_GET['usuario_id'] ?? 0);
        $origenPre = $_GET['origen'] ?? 'manual';
        $usuario   = $usuarioId ? $this->usuarioRepo->obtenerPorId($usuarioId) : null;

        // Suggest a unique code
        $codigoSugerido = $this->generarCodigo($origenPre, $usuarioId);

        $titulo = 'Nuevo cupón | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/cupones/form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GUARDAR (POST) =================
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        $tipos    = ['porcentaje', 'monto_fijo'];
        $origenes = ['manual', 'regalo_membresia', 'giftcard'];
        $codigo   = trim($_POST['codigo'] ?? '');
        $tipo     = $_POST['tipo']   ?? '';
        $origen   = in_array($_POST['origen'] ?? '', $origenes) ? $_POST['origen'] : 'manual';

        if (!$codigo || !in_array($tipo, $tipos)) {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        if ($this->repo->obtenerPorCodigo($codigo)) {
            $_SESSION['admin_error'] = 'Ya existe un cupón con ese código.';
            header('Location: ' . BASE_URL . '/admin/cupones/crear');
            exit;
        }

        $this->repo->crear([
            'codigo'           => $codigo,
            'tipo'             => $tipo,
            'valor'            => (float)($_POST['valor'] ?? 0),
            'minimo_compra'    => (float)($_POST['minimo_compra'] ?? 0),
            'usos_maximos'     => $_POST['usos_maximos'] ?? '',
            'usuario_id'       => !empty($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : null,
            'activo'           => 1,
            'fecha_expiracion' => $_POST['fecha_expiracion'] ?? '',
            'origen'           => $origen,
            'nota'             => trim($_POST['nota'] ?? ''),
        ]);

        $_SESSION['admin_ok'] = 'Cupón creado correctamente.';

        $redirect = $_POST['redirect'] ?? '';
        header('Location: ' . BASE_URL . ($redirect === 'membresias' ? '/admin/membresias' : '/admin/cupones'));
        exit;
    }

    // ================= EDITAR (GET form) =================
    public function editar($id)
    {
        $cupon = $this->repo->obtenerPorId($id);
        if (!$cupon) {
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        $usuario           = null;
        $origenPre         = $cupon['origen'];
        $codigoSugerido    = $cupon['codigo'];

        $titulo = 'Editar cupón | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/cupones/form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= ACTUALIZAR (POST) =================
    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        $id     = (int)($_POST['id'] ?? 0);
        $tipos  = ['porcentaje', 'monto_fijo'];
        $tipo   = $_POST['tipo']   ?? '';
        $codigo = trim($_POST['codigo'] ?? '');

        if (!$id || !$codigo || !in_array($tipo, $tipos)) {
            $_SESSION['admin_error'] = 'Datos inválidos.';
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        $this->repo->actualizar($id, [
            'codigo'           => $codigo,
            'tipo'             => $tipo,
            'valor'            => (float)($_POST['valor'] ?? 0),
            'minimo_compra'    => (float)($_POST['minimo_compra'] ?? 0),
            'usos_maximos'     => $_POST['usos_maximos'] ?? '',
            'activo'           => isset($_POST['activo']) ? 1 : 0,
            'fecha_expiracion' => $_POST['fecha_expiracion'] ?? '',
            'nota'             => trim($_POST['nota'] ?? ''),
        ]);

        $_SESSION['admin_ok'] = 'Cupón actualizado.';
        header('Location: ' . BASE_URL . '/admin/cupones');
        exit;
    }

    // ================= ELIMINAR (POST) =================
    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/cupones');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            $this->repo->eliminar($id);
            $_SESSION['admin_ok'] = 'Cupón eliminado.';
        }

        header('Location: ' . BASE_URL . '/admin/cupones');
        exit;
    }

    // ================= REGALAR — desde panel membresías =================
    public function regalar($usuarioId)
    {
        $usuario = $this->usuarioRepo->obtenerPorId($usuarioId);
        if (!$usuario || $usuario['rol'] === 'admin') {
            header('Location: ' . BASE_URL . '/admin/membresias');
            exit;
        }

        $origenPre      = $_GET['tipo'] === 'giftcard' ? 'giftcard' : 'regalo_membresia';
        $codigoSugerido = $this->generarCodigo($origenPre, $usuarioId);

        $titulo = ($origenPre === 'giftcard' ? 'Gift card' : 'Regalar cupón') . ' | Admin Malku';
        $css    = 'admin/admin.css?v=2';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/admin/cupones/form.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ── Genera un código único sugerido ──────────────────────────────────
    private function generarCodigo($origen, $uid = 0)
    {
        $prefix = match($origen) {
            'giftcard'          => 'GIFT',
            'regalo_membresia'  => 'MALKU',
            default             => 'PROMO',
        };
        $suffix = strtoupper(substr(md5(uniqid($uid . time(), true)), 0, 6));
        return $prefix . '-' . $suffix;
    }
}
