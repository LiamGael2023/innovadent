<?php
/**
 * Controlador de Configuración
 */
class SettingsController extends Controller {
    public function __construct() {
        $this->requireAuth();
    }

    /**
     * Configuración general
     */
    public function index() {
        $data = [
            'title' => 'Configuración - ' . APP_NAME
        ];

        $this->view('settings/index', $data);
    }
}
