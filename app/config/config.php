<?php
/**
 * INNOVADENT - Sistema de Gestión Dental
 * Archivo de Configuración Principal
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'innovadent');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'INNOVADENT');
define('APP_VERSION', '2.0.0');
define('APP_URL', 'http://innovadent.local');
define('APP_ENV', 'development'); // development, production

// Configuración de rutas
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// Configuración de sesiones
define('SESSION_LIFETIME', 7200); // 2 horas en segundos
define('SESSION_PATH', STORAGE_PATH . '/sessions');

// Configuración de seguridad
define('HASH_ALGO', 'bcrypt');
define('HASH_COST', 12);
define('ENCRYPTION_KEY', 'your-secret-encryption-key-change-this');

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');

// Configuración regional
define('DEFAULT_LANGUAGE', 'es');
define('DEFAULT_CURRENCY', 'MXN');

// Configuración de paginación
define('ITEMS_PER_PAGE', 20);

// Configuración de logs
define('LOG_PATH', STORAGE_PATH . '/logs');
define('LOG_LEVEL', 'debug'); // debug, info, warning, error

// Configuración de email
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your-email@gmail.com');
define('MAIL_PASSWORD', 'your-password');
define('MAIL_FROM_EMAIL', 'noreply@innovadent.com');
define('MAIL_FROM_NAME', 'INNOVADENT');

// Configuración de archivos permitidos
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);
define('MAX_FILE_SIZE', 10485760); // 10MB en bytes

// Modo de depuración
define('DEBUG_MODE', APP_ENV === 'development');

// Mostrar errores en modo desarrollo
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
