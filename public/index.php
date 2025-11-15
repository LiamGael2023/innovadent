<?php
/**
 * INNOVADENT - Sistema de Gestión Dental
 * Punto de entrada principal
 */

// Iniciar sesión
session_start();

// Cargar configuración
require_once '../app/config/config.php';

// Autoloader de clases
spl_autoload_register(function ($className) {
    $paths = [
        APP_PATH . '/core/',
        APP_PATH . '/models/',
        APP_PATH . '/controllers/',
        APP_PATH . '/helpers/',
        APP_PATH . '/middleware/'
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Inicializar el router
$router = new Router();
