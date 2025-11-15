<?php
/**
 * Clase Router - Manejo de rutas de la aplicación
 */
class Router {
    private $controller = 'DashboardController';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Si no hay URL, cargar el controlador por defecto
        if ($url === null || empty($url[0])) {
            $this->loadController();
            return;
        }

        // Buscar el controlador
        $controllerName = ucfirst($url[0]) . 'Controller';
        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            $this->controller = $controllerName;
            unset($url[0]);
        }

        require_once APP_PATH . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Buscar el método
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Obtener parámetros
        $this->params = $url ? array_values($url) : [];

        // Llamar al método del controlador con los parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parsear la URL
     */
    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return null;
    }

    /**
     * Cargar controlador por defecto
     */
    private function loadController() {
        require_once APP_PATH . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
