<?php
/**
 * Portal del Paciente - Autogestión
 */
class PortalController extends Controller {
    private $patientModel;
    private $appointmentModel;

    public function __construct() {
        $this->patientModel = $this->model('Patient');
        $this->appointmentModel = $this->model('Appointment');
    }

    /**
     * Página de login del portal
     */
    public function login() {
        // Si ya está autenticado como paciente
        if ($this->isPatientAuthenticated()) {
            $this->redirect('/portal/dashboard');
        }

        $data = [
            'title' => 'Portal del Paciente - ' . APP_NAME,
            'error' => $this->getFlash('error')
        ];

        $this->view('portal/login', $data);
    }

    /**
     * Autenticar paciente
     */
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/portal/login');
        }

        $patientNumber = $this->post('patient_number');
        $dateOfBirth = $this->post('date_of_birth');

        // Buscar paciente por número de expediente y fecha de nacimiento
        $patient = $this->patientModel->findByNumber($patientNumber);

        if ($patient && $patient['date_of_birth'] === $dateOfBirth) {
            // Iniciar sesión del paciente
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['portal_patient_id'] = $patient['id'];
            $_SESSION['portal_patient'] = [
                'id' => $patient['id'],
                'patient_number' => $patient['patient_number'],
                'first_name' => $patient['first_name'],
                'last_name' => $patient['last_name'],
                'email' => $patient['email']
            ];

            $this->flash('success', 'Bienvenido al portal, ' . $patient['first_name'] . '!', 'success');
            $this->redirect('/portal/dashboard');
        } else {
            $this->flash('error', 'Número de expediente o fecha de nacimiento incorrectos.', 'danger');
            $this->redirect('/portal/login');
        }
    }

    /**
     * Dashboard del portal del paciente
     */
    public function dashboard() {
        $this->requirePatientAuth();

        $patientId = $_SESSION['portal_patient_id'];
        $patient = $this->patientModel->find($patientId);

        // Obtener información
        $upcomingAppointments = $this->patientModel->getUpcomingAppointments($patientId, 5);
        $recentAppointments = $this->patientModel->getAppointmentHistory($patientId, 5);
        $stats = $this->patientModel->getPatientStats($patientId);

        $data = [
            'title' => 'Mi Portal - ' . APP_NAME,
            'patient' => $patient,
            'upcoming_appointments' => $upcomingAppointments,
            'recent_appointments' => $recentAppointments,
            'stats' => $stats,
            'success' => $this->getFlash('success')
        ];

        $this->view('portal/dashboard', $data);
    }

    /**
     * Mis citas
     */
    public function appointments() {
        $this->requirePatientAuth();

        $patientId = $_SESSION['portal_patient_id'];
        $patient = $this->patientModel->find($patientId);
        $appointments = $this->patientModel->getAppointmentHistory($patientId, 50);

        $data = [
            'title' => 'Mis Citas - ' . APP_NAME,
            'patient' => $patient,
            'appointments' => $appointments
        ];

        $this->view('portal/appointments', $data);
    }

    /**
     * Agendar nueva cita
     */
    public function schedule() {
        $this->requirePatientAuth();

        $patientId = $_SESSION['portal_patient_id'];
        $patient = $this->patientModel->find($patientId);

        // Obtener doctores disponibles
        require_once APP_PATH . '/models/User.php';
        $userModel = new User();
        $doctors = $userModel->getDoctors($patient['clinic_id']);

        $data = [
            'title' => 'Agendar Cita - ' . APP_NAME,
            'patient' => $patient,
            'doctors' => $doctors
        ];

        $this->view('portal/schedule', $data);
    }

    /**
     * Mi perfil
     */
    public function profile() {
        $this->requirePatientAuth();

        $patientId = $_SESSION['portal_patient_id'];
        $patient = $this->patientModel->find($patientId);
        $medicalHistory = $this->patientModel->getMedicalHistory($patientId);

        $data = [
            'title' => 'Mi Perfil - ' . APP_NAME,
            'patient' => $patient,
            'medical_history' => $medicalHistory,
            'success' => $this->getFlash('success')
        ];

        $this->view('portal/profile', $data);
    }

    /**
     * Actualizar perfil
     */
    public function updateProfile() {
        $this->requirePatientAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/portal/profile');
        }

        $patientId = $_SESSION['portal_patient_id'];

        $data = [
            'email' => $this->post('email'),
            'phone' => $this->post('phone'),
            'mobile' => $this->post('mobile'),
            'address' => $this->post('address'),
            'postal_code' => $this->post('postal_code')
        ];

        if ($this->patientModel->update($patientId, $data)) {
            $this->flash('success', 'Perfil actualizado exitosamente.', 'success');
        } else {
            $this->flash('error', 'Error al actualizar el perfil.', 'danger');
        }

        $this->redirect('/portal/profile');
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        if (!isset($_SESSION)) {
            session_start();
        }

        unset($_SESSION['portal_patient_id']);
        unset($_SESSION['portal_patient']);

        $this->flash('success', 'Sesión cerrada correctamente.', 'info');
        $this->redirect('/portal/login');
    }

    /**
     * Verificar autenticación de paciente
     */
    private function isPatientAuthenticated() {
        if (!isset($_SESSION)) {
            session_start();
        }

        return isset($_SESSION['portal_patient_id']) && !empty($_SESSION['portal_patient_id']);
    }

    /**
     * Requerir autenticación de paciente
     */
    private function requirePatientAuth() {
        if (!$this->isPatientAuthenticated()) {
            $this->flash('error', 'Debe iniciar sesión para acceder al portal.', 'warning');
            $this->redirect('/portal/login');
        }
    }

    /**
     * Obtener disponibilidad de horarios (AJAX)
     */
    public function checkAvailability() {
        $this->requirePatientAuth();

        $doctorId = $this->get('doctor_id');
        $date = $this->get('date');

        if (!$doctorId || !$date) {
            $this->json(['error' => 'Parámetros incompletos'], 400);
        }

        // Obtener citas del doctor en esa fecha
        $appointments = $this->appointmentModel->getByDateAndDoctor($date, $doctorId);

        // Generar horarios disponibles (9:00 AM a 6:00 PM, cada 30 min)
        $availableSlots = [];
        $startHour = 9;
        $endHour = 18;

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $endTime = date('H:i', strtotime($time) + 1800); // +30 min

                // Verificar si está disponible
                $isAvailable = true;
                foreach ($appointments as $apt) {
                    if ($time >= $apt['start_time'] && $time < $apt['end_time']) {
                        $isAvailable = false;
                        break;
                    }
                }

                if ($isAvailable) {
                    $availableSlots[] = [
                        'time' => $time,
                        'display' => date('h:i A', strtotime($time))
                    ];
                }
            }
        }

        $this->json(['slots' => $availableSlots]);
    }

    /**
     * Confirmar cita desde el portal
     */
    public function confirmAppointment() {
        $this->requirePatientAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/portal/appointments');
        }

        $patientId = $_SESSION['portal_patient_id'];
        $patient = $this->patientModel->find($patientId);

        $data = [
            'clinic_id' => $patient['clinic_id'],
            'patient_id' => $patientId,
            'doctor_id' => $this->post('doctor_id'),
            'appointment_date' => $this->post('appointment_date'),
            'start_time' => $this->post('start_time'),
            'end_time' => date('H:i', strtotime($this->post('start_time')) + 1800),
            'duration_minutes' => 30,
            'reason' => $this->post('reason'),
            'status' => 'scheduled',
            'created_by' => null // Creada por el paciente
        ];

        $result = $this->appointmentModel->createAppointment($data);

        if ($result['success']) {
            $this->flash('success', 'Cita agendada exitosamente. Recibirá un recordatorio próximamente.', 'success');
            $this->redirect('/portal/appointments');
        } else {
            $this->flash('error', $result['error'], 'danger');
            $this->redirect('/portal/schedule');
        }
    }
}
