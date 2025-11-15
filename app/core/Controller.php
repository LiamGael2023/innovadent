<?php
/**
 * Clase Controller - Clase base para todos los controladores
 */
class Controller {
    /**
     * Cargar un modelo
     */
    protected function model($model) {
        $modelPath = APP_PATH . '/models/' . $model . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        }

        die("El modelo {$model} no existe.");
    }

    /**
     * Cargar una vista
     */
    protected function view($view, $data = []) {
        extract($data);

        $viewPath = APP_PATH . '/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("La vista {$view} no existe.");
        }
    }

    /**
     * Redireccionar a una URL
     */
    protected function redirect($url, $statusCode = 302) {
        header("Location: " . APP_URL . '/' . ltrim($url, '/'), true, $statusCode);
        exit;
    }

    /**
     * Retornar JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Obtener datos POST
     */
    protected function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }

        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }

    /**
     * Obtener datos GET
     */
    protected function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }

        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }

    /**
     * Sanitizar datos
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }

        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validar datos
     */
    protected function validate($data, $rules) {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $rulesArray = explode('|', $fieldRules);

            foreach ($rulesArray as $rule) {
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleValue = $ruleParts[1] ?? null;

                switch ($ruleName) {
                    case 'required':
                        if (empty($value)) {
                            $errors[$field][] = "El campo {$field} es requerido.";
                        }
                        break;

                    case 'email':
                        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "El campo {$field} debe ser un email válido.";
                        }
                        break;

                    case 'min':
                        if (!empty($value) && strlen($value) < $ruleValue) {
                            $errors[$field][] = "El campo {$field} debe tener al menos {$ruleValue} caracteres.";
                        }
                        break;

                    case 'max':
                        if (!empty($value) && strlen($value) > $ruleValue) {
                            $errors[$field][] = "El campo {$field} no debe exceder {$ruleValue} caracteres.";
                        }
                        break;

                    case 'numeric':
                        if (!empty($value) && !is_numeric($value)) {
                            $errors[$field][] = "El campo {$field} debe ser numérico.";
                        }
                        break;

                    case 'date':
                        if (!empty($value) && !strtotime($value)) {
                            $errors[$field][] = "El campo {$field} debe ser una fecha válida.";
                        }
                        break;
                }
            }
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Establecer mensaje flash
     */
    protected function flash($key, $message, $type = 'info') {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['flash'][$key] = [
            'message' => $message,
            'type' => $type
        ];
    }

    /**
     * Obtener mensaje flash
     */
    protected function getFlash($key) {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['flash'][$key])) {
            $flash = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $flash;
        }

        return null;
    }

    /**
     * Verificar si el usuario está autenticado
     */
    protected function isAuthenticated() {
        if (!isset($_SESSION)) {
            session_start();
        }

        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Obtener usuario autenticado
     */
    protected function auth() {
        if (!isset($_SESSION)) {
            session_start();
        }

        return $_SESSION['user'] ?? null;
    }

    /**
     * Requiere autenticación
     */
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->flash('error', 'Debe iniciar sesión para acceder a esta página.', 'warning');
            $this->redirect('/auth/login');
        }
    }

    /**
     * Subir archivo
     */
    protected function uploadFile($file, $destination, $allowedTypes = null) {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Error al subir el archivo.'];
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'error' => 'El archivo excede el tamaño máximo permitido.'];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($allowedTypes && !in_array($extension, $allowedTypes)) {
            return ['success' => false, 'error' => 'Tipo de archivo no permitido.'];
        }

        $filename = uniqid() . '_' . time() . '.' . $extension;
        $uploadPath = $destination . '/' . $filename;

        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $filename, 'path' => $uploadPath];
        }

        return ['success' => false, 'error' => 'Error al mover el archivo.'];
    }
}
