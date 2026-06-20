<?php

require_once __DIR__ . '/../../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../../repositories/PedidoRepository.php';
require_once __DIR__ . '/../../repositories/DireccionRepository.php';
require_once __DIR__ . '/../../repositories/FavoritoRepository.php';
require_once __DIR__ . '/../../repositories/UsuarioRepository.php';
require_once __DIR__ . '/../../repositories/MembresiaRepository.php';
require_once __DIR__ . '/../../repositories/CuponRepository.php';
require_once __DIR__ . '/../../services/MercadoPagoService.php';

class DashboardUsuarioController
{
    private $pedidoRepo;
    private $direccionRepo;
    private $favoritoRepo;
    private $usuarioRepo;
    private $membresiaRepo;
    private $cuponRepo;

    public function __construct()
    {
        $this->pedidoRepo    = new PedidoRepository();
        $this->direccionRepo = new DireccionRepository();
        $this->favoritoRepo  = new FavoritoRepository();
        $this->usuarioRepo   = new UsuarioRepository();
        $this->membresiaRepo = new MembresiaRepository();
        $this->cuponRepo     = new CuponRepository();
    }

    private function verificar()
    {
        AuthMiddleware::verificar();
    }

    private function usuarioId()
    {
        return (int)$_SESSION['usuario']['id'];
    }

    // ================= DASHBOARD =================
    public function index()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario                 = $_SESSION['usuario'];
        $ultimoPedido            = $this->pedidoRepo->obtenerUltimoPorUsuario($uid);
        $totalPedidos            = $this->pedidoRepo->contarPorUsuario($uid);
        $totalFavoritos          = $this->favoritoRepo->contar($uid);
        $totalDirecciones        = $this->direccionRepo->contar($uid);
        $totalProductosComprados = $this->pedidoRepo->contarProductosCompradosPorUsuario($uid);

        $titulo = 'Mi Cuenta | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/dashboard/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= MIS PEDIDOS =================
    public function pedidos()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario = $_SESSION['usuario'];
        $pedidos = $this->pedidoRepo->obtenerPorUsuario($uid);

        $titulo = 'Mis Pedidos | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/pedidos/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= DETALLE PEDIDO =================
    public function pedidoDetalle($id)
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $pedido = $this->pedidoRepo->obtenerPorId($id);
        if (!$pedido || (int)$pedido['usuario_id'] !== $uid) {
            header('Location: ' . BASE_URL . '/usuario/pedidos');
            exit;
        }
        $detalle = $this->pedidoRepo->obtenerDetalle($id);
        $usuario = $_SESSION['usuario'];

        $titulo = 'Pedido #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/pedidos/detalle.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= MI PERFIL =================
    public function perfil()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario     = $this->usuarioRepo->obtenerPorId($uid);
        $flash_ok    = $_SESSION['perfil_ok']    ?? null;
        $flash_error = $_SESSION['perfil_error'] ?? null;
        unset($_SESSION['perfil_ok'], $_SESSION['perfil_error']);

        $titulo = 'Mi Perfil | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/perfil/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GUARDAR PERFIL =================
    public function guardarPerfil()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        $uid      = $this->usuarioId();
        $nombre   = trim($_POST['nombre']   ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $telefono = trim($_POST['telefono'] ?? '');

        if (!$nombre || !$apellido || !$email) {
            $_SESSION['perfil_error'] = 'Completá todos los campos requeridos.';
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        $ok = $this->usuarioRepo->actualizarPerfil($uid, $nombre, $apellido, $email, $telefono);
        if ($ok) {
            $_SESSION['usuario']['nombre']   = $nombre;
            $_SESSION['usuario']['apellido'] = $apellido;
            $_SESSION['usuario']['email']    = $email;
            $_SESSION['perfil_ok'] = 'Perfil actualizado correctamente.';
        } else {
            $_SESSION['perfil_error'] = 'No se pudo actualizar el perfil. Intentá de nuevo.';
        }

        header('Location: ' . BASE_URL . '/usuario/perfil');
        exit;
    }

    // ================= CAMBIAR CONTRASEÑA =================
    public function cambiarPassword()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        $uid       = $this->usuarioId();
        $actual    = $_POST['password_actual']    ?? '';
        $nueva     = $_POST['password_nueva']     ?? '';
        $confirmar = $_POST['password_confirmar'] ?? '';

        $usuario = $this->usuarioRepo->obtenerPorId($uid);

        if (!password_verify($actual, $usuario['password'])) {
            $_SESSION['perfil_error'] = 'La contraseña actual no es correcta.';
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        if (strlen($nueva) < 6) {
            $_SESSION['perfil_error'] = 'La nueva contraseña debe tener al menos 6 caracteres.';
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        if ($nueva !== $confirmar) {
            $_SESSION['perfil_error'] = 'Las contraseñas nuevas no coinciden.';
            header('Location: ' . BASE_URL . '/usuario/perfil');
            exit;
        }

        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        $ok   = $this->usuarioRepo->actualizarPassword($uid, $hash);

        $_SESSION[$ok ? 'perfil_ok' : 'perfil_error'] = $ok
            ? 'Contraseña actualizada correctamente.'
            : 'No se pudo actualizar la contraseña.';

        header('Location: ' . BASE_URL . '/usuario/perfil');
        exit;
    }

    // ================= DIRECCIONES =================
    public function direcciones()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario     = $_SESSION['usuario'];
        $direcciones = $this->direccionRepo->obtenerPorUsuario($uid);
        $flash_ok    = $_SESSION['dir_ok']    ?? null;
        $flash_error = $_SESSION['dir_error'] ?? null;
        unset($_SESSION['dir_ok'], $_SESSION['dir_error']);

        $titulo = 'Mis Direcciones | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/direcciones/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= NUEVA DIRECCIÓN (form) =================
    public function nuevaDireccion()
    {
        $this->verificar();
        $usuario = $_SESSION['usuario'];

        $titulo = 'Nueva Dirección | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/direcciones/crear.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GUARDAR DIRECCIÓN =================
    public function guardarDireccion()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/direcciones');
            exit;
        }

        $uid   = $this->usuarioId();
        $datos = [
            'usuario_id'    => $uid,
            'nombre_recibe' => trim($_POST['nombre_recibe'] ?? ''),
            'telefono'      => trim($_POST['telefono']      ?? ''),
            'calle'         => trim($_POST['calle']         ?? ''),
            'numero'        => trim($_POST['numero']        ?? ''),
            'piso'          => trim($_POST['piso']          ?? ''),
            'departamento'  => trim($_POST['departamento']  ?? ''),
            'ciudad'        => trim($_POST['ciudad']        ?? ''),
            'provincia'     => trim($_POST['provincia']     ?? ''),
            'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
            'referencia'    => trim($_POST['referencia']    ?? ''),
            'principal'     => isset($_POST['principal']) ? 1 : 0,
        ];

        if (!$datos['nombre_recibe'] || !$datos['calle'] || !$datos['ciudad'] || !$datos['provincia']) {
            $_SESSION['dir_error'] = 'Completá los campos obligatorios.';
            header('Location: ' . BASE_URL . '/usuario/direcciones/nueva');
            exit;
        }

        $this->direccionRepo->crear($datos);
        $_SESSION['dir_ok'] = 'Dirección guardada correctamente.';
        header('Location: ' . BASE_URL . '/usuario/direcciones');
        exit;
    }

    // ================= EDITAR DIRECCIÓN (form) =================
    public function editarDireccion($id)
    {
        $this->verificar();
        $uid       = $this->usuarioId();
        $usuario   = $_SESSION['usuario'];
        $direccion = $this->direccionRepo->obtenerPorId($id, $uid);

        if (!$direccion) {
            header('Location: ' . BASE_URL . '/usuario/direcciones');
            exit;
        }

        $titulo = 'Editar Dirección | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/direcciones/editar.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= ACTUALIZAR DIRECCIÓN =================
    public function actualizarDireccion()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/direcciones');
            exit;
        }

        $uid = $this->usuarioId();
        $id  = (int)($_POST['id'] ?? 0);

        $datos = [
            'nombre_recibe' => trim($_POST['nombre_recibe'] ?? ''),
            'telefono'      => trim($_POST['telefono']      ?? ''),
            'calle'         => trim($_POST['calle']         ?? ''),
            'numero'        => trim($_POST['numero']        ?? ''),
            'piso'          => trim($_POST['piso']          ?? ''),
            'departamento'  => trim($_POST['departamento']  ?? ''),
            'ciudad'        => trim($_POST['ciudad']        ?? ''),
            'provincia'     => trim($_POST['provincia']     ?? ''),
            'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
            'referencia'    => trim($_POST['referencia']    ?? ''),
            'principal'     => isset($_POST['principal']) ? 1 : 0,
        ];

        $this->direccionRepo->actualizar($id, $uid, $datos);
        $_SESSION['dir_ok'] = 'Dirección actualizada correctamente.';
        header('Location: ' . BASE_URL . '/usuario/direcciones');
        exit;
    }

    // ================= ELIMINAR DIRECCIÓN =================
    public function eliminarDireccion()
    {
        $this->verificar();
        $uid = $this->usuarioId();
        $id  = (int)($_POST['id'] ?? 0);

        $this->direccionRepo->eliminar($id, $uid);
        $_SESSION['dir_ok'] = 'Dirección eliminada.';
        header('Location: ' . BASE_URL . '/usuario/direcciones');
        exit;
    }

    // ================= MARCAR DIRECCIÓN PRINCIPAL =================
    public function marcarPrincipal()
    {
        $this->verificar();
        $uid = $this->usuarioId();
        $id  = (int)($_POST['id'] ?? 0);

        $this->direccionRepo->marcarPrincipal($id, $uid);
        $_SESSION['dir_ok'] = 'Dirección principal actualizada.';
        header('Location: ' . BASE_URL . '/usuario/direcciones');
        exit;
    }

    // ================= FAVORITOS =================
    public function favoritos()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario   = $_SESSION['usuario'];
        $favoritos = $this->favoritoRepo->obtenerPorUsuario($uid);
        $flash_ok  = $_SESSION['fav_ok'] ?? null;
        unset($_SESSION['fav_ok']);

        $titulo = 'Mis Favoritos | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/favoritos/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= TOGGLE FAVORITO =================
    public function toggleFavorito()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/favoritos');
            exit;
        }

        $uid        = $this->usuarioId();
        $productoId = (int)($_POST['producto_id'] ?? 0);

        if ($productoId) {
            if ($this->favoritoRepo->existe($uid, $productoId)) {
                $this->favoritoRepo->eliminarPorProductoId($productoId, $uid);
            } else {
                $this->favoritoRepo->agregar($uid, $productoId);
            }
        }

        $redirect = $_POST['redirect'] ?? BASE_URL . '/usuario/favoritos';
        header('Location: ' . $redirect);
        exit;
    }

    // ================= AGREGAR FAVORITO =================
    public function agregarFavorito()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/favoritos');
            exit;
        }

        $uid        = $this->usuarioId();
        $productoId = (int)($_POST['producto_id'] ?? 0);

        if ($productoId) {
            $this->favoritoRepo->agregar($uid, $productoId);
        }

        $redirect = $_POST['redirect'] ?? BASE_URL . '/usuario/favoritos';
        header('Location: ' . $redirect);
        exit;
    }

    // ================= ELIMINAR FAVORITO =================
    public function eliminarFavorito()
    {
        $this->verificar();
        $uid = $this->usuarioId();
        $id  = (int)($_POST['id'] ?? 0);

        $this->favoritoRepo->eliminar($id, $uid);
        $_SESSION['fav_ok'] = 'Eliminado de favoritos.';
        header('Location: ' . BASE_URL . '/usuario/favoritos');
        exit;
    }

    // ================= MEMBRESÍA =================
    public function membresia()
    {
        $this->verificar();
        $uid = $this->usuarioId();

        $usuario      = $_SESSION['usuario'];
        $totalGastado = 0;
        $pedidos      = $this->pedidoRepo->obtenerPorUsuario($uid);

        foreach ($pedidos as $p) {
            if (in_array($p['estado'], ['pagado', 'enviado', 'entregado'])) {
                $totalGastado += (float)$p['total'];
            }
        }

        // Membresía manual asignada por admin (tiene prioridad si está activa)
        $membresiaManual = $this->membresiaRepo->obtenerActivaPorUsuario($uid);

        if ($membresiaManual) {
            $tipoMap = [
                'basica'    => ['Bronce', 'bronce', 'Plata',  200000 - $totalGastado],
                'premium'   => ['Plata',  'plata',  'Oro',    500000 - $totalGastado],
                'exclusive' => ['Oro',    'oro',    null,     0],
            ];
            [$tier, $tierKey, $siguiente, $faltante] = $tipoMap[$membresiaManual['tipo']] ?? ['Bronce', 'bronce', 'Plata', 200000 - $totalGastado];
            $faltante = max(0, $faltante);
        } elseif ($totalGastado >= 500000) {
            $tier      = 'Oro';
            $tierKey   = 'oro';
            $siguiente = null;
            $faltante  = 0;
        } elseif ($totalGastado >= 200000) {
            $tier      = 'Plata';
            $tierKey   = 'plata';
            $siguiente = 'Oro';
            $faltante  = 500000 - $totalGastado;
        } else {
            $tier      = 'Bronce';
            $tierKey   = 'bronce';
            $siguiente = 'Plata';
            $faltante  = 200000 - $totalGastado;
        }

        // Load benefits from DB, grouped by tier
        $beneficiosTier = ['bronce' => [], 'plata' => [], 'oro' => []];
        foreach ($this->membresiaRepo->obtenerBeneficios() as $b) {
            $beneficiosTier[$b['tier']][] = $b;
        }

        $titulo = 'Membresía Malku | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/membresia/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= CUPONES =================
    public function cupones()
    {
        $this->verificar();
        $uid     = $this->usuarioId();
        $cupones = $this->cuponRepo->obtenerPorUsuario($uid);

        $titulo = 'Mis Cupones | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/cupones/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GIFT CARD — FORMULARIO =================
    public function giftcard()
    {
        $this->verificar();
        $usuario = $_SESSION['usuario'];

        $flash_ok    = $_SESSION['gc_ok']    ?? null;
        $flash_error = $_SESSION['gc_error'] ?? null;
        unset($_SESSION['gc_ok'], $_SESSION['gc_error']);

        $titulo = 'Crear Gift Card | Malku';
        $css    = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/giftcards/crear.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GIFT CARD — GENERAR =================
    public function generarGiftcard()
    {
        $this->verificar();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }

        $uid      = $this->usuarioId();
        $montoRaw = $_POST['monto'] ?? '';
        $monto    = is_numeric($montoRaw) ? (float)$montoRaw : (float)($_POST['monto_custom'] ?? 0);
        $email    = trim($_POST['email_destinatario'] ?? '');
        $nota     = trim($_POST['mensaje'] ?? '');
        $metodo   = $_POST['metodo_pago'] ?? 'mercadopago';

        if ($monto < 1000) {
            $_SESSION['gc_error'] = 'El monto mínimo para una gift card es $1.000.';
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }

        // Find recipient user (if email provided)
        $destinatarioId     = null;
        $destinatarioNombre = null;
        if ($email) {
            $destinatario = $this->usuarioRepo->buscarPorEmail($email);
            if ($destinatario && (int)$destinatario['id'] !== $uid) {
                $destinatarioId     = (int)$destinatario['id'];
                $destinatarioNombre = $destinatario['nombre'];
            }
        }

        $expiracion = date('Y-m-d', strtotime('+1 year'));
        $codigo     = $this->cuponRepo->generarCodigoUnico('GIFT');

        // Create coupon inactive — activated only after payment confirmed
        $cuponId = $this->cuponRepo->crear([
            'codigo'           => $codigo,
            'tipo'             => 'monto_fijo',
            'valor'            => $monto,
            'minimo_compra'    => 0,
            'usos_maximos'     => 1,
            'usuario_id'       => $destinatarioId,
            'activo'           => 0,
            'fecha_expiracion' => $expiracion,
            'origen'           => 'giftcard',
            'nota'             => $nota ?: 'Creada por usuario #' . $uid,
        ]);

        if (!$cuponId) {
            $_SESSION['gc_error'] = 'No se pudo generar la gift card. Intentá de nuevo.';
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }

        // ── EFECTIVO ──────────────────────────────────────────────────
        if ($metodo === 'efectivo') {
            $_SESSION['gc_pendiente'] = [
                'codigo'      => $codigo,
                'monto'       => $monto,
                'email'       => $email,
                'nombre'      => $destinatarioNombre,
                'cupon_id'    => $cuponId,
                'expiracion'  => $expiracion,
                'asignada'    => $destinatarioId !== null,
            ];
            header('Location: ' . BASE_URL . '/usuario/giftcard/pendiente');
            exit;
        }

        // ── MERCADO PAGO (tarjeta o wallet) ───────────────────────────
        try {
            $mp   = new MercadoPagoService();
            $pref = $mp->crearPreferencia([
                'id'                 => 'gift-' . $cuponId,
                'titulo'             => 'Gift Card Malku $' . number_format($monto, 0, ',', '.'),
                'monto'              => $monto,
                'url_exito'          => BASE_URL . '/usuario/giftcard/pago/exito',
                'url_error'          => BASE_URL . '/usuario/giftcard/pago/error',
                'url_pendiente'      => BASE_URL . '/usuario/giftcard/pago/error',
                'referencia_externa' => $cuponId,
            ]);

            $redirectUrl = (MP_MODO === 'produccion')
                ? $pref['init_point']
                : $pref['sandbox_init_point'];

            header('Location: ' . $redirectUrl);
            exit;

        } catch (RuntimeException $e) {
            error_log('GiftCard MP error: ' . $e->getMessage());
            $_SESSION['gc_error'] = 'No se pudo iniciar el pago con Mercado Pago. Intentá de nuevo.';
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }
    }

    // ================= GIFT CARD — PAGO EXITOSO (MP callback) =================
    public function pagoExitoGiftcard()
    {
        $this->verificar();

        $paymentId = $_GET['payment_id']         ?? '';
        $cuponId   = (int)($_GET['external_reference'] ?? 0);

        if (!$paymentId || !$cuponId) {
            header('Location: ' . BASE_URL . '/usuario/giftcard/pago/error');
            exit;
        }

        // Verify with MP API (don't trust browser params alone)
        try {
            $mp  = new MercadoPagoService();
            $ok  = $mp->verificarPagoAprobado((string)$paymentId, (string)$cuponId);
        } catch (RuntimeException $e) {
            $ok = false;
        }

        if (!$ok) {
            header('Location: ' . BASE_URL . '/usuario/giftcard/pago/error');
            exit;
        }

        // Activate the coupon
        $this->cuponRepo->activarPorId($cuponId);
        $cupon = $this->cuponRepo->obtenerPorId($cuponId);

        if (!$cupon) {
            header('Location: ' . BASE_URL . '/usuario/giftcard/pago/error');
            exit;
        }

        $_SESSION['gc_exito'] = [
            'codigo'     => $cupon['codigo'],
            'monto'      => (float)$cupon['valor'],
            'email'      => '',
            'nombre'     => null,
            'expiracion' => $cupon['fecha_expiracion'],
            'asignada'   => !empty($cupon['usuario_id']),
        ];

        header('Location: ' . BASE_URL . '/usuario/giftcard/exito');
        exit;
    }

    // ================= GIFT CARD — PAGO ERROR (MP callback) =================
    public function pagoErrorGiftcard()
    {
        $this->verificar();

        $usuario = $_SESSION['usuario'];
        $titulo  = 'Error en el pago | Malku';
        $css     = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/giftcards/pago_error.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GIFT CARD — PAGO PENDIENTE EFECTIVO =================
    public function pagoPendienteGiftcard()
    {
        $this->verificar();

        $gc = $_SESSION['gc_pendiente'] ?? null;
        if (!$gc) {
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }
        // Keep in session so page refresh doesn't break
        $usuario = $_SESSION['usuario'];
        $titulo  = 'Coordiná el pago | Malku';
        $css     = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/giftcards/pendiente.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    // ================= GIFT CARD — ÉXITO =================
    public function giftcardExito()
    {
        $this->verificar();

        $gc = $_SESSION['gc_exito'] ?? null;
        if (!$gc) {
            header('Location: ' . BASE_URL . '/usuario/giftcard/crear');
            exit;
        }
        unset($_SESSION['gc_exito']);

        $usuario = $_SESSION['usuario'];
        $titulo  = 'Gift Card Creada | Malku';
        $css     = 'usuario/usuario.css';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/usuario/giftcards/exito.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}
