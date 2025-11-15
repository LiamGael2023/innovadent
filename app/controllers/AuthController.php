<?php
/**
 * Controlador de Autenticación
 */
class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    /**
     * Mostrar formulario de login
     */
    public function login() {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }

        $data = [
            'title' => 'Iniciar Sesión - ' . APP_NAME,
            'error' => $this->getFlash('error')
        ];

        $this->view('auth/login', $data);
    }

    /**
     * Procesar login
     */
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/auth/login');
        }

        $username = $this->post('username');
        $password = $this->post('password');
        $remember = $this->post('remember');

        // Validar
        if (empty($username) || empty($password)) {
            $this->flash('error', 'Por favor, ingrese usuario y contraseña.', 'danger');
            $this->redirect('/auth/login');
        }

        // Autenticar
        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Iniciar sesión
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['user_id'] = $user['id'];
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
            $_SESSION['user']['roles'] = $roles;

            $this->flash('success', 'Bienvenido, ' . $user['first_name'] . '!', 'success');
            $this->redirect('/dashboard');
        } else {
            $this->flash('error', 'Usuario o contraseña incorrectos.', 'danger');
            $this->redirect('/auth/login');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        if (!isset($_SESSION)) {
            session_start();
        }

        session_unset();
        session_destroy();

        $this->flash('success', 'Sesión cerrada correctamente.', 'info');
        $this->redirect('/auth/login');
    }

    /**
     * Mostrar formulario de registro (opcional)
     */
    public function register() {
        $data = [
            'title' => 'Registrarse - ' . APP_NAME
        ];

        $this->view('auth/register', $data);
    }

    /**
     * Procesar registro
     */
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/auth/register');
        }

        // Implementar lógica de registro si es necesario
    }
}
