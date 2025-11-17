<?php
/**
 * Controlador de Pagos
 */
class PaymentsController extends Controller {
    public function __construct() {
        $this->requireAuth();
    }

    /**
     * Listar pagos
     */
    public function index() {
        $data = [
            'title' => 'Pagos - ' . APP_NAME
        ];

        $this->view('payments/index', $data);
    }
}
