<?php
/**
 * Clase Api - Controlador base para API REST
 */
class Api {
    protected $method;
    protected $endpoint;
    protected $verb;
    protected $args = [];

    /**
     * Constructor
     */
    public function __construct() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        $this->method = $_SERVER['REQUEST_METHOD'];

        // Handle OPTIONS request for CORS
        if ($this->method == 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * Procesar request
     */
    protected function processRequest() {
        switch ($this->method) {
            case 'GET':
                return $this->get();
            case 'POST':
                return $this->post();
            case 'PUT':
                return $this->put();
            case 'DELETE':
                return $this->delete();
            default:
                return $this->response(['error' => 'Método no permitido'], 405);
        }
    }

    /**
     * Enviar respuesta JSON
     */
    protected function response($data, $status = 200) {
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Obtener datos POST/PUT
     */
    protected function getRequestData() {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

    /**
     * Validar token de autenticación
     */
    protected function authenticate() {
        $headers = getallheaders();
        $token = null;

        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }

        if (!$token) {
            $this->response(['error' => 'No autorizado', 'message' => 'Token no proporcionado'], 401);
        }

        // Validar token (implementar según tu lógica)
        $user = $this->validateToken($token);

        if (!$user) {
            $this->response(['error' => 'No autorizado', 'message' => 'Token inválido'], 401);
        }

        return $user;
    }

    /**
     * Validar token JWT (básico)
     */
    private function validateToken($token) {
        // Implementación básica - mejorar con JWT library
        session_start();

        // Por ahora, validar si el token existe en sesión
        if (isset($_SESSION['api_token']) && $_SESSION['api_token'] === $token) {
            return $_SESSION['user'] ?? null;
        }

        return null;
    }

    /**
     * Generar token de API
     */
    protected function generateToken($userId) {
        return hash('sha256', $userId . time() . ENCRYPTION_KEY);
    }

    /**
     * Paginación
     */
    protected function paginate($total, $page, $perPage) {
        return [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => ($page - 1) * $perPage + 1,
            'to' => min($page * $perPage, $total)
        ];
    }

    /**
     * Métodos a implementar en clases hijas
     */
    protected function get() {
        return $this->response(['error' => 'Método GET no implementado'], 501);
    }

    protected function post() {
        return $this->response(['error' => 'Método POST no implementado'], 501);
    }

    protected function put() {
        return $this->response(['error' => 'Método PUT no implementado'], 501);
    }

    protected function delete() {
        return $this->response(['error' => 'Método DELETE no implementado'], 501);
    }
}
