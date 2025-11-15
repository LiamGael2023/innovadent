<?php
/**
 * API Controller para Autenticación
 * Endpoints: /api/auth
 */
class AuthApiController extends Api {
    private $userModel;

    public function __construct() {
        parent::__construct();
        require_once APP_PATH . '/models/User.php';
        $this->userModel = new User();
    }

    /**
     * POST /api/auth/login - Autenticar usuario y obtener token
     */
    protected function post() {
        // Determinar la acción
        $action = $_GET['action'] ?? 'login';

        if ($action === 'login') {
            return $this->login();
        } elseif ($action === 'logout') {
            return $this->logout();
        } elseif ($action === 'refresh') {
            return $this->refreshToken();
        }

        return $this->response(['error' => 'Acción no válida'], 400);
    }

    /**
     * Login
     */
    private function login() {
        $data = $this->getRequestData();

        if (empty($data['username']) || empty($data['password'])) {
            return $this->response([
                'error' => 'Credenciales incompletas',
                'message' => 'Usuario y contraseña son requeridos'
            ], 400);
        }

        // Autenticar
        $user = $this->userModel->authenticate($data['username'], $data['password']);

        if (!$user) {
            return $this->response([
                'error' => 'Credenciales inválidas',
                'message' => 'Usuario o contraseña incorrectos'
            ], 401);
        }

        // Generar token
        $token = $this->generateToken($user['id']);

        // Guardar en sesión (mejorar con Redis o base de datos)
        session_start();
        $_SESSION['api_token'] = $token;
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'is_doctor' => $user['is_doctor'],
            'clinic_id' => $user['clinic_id']
        ];

        // Obtener roles
        $roles = $this->userModel->getRoles($user['id']);

        return $this->response([
            'success' => true,
            'message' => 'Autenticación exitosa',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => SESSION_LIFETIME,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'is_doctor' => $user['is_doctor'],
                    'clinic_id' => $user['clinic_id'],
                    'roles' => $roles
                ]
            ]
        ]);
    }

    /**
     * Logout
     */
    private function logout() {
        $user = $this->authenticate();

        session_start();
        session_destroy();

        return $this->response([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    /**
     * Refresh token
     */
    private function refreshToken() {
        $user = $this->authenticate();

        // Generar nuevo token
        $token = $this->generateToken($user['id']);

        session_start();
        $_SESSION['api_token'] = $token;

        return $this->response([
            'success' => true,
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => SESSION_LIFETIME
            ]
        ]);
    }

    /**
     * GET /api/auth/me - Obtener información del usuario autenticado
     */
    protected function get() {
        $user = $this->authenticate();

        // Obtener roles
        $roles = $this->userModel->getRoles($user['id']);

        return $this->response([
            'success' => true,
            'data' => [
                'user' => array_merge($user, ['roles' => $roles])
            ]
        ]);
    }
}
