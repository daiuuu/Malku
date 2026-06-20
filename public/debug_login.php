<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

echo '<pre style="font-family:monospace; font-size:14px; padding:20px;">';

// 1. Conexión a la base de datos
echo "=== CONEXIÓN ===\n";
try {
    $db = new Database();
    $conn = $db->conectar();
    echo "✓ Conexión OK\n\n";
} catch (Exception $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "\n";
    exit;
}

// 2. Buscar usuarios en la tabla
echo "=== USUARIOS EN LA DB ===\n";
try {
    $stmt = $conn->query("SELECT id, nombre, email, rol, estado, LEFT(password, 20) AS pass_preview FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($usuarios)) {
        echo "✗ La tabla usuarios está VACÍA — importá el malku.sql en phpMyAdmin\n\n";
    } else {
        foreach ($usuarios as $u) {
            echo "  ID: {$u['id']} | {$u['email']} | rol: '{$u['rol']}' | estado: '{$u['estado']}' | hash: {$u['pass_preview']}...\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

// 3. Test de password_verify con el hash del admin
echo "=== TEST password_verify ===\n";
$stmt = $conn->prepare("SELECT password FROM usuarios WHERE email = 'daianasoriapiola@gmail.com' LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "✗ Usuario admin no encontrado\n\n";
} else {
    $hash = $row['password'];
    echo "Hash en DB: " . $hash . "\n";
    echo "Largo del hash: " . strlen($hash) . " chars\n\n";

    $passwords_a_probar = ['password', '123456', 'admin123', 'malku', 'Malku123', '123456789'];
    foreach ($passwords_a_probar as $p) {
        $ok = password_verify($p, $hash);
        echo ($ok ? "✓" : "✗") . " password_verify('$p', hash) = " . ($ok ? "TRUE" : "false") . "\n";
    }
    echo "\nSi ninguna coincide, el hash en la DB no corresponde a ninguna contraseña conocida.\n";
    echo "Ejecutá esto en phpMyAdmin para setear la contraseña 'malku1234':\n\n";
    $nuevoHash = password_hash('malku1234', PASSWORD_DEFAULT);
    echo "UPDATE usuarios SET password = '$nuevoHash' WHERE email = 'daianasoriapiola@gmail.com';\n";
}

echo '</pre>';
