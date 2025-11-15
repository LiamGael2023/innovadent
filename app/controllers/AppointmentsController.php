<?php
/**
 * Controlador de Citas
 */
class AppointmentsController extends Controller {
    private $appointmentModel;
    private $patientModel;
    private $userModel;

    public function __construct() {
        $this->requireAuth();
        $this->appointmentModel = $this->model('Appointment');
        $this->patientModel = $this->model('Patient');
        $this->userModel = $this->model('User');
    }

    /**
     * Vista de agenda/calendario
     */
    public function index() {
        $user = $this->auth();
        $date = $this->get('date', date('Y-m-d'));
        $doctorId = $this->get('doctor_id', $user['is_doctor'] ? $user['id'] : null);

        // Obtener doctores
        $doctors = $this->userModel->getDoctors($user['clinic_id']);

        // Obtener citas
        if ($doctorId) {
            $appointments = $this->appointmentModel->getByDateAndDoctor($date, $doctorId);
        } else {
            $appointments = $this->appointmentModel->getByDateAndClinic($date, $user['clinic_id']);
        }

        $data = [
            'title' => 'Agenda - ' . APP_NAME,
            'appointments' => $appointments,
            'doctors' => $doctors,
            'selected_date' => $date,
            'selected_doctor' => $doctorId,
            'success' => $this->getFlash('success'),
            'error' => $this->getFlash('error')
        ];

        $this->view('appointments/index', $data);
    }

    /**
     * Crear nueva cita
     */
    public function create() {
        $user = $this->auth();

        $data = [
            'title' => 'Nueva Cita - ' . APP_NAME,
            'doctors' => $this->userModel->getDoctors($user['clinic_id']),
            'appointment_date' => $this->get('date', date('Y-m-d')),
            'start_time' => $this->get('time', '09:00')
        ];

        $this->view('appointments/create', $data);
    }

    /**
     * Guardar nueva cita
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/appointments/create');
        }

        $user = $this->auth();

        // Calcular end_time basado en duration
        $startTime = $this->post('start_time');
        $duration = $this->post('duration_minutes', 30);
        $endTime = date('H:i', strtotime($startTime) + ($duration * 60));

        $data = [
            'clinic_id' => $user['clinic_id'],
            'patient_id' => $this->post('patient_id'),
            'doctor_id' => $this->post('doctor_id'),
            'appointment_type_id' => $this->post('appointment_type_id'),
            'appointment_date' => $this->post('appointment_date'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_minutes' => $duration,
            'chair_number' => $this->post('chair_number'),
            'reason' => $this->post('reason'),
            'notes' => $this->post('notes'),
            'status' => 'scheduled',
            'created_by' => $user['id']
        ];

        $result = $this->appointmentModel->createAppointment($data);

        if ($result['success']) {
            $this->flash('success', 'Cita creada exitosamente.', 'success');
            $this->redirect('/appointments?date=' . $data['appointment_date']);
        } else {
            $this->flash('error', $result['error'], 'danger');
            $this->redirect('/appointments/create');
        }
    }

    /**
     * Ver detalles de la cita
     */
    public function view($id) {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            $this->flash('error', 'Cita no encontrada.', 'danger');
            $this->redirect('/appointments');
        }

        // Obtener información del paciente
        $patient = $this->patientModel->find($appointment['patient_id']);

        $data = [
            'title' => 'Detalles de Cita - ' . APP_NAME,
            'appointment' => $appointment,
            'patient' => $patient
        ];

        $this->view('appointments/view', $data);
    }

    /**
     * Actualizar estado de cita
     */
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/appointments');
        }

        $status = $this->post('status');

        if ($this->appointmentModel->updateStatus($id, $status)) {
            $this->flash('success', 'Estado de la cita actualizado.', 'success');
        } else {
            $this->flash('error', 'Error al actualizar el estado.', 'danger');
        }

        $this->redirect('/appointments/view/' . $id);
    }

    /**
     * Cancelar cita
     */
    public function cancel($id) {
        if ($this->appointmentModel->updateStatus($id, 'cancelled')) {
            $this->flash('success', 'Cita cancelada exitosamente.', 'success');
        } else {
            $this->flash('error', 'Error al cancelar la cita.', 'danger');
        }

        $this->redirect('/appointments');
    }
}
