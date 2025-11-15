<?php
/**
 * Controlador del Dashboard
 */
class DashboardController extends Controller {
    private $appointmentModel;
    private $patientModel;

    public function __construct() {
        $this->requireAuth();
        $this->appointmentModel = $this->model('Appointment');
        $this->patientModel = $this->model('Patient');
    }

    /**
     * Página principal del dashboard
     */
    public function index() {
        $user = $this->auth();
        $clinicId = $user['clinic_id'];

        // Obtener citas de hoy
        $todayAppointments = $this->appointmentModel->getTodayPending($clinicId);

        // Obtener estadísticas del mes actual
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        $monthStats = $this->appointmentModel->getStats($clinicId, $startOfMonth, $endOfMonth);

        // Contar pacientes activos
        $totalPatients = $this->patientModel->count([
            'clinic_id' => $clinicId,
            'is_active' => 1
        ]);

        $data = [
            'title' => 'Dashboard - ' . APP_NAME,
            'user' => $user,
            'today_appointments' => $todayAppointments,
            'month_stats' => $monthStats,
            'total_patients' => $totalPatients,
            'success' => $this->getFlash('success')
        ];

        $this->view('dashboard/index', $data);
    }

    /**
     * Obtener datos para gráficos (AJAX)
     */
    public function chartData() {
        $user = $this->auth();
        $clinicId = $user['clinic_id'];

        $type = $this->get('type', 'weekly');

        // Implementar lógica para diferentes tipos de gráficos
        $data = [
            'labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            'values' => [12, 19, 15, 17, 14, 8]
        ];

        $this->json($data);
    }
}
