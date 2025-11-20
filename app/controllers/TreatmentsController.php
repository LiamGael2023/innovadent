<?php
/**
 * Controlador de Tratamientos
 */
class TreatmentsController extends Controller {
    public function __construct() {
        $this->requireAuth();
    }

    /**
     * Listar tratamientos
     */
    public function index() {
        $data = [
            'title' => 'Tratamientos - ' . APP_NAME
        ];

        $this->view('treatments/index', $data);
    }
}
