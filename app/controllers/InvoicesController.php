<?php
/**
 * Controlador de Facturación
 */
class InvoicesController extends Controller {
    public function __construct() {
        $this->requireAuth();
    }

    /**
     * Listar facturas
     */
    public function index() {
        $data = [
            'title' => 'Facturación - ' . APP_NAME
        ];

        $this->view('invoices/index', $data);
    }
}
