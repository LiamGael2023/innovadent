<?php
/**
 * Controlador de Laboratorio Dental
 */
class LaboratoryController extends Controller {
    private $laboratoryModel;

    public function __construct() {
        $this->requireAuth();
        $this->laboratoryModel = $this->model('Laboratory');
    }

    /**
     * Listar órdenes de laboratorio
     */
    public function index() {
        $user = $this->auth();
        $status = $this->get('status');

        $orders = $this->laboratoryModel->getByClinic($user['clinic_id'], $status);

        $data = [
            'title' => 'Laboratorio Dental - ' . APP_NAME,
            'orders' => $orders,
            'selected_status' => $status,
            'success' => $this->getFlash('success')
        ];

        $this->view('laboratory/index', $data);
    }

    /**
     * Crear nueva orden
     */
    public function create() {
        $user = $this->auth();

        // Obtener pacientes y doctores
        $patientModel = $this->model('Patient');
        $userModel = $this->model('User');

        $data = [
            'title' => 'Nueva Orden de Laboratorio - ' . APP_NAME,
            'doctors' => $userModel->getDoctors($user['clinic_id'])
        ];

        $this->view('laboratory/create', $data);
    }

    /**
     * Guardar orden
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/laboratory/create');
        }

        $user = $this->auth();

        $data = [
            'clinic_id' => $user['clinic_id'],
            'patient_id' => $this->post('patient_id'),
            'doctor_id' => $this->post('doctor_id'),
            'dental_lab_id' => $this->post('dental_lab_id'),
            'prosthetic_type_id' => $this->post('prosthetic_type_id'),
            'order_date' => date('Y-m-d'),
            'expected_delivery_date' => $this->post('expected_delivery_date'),
            'teeth_numbers' => $this->post('teeth_numbers'),
            'shade' => $this->post('shade'),
            'material' => $this->post('material'),
            'specifications' => $this->post('specifications'),
            'cost' => $this->post('cost'),
            'status' => 'requested'
        ];

        $orderId = $this->laboratoryModel->createLabOrder($data);

        if ($orderId) {
            $this->flash('success', 'Orden de laboratorio creada exitosamente.', 'success');
            $this->redirect('/laboratory/view/' . $orderId);
        } else {
            $this->flash('error', 'Error al crear la orden.', 'danger');
            $this->redirect('/laboratory/create');
        }
    }

    /**
     * Ver detalles de orden
     */
    public function view($id) {
        $order = $this->laboratoryModel->find($id);

        if (!$order) {
            $this->flash('error', 'Orden no encontrada.', 'danger');
            $this->redirect('/laboratory');
        }

        $data = [
            'title' => 'Orden de Laboratorio - ' . APP_NAME,
            'order' => $order
        ];

        $this->view('laboratory/view', $data);
    }

    /**
     * Actualizar estado
     */
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/laboratory');
        }

        $status = $this->post('status');
        $data = ['status' => $status];

        if ($status === 'ready') {
            $data['actual_delivery_date'] = date('Y-m-d');
        }

        if ($this->laboratoryModel->update($id, $data)) {
            $this->flash('success', 'Estado actualizado exitosamente.', 'success');
        } else {
            $this->flash('error', 'Error al actualizar el estado.', 'danger');
        }

        $this->redirect('/laboratory/view/' . $id);
    }
}
