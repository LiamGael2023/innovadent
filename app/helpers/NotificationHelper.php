<?php
/**
 * Notification Helper - Sistema de Notificaciones y Recordatorios Automáticos
 */
class NotificationHelper {
    private $db;
    private $whatsappHelper;

    public function __construct() {
        $this->db = new Database();
        require_once APP_PATH . '/helpers/WhatsAppHelper.php';
        $this->whatsappHelper = new WhatsAppHelper();
    }

    /**
     * Enviar recordatorios de citas del día siguiente
     * Ejecutar diariamente mediante cron job
     */
    public function sendTomorrowReminders() {
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        $sql = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name,
                p.phone as patient_phone, p.email as patient_email,
                u.first_name as doctor_first_name, u.last_name as doctor_last_name
                FROM appointments a
                INNER JOIN patients p ON a.patient_id = p.id
                INNER JOIN users u ON a.doctor_id = u.id
                WHERE a.appointment_date = :tomorrow
                AND a.status IN ('scheduled', 'confirmed')
                AND p.phone IS NOT NULL";

        $appointments = $this->db->query($sql)
                                 ->bind(':tomorrow', $tomorrow)
                                 ->fetchAll();

        $results = [];

        foreach ($appointments as $apt) {
            $patient = [
                'first_name' => $apt['patient_first_name'],
                'last_name' => $apt['patient_last_name'],
                'phone' => $apt['patient_phone'],
                'email' => $apt['patient_email']
            ];

            // Enviar por WhatsApp
            $whatsappResult = $this->whatsappHelper->sendAppointmentReminder($apt, $patient);

            // Registrar recordatorio enviado
            $this->logReminder($apt['id'], 'whatsapp', $whatsappResult['success']);

            $results[] = [
                'appointment_id' => $apt['id'],
                'patient' => $patient['first_name'] . ' ' . $patient['last_name'],
                'success' => $whatsappResult['success']
            ];

            // Delay para no saturar API
            usleep(500000);
        }

        return $results;
    }

    /**
     * Enviar recordatorios de cumpleaños
     */
    public function sendBirthdayGreetings() {
        $today = date('m-d');

        $sql = "SELECT * FROM patients
                WHERE DATE_FORMAT(date_of_birth, '%m-%d') = :today
                AND is_active = 1
                AND phone IS NOT NULL";

        $patients = $this->db->query($sql)
                            ->bind(':today', $today)
                            ->fetchAll();

        $results = [];

        foreach ($patients as $patient) {
            $result = $this->whatsappHelper->sendBirthdayMessage($patient);

            $results[] = [
                'patient_id' => $patient['id'],
                'patient' => $patient['first_name'] . ' ' . $patient['last_name'],
                'success' => $result['success']
            ];

            usleep(500000);
        }

        return $results;
    }

    /**
     * Notificar pacientes inactivos (sin cita en 6 meses)
     */
    public function notifyInactivePatients() {
        $sixMonthsAgo = date('Y-m-d', strtotime('-6 months'));

        $sql = "SELECT p.* FROM patients p
                LEFT JOIN appointments a ON p.id = a.patient_id
                WHERE p.is_active = 1
                AND p.phone IS NOT NULL
                AND (a.appointment_date IS NULL OR MAX(a.appointment_date) < :six_months_ago)
                GROUP BY p.id
                LIMIT 50"; // Limitar para no saturar

        $patients = $this->db->query($sql)
                            ->bind(':six_months_ago', $sixMonthsAgo)
                            ->fetchAll();

        $message = "Hola {nombre}! 👋\n\n";
        $message .= "Hace tiempo que no nos visitas en INNOVADENT.\n\n";
        $message .= "Te recordamos la importancia de tus revisiones dentales periódicas.\n\n";
        $message .= "¿Te gustaría agendar una cita? 🦷\n\n";
        $message .= "Contáctanos! 📞";

        return $this->whatsappHelper->sendPromotion($patients, $message);
    }

    /**
     * Enviar campaña promocional
     */
    public function sendCampaign($patientIds, $message) {
        $sql = "SELECT * FROM patients WHERE id IN (" . implode(',', $patientIds) . ")";
        $patients = $this->db->query($sql)->fetchAll();

        return $this->whatsappHelper->sendPromotion($patients, $message);
    }

    /**
     * Registrar recordatorio enviado
     */
    private function logReminder($appointmentId, $type, $success) {
        $sql = "INSERT INTO appointment_reminders
                (appointment_id, reminder_type, scheduled_at, sent_at, status)
                VALUES (:appointment_id, :type, NOW(), NOW(), :status)";

        $status = $success ? 'sent' : 'failed';

        $this->db->query($sql)
                ->bind(':appointment_id', $appointmentId)
                ->bind(':type', $type)
                ->bind(':status', $status)
                ->execute();
    }

    /**
     * Obtener estadísticas de notificaciones
     */
    public function getStats($startDate, $endDate) {
        $sql = "SELECT
                reminder_type,
                COUNT(*) as total,
                SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent,
                SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed
                FROM appointment_reminders
                WHERE scheduled_at BETWEEN :start_date AND :end_date
                GROUP BY reminder_type";

        return $this->db->query($sql)
                       ->bind(':start_date', $startDate)
                       ->bind(':end_date', $endDate)
                       ->fetchAll();
    }

    /**
     * Crear notificación en el sistema
     */
    public function createNotification($userId, $type, $title, $message, $data = []) {
        $sql = "INSERT INTO notifications (user_id, type, title, message, data, created_at)
                VALUES (:user_id, :type, :title, :message, :data, NOW())";

        return $this->db->query($sql)
                       ->bind(':user_id', $userId)
                       ->bind(':type', $type)
                       ->bind(':title', $title)
                       ->bind(':message', $message)
                       ->bind(':data', json_encode($data))
                       ->execute();
    }

    /**
     * Marcar notificación como leída
     */
    public function markAsRead($notificationId) {
        $sql = "UPDATE notifications SET is_read = 1, read_at = NOW()
                WHERE id = :id";

        return $this->db->query($sql)
                       ->bind(':id', $notificationId)
                       ->execute();
    }

    /**
     * Obtener notificaciones no leídas de un usuario
     */
    public function getUnreadNotifications($userId) {
        $sql = "SELECT * FROM notifications
                WHERE user_id = :user_id AND is_read = 0
                ORDER BY created_at DESC
                LIMIT 20";

        return $this->db->query($sql)
                       ->bind(':user_id', $userId)
                       ->fetchAll();
    }
}
