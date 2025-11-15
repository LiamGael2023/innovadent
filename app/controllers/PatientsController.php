<?php
/**
 * Controlador de Pacientes
 */
class PatientsController extends Controller {
    private $patientModel;

    public function __construct() {
        $this->requireAuth();
        $this->patientModel = $this->model('Patient');
    }

    /**
     * Listar pacientes
     */
    public function index() {
        $user = $this->auth();
        $clinicId = $user['clinic_id'];
        $page = $this->get('page', 1);

        $patients = $this->patientModel->getByClinic($clinicId, $page);

        $data = [
            'title' => 'Pacientes - ' . APP_NAME,
            'patients' => $patients['data'],
            'pagination' => [
                'current_page' => $patients['current_page'],
                'last_page' => $patients['last_page'],
                'total' => $patients['total']
            ],
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ];

        $this->view('patients/index', $data);
    }

    /**
     * Mostrar formulario de crear paciente
     */
    public function create() {
        $data = [
            'title' => 'Nuevo Paciente - ' . APP_NAME
        ];

        $this->view('patients/create', $data);
    }

    /**
     * Guardar nuevo paciente
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/patients/create');
        }

        $user = $this->auth();

        // Validar datos
        $validation = $this->validate($_POST, [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'gender' => 'required',
            'email' => 'email',
            'phone' => 'required'
        ]);

        if ($validation !== true) {
            $this->flash('error', 'Por favor, corrija los errores en el formulario.', 'danger');
            $_SESSION['validation_errors'] = $validation;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('/patients/create');
        }

        // Preparar datos
        $data = [
            'clinic_id' => $user['clinic_id'],
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'second_last_name' => $this->post('second_last_name'),
            'date_of_birth' => $this->post('date_of_birth'),
            'gender' => $this->post('gender'),
            'blood_type' => $this->post('blood_type'),
            'email' => $this->post('email'),
            'phone' => $this->post('phone'),
            'mobile' => $this->post('mobile'),
            'address' => $this->post('address'),
            'postal_code' => $this->post('postal_code'),
            'occupation' => $this->post('occupation'),
            'referred_by' => $this->post('referred_by'),
            'notes' => $this->post('notes')
        ];

        // Crear paciente
        $patientId = $this->patientModel->createPatient($data);

        if ($patientId) {
            $this->flash('success', 'Paciente creado exitosamente.', 'success');
            $this->redirect('/patients/view/' . $patientId);
        } else {
            $this->flash('error', 'Error al crear el paciente.', 'danger');
            $this->redirect('/patients/create');
        }
    }

    /**
     * Ver detalles del paciente
     */
    public function view($id) {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            $this->flash('error', 'Paciente no encontrado.', 'danger');
            $this->redirect('/patients');
        }

        // Obtener información adicional
        $medicalHistory = $this->patientModel->getMedicalHistory($id);
        $upcomingAppointments = $this->patientModel->getUpcomingAppointments($id);
        $appointmentHistory = $this->patientModel->getAppointmentHistory($id);
        $stats = $this->patientModel->getPatientStats($id);

        $data = [
            'title' => $patient['first_name'] . ' ' . $patient['last_name'] . ' - ' . APP_NAME,
            'patient' => $patient,
            'medical_history' => $medicalHistory,
            'upcoming_appointments' => $upcomingAppointments,
            'appointment_history' => $appointmentHistory,
            'stats' => $stats,
            'success' => $this->getFlash('success')
        ];

        $this->view('patients/view', $data);
    }

    /**
     * Editar paciente
     */
    public function edit($id) {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            $this->flash('error', 'Paciente no encontrado.', 'danger');
            $this->redirect('/patients');
        }

        $data = [
            'title' => 'Editar Paciente - ' . APP_NAME,
            'patient' => $patient
        ];

        $this->view('patients/edit', $data);
    }

    /**
     * Actualizar paciente
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/patients/edit/' . $id);
        }

        // Preparar datos
        $data = [
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'second_last_name' => $this->post('second_last_name'),
            'date_of_birth' => $this->post('date_of_birth'),
            'gender' => $this->post('gender'),
            'blood_type' => $this->post('blood_type'),
            'email' => $this->post('email'),
            'phone' => $this->post('phone'),
            'mobile' => $this->post('mobile'),
            'address' => $this->post('address'),
            'postal_code' => $this->post('postal_code'),
            'occupation' => $this->post('occupation'),
            'notes' => $this->post('notes')
        ];

        // Actualizar
        if ($this->patientModel->update($id, $data)) {
            $this->flash('success', 'Paciente actualizado exitosamente.', 'success');
            $this->redirect('/patients/view/' . $id);
        } else {
            $this->flash('error', 'Error al actualizar el paciente.', 'danger');
            $this->redirect('/patients/edit/' . $id);
        }
    }

    /**
     * Buscar pacientes (AJAX)
     */
    public function search() {
        $query = $this->get('q', '');
        $user = $this->auth();

        if (strlen($query) < 2) {
            $this->json(['results' => []]);
        }

        $results = $this->patientModel->searchByName($query, $user['clinic_id']);

        $this->json(['results' => $results]);
    }

    /**
     * Eliminar paciente (soft delete)
     */
    public function delete($id) {
        if ($this->patientModel->softDelete($id)) {
            $this->flash('success', 'Paciente eliminado exitosamente.', 'success');
        } else {
            $this->flash('error', 'Error al eliminar el paciente.', 'danger');
        }

        $this->redirect('/patients');
    }
}
