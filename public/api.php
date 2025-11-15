<?php
/**
 * INNOVADENT API - Punto de entrada para API REST
 * Uso: /api.php?endpoint=patients&action=list
 */

session_start();

// Cargar configuración
require_once '../app/config/config.php';

// Autoloader
spl_autoload_register(function ($className) {
    $paths = [
        APP_PATH . '/core/',
        APP_PATH . '/models/',
        APP_PATH . '/controllers/api/',
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Determinar el endpoint
$endpoint = $_GET['endpoint'] ?? 'auth';
$endpoint = ucfirst(strtolower($endpoint));

// Mapeo de endpoints a controladores
$controllers = [
    'Auth' => 'AuthApiController',
    'Patients' => 'PatientsApiController',
    'Appointments' => 'AppointmentsApiController',
];

$controllerClass = $controllers[$endpoint] ?? null;

if (!$controllerClass || !class_exists($controllerClass)) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Endpoint no encontrado',
        'endpoint' => $endpoint
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Instanciar y ejecutar el controlador
try {
    $controller = new $controllerClass();
    $controller->processRequest();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error interno del servidor',
        'message' => DEBUG_MODE ? $e->getMessage() : 'Ha ocurrido un error'
    ], JSON_UNESCAPED_UNICODE);
}
