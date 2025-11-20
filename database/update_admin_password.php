<?php
/**
 * Script para actualizar la contraseña del usuario admin
 * Este script actualiza la contraseña del admin a "admin123"
 */

// Cargar configuración
require_once __DIR__ . '/../app/config/config.php';

// Configuración de base de datos
$host = DB_HOST;
$port = DB_PORT;
$dbname = DB_NAME;
$username = DB_USER;
$password = DB_PASS;

try {
    // Conectar a la base de datos
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "✓ Conexión exitosa a la base de datos\n";

    // Generar hash para la contraseña "admin123"
    $newPasswordHash = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);

    // Actualizar la contraseña del usuario admin
    $stmt = $pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE username = 'admin'");
    $stmt->execute(['password_hash' => $newPasswordHash]);

    echo "✓ Contraseña actualizada exitosamente\n";
    echo "  Usuario: admin\n";
    echo "  Contraseña: admin123\n";
    echo "\nPuedes iniciar sesión ahora con estas credenciales.\n";

} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
