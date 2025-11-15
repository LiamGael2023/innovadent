<?php
/**
 * Controlador de Reportes y Analítica
 */
class ReportsController extends Controller {
    private $appointmentModel;
    private $patientModel;

    public function __construct() {
        $this->requireAuth();
        $this->appointmentModel = $this->model('Appointment');
        $this->patientModel = $this->model('Patient');
    }

    /**
     * Dashboard de reportes
     */
    public function index() {
        $user = $this->auth();

        $data = [
            'title' => 'Reportes y Analítica - ' . APP_NAME,
            'user' => $user
        ];

        $this->view('reports/index', $data);
    }

    /**
     * Reporte de citas
     */
    public function appointments() {
        $user = $this->auth();

        $startDate = $this->get('start_date', date('Y-m-01'));
        $endDate = $this->get('end_date', date('Y-m-t'));

        $stats = $this->appointmentModel->getStats($user['clinic_id'], $startDate, $endDate);

        // Obtener datos por día para gráfico
        $dailyStats = $this->getDailyAppointmentStats($user['clinic_id'], $startDate, $endDate);

        $data = [
            'title' => 'Reporte de Citas - ' . APP_NAME,
            'stats' => $stats,
            'daily_stats' => $dailyStats,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        $this->view('reports/appointments', $data);
    }

    /**
     * Reporte de pacientes
     */
    public function patients() {
        $user = $this->auth();

        // Pacientes por mes (últimos 12 meses)
        $monthlyPatients = $this->getMonthlyPatientStats($user['clinic_id']);

        // Total de pacientes
        $totalPatients = $this->patientModel->count([
            'clinic_id' => $user['clinic_id'],
            'is_active' => 1
        ]);

        $data = [
            'title' => 'Reporte de Pacientes - ' . APP_NAME,
            'monthly_patients' => $monthlyPatients,
            'total_patients' => $totalPatients
        ];

        $this->view('reports/patients', $data);
    }

    /**
     * Reporte financiero
     */
    public function financial() {
        $user = $this->auth();

        $startDate = $this->get('start_date', date('Y-m-01'));
        $endDate = $this->get('end_date', date('Y-m-t'));

        // Obtener ingresos
        $sql = "SELECT SUM(amount) as total FROM payments
                WHERE clinic_id = :clinic_id
                AND payment_date BETWEEN :start_date AND :end_date
                AND status = 'completed'";

        $totalIncome = $this->appointmentModel->db->query($sql)
                      ->bind(':clinic_id', $user['clinic_id'])
                      ->bind(':start_date', $startDate)
                      ->bind(':end_date', $endDate)
                      ->fetch()['total'] ?? 0;

        $data = [
            'title' => 'Reporte Financiero - ' . APP_NAME,
            'total_income' => $totalIncome,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        $this->view('reports/financial', $data);
    }

    /**
     * Obtener estadísticas diarias de citas
     */
    private function getDailyAppointmentStats($clinicId, $startDate, $endDate) {
        $sql = "SELECT
                appointment_date,
                COUNT(*) as total,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN status = 'no_show' THEN 1 ELSE 0 END) as no_shows
                FROM appointments
                WHERE clinic_id = :clinic_id
                AND appointment_date BETWEEN :start_date AND :end_date
                GROUP BY appointment_date
                ORDER BY appointment_date";

        return $this->appointmentModel->db->query($sql)
                                         ->bind(':clinic_id', $clinicId)
                                         ->bind(':start_date', $startDate)
                                         ->bind(':end_date', $endDate)
                                         ->fetchAll();
    }

    /**
     * Obtener estadísticas mensuales de pacientes
     */
    private function getMonthlyPatientStats($clinicId) {
        $sql = "SELECT
                DATE_FORMAT(created_at, '%Y-%m') as month,
                COUNT(*) as total
                FROM patients
                WHERE clinic_id = :clinic_id
                AND created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month";

        return $this->patientModel->db->query($sql)
                                     ->bind(':clinic_id', $clinicId)
                                     ->fetchAll();
    }

    /**
     * Exportar reporte a CSV
     */
    public function export() {
        $user = $this->auth();
        $type = $this->get('type', 'appointments');

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reporte_' . $type . '_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

        if ($type === 'appointments') {
            fputcsv($output, ['Fecha', 'Paciente', 'Doctor', 'Estado', 'Hora']);

            $appointments = $this->appointmentModel->getByDateAndClinic(
                date('Y-m-d'),
                $user['clinic_id']
            );

            foreach ($appointments as $apt) {
                fputcsv($output, [
                    $apt['appointment_date'],
                    $apt['patient_first_name'] . ' ' . $apt['patient_last_name'],
                    $apt['doctor_first_name'] . ' ' . $apt['doctor_last_name'],
                    $apt['status'],
                    $apt['start_time']
                ]);
            }
        }

        fclose($output);
        exit;
    }

    /**
     * API para gráficos (AJAX)
     */
    public function chartData() {
        $user = $this->auth();
        $type = $this->get('type');

        if ($type === 'appointments_daily') {
            $stats = $this->getDailyAppointmentStats(
                $user['clinic_id'],
                date('Y-m-01'),
                date('Y-m-t')
            );

            $data = [
                'labels' => array_column($stats, 'appointment_date'),
                'completed' => array_column($stats, 'completed'),
                'cancelled' => array_column($stats, 'cancelled'),
                'no_shows' => array_column($stats, 'no_shows')
            ];

            $this->json($data);
        }
    }
}
