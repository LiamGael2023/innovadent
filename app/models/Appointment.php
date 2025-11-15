<?php
/**
 * Modelo Appointment - Gestión de citas
 */
class Appointment extends Model {
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    /**
     * Obtener citas por fecha y doctor
     */
    public function getByDateAndDoctor($date, $doctorId) {
        $sql = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name,
                p.phone as patient_phone, at.name as appointment_type_name, at.color as appointment_type_color
                FROM {$this->table} a
                LEFT JOIN patients p ON a.patient_id = p.id
                LEFT JOIN appointment_types at ON a.appointment_type_id = at.id
                WHERE a.appointment_date = :date AND a.doctor_id = :doctor_id
                AND a.status NOT IN ('cancelled')
                ORDER BY a.start_time";

        return $this->db->query($sql)
                       ->bind(':date', $date)
                       ->bind(':doctor_id', $doctorId)
                       ->fetchAll();
    }

    /**
     * Obtener citas por fecha y clínica
     */
    public function getByDateAndClinic($date, $clinicId) {
        $sql = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name,
                p.phone as patient_phone, u.first_name as doctor_first_name, u.last_name as doctor_last_name,
                at.name as appointment_type_name, at.color as appointment_type_color
                FROM {$this->table} a
                LEFT JOIN patients p ON a.patient_id = p.id
                LEFT JOIN users u ON a.doctor_id = u.id
                LEFT JOIN appointment_types at ON a.appointment_type_id = at.id
                WHERE a.appointment_date = :date AND a.clinic_id = :clinic_id
                AND a.status NOT IN ('cancelled')
                ORDER BY a.start_time, u.first_name";

        return $this->db->query($sql)
                       ->bind(':date', $date)
                       ->bind(':clinic_id', $clinicId)
                       ->fetchAll();
    }

    /**
     * Verificar disponibilidad
     */
    public function checkAvailability($doctorId, $date, $startTime, $endTime, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}
                WHERE doctor_id = :doctor_id
                AND appointment_date = :date
                AND status NOT IN ('cancelled', 'no_show')
                AND (
                    (start_time <= :start_time AND end_time > :start_time) OR
                    (start_time < :end_time AND end_time >= :end_time) OR
                    (start_time >= :start_time AND end_time <= :end_time)
                )";

        if ($excludeId) {
            $sql .= " AND id != :exclude_id";
        }

        $query = $this->db->query($sql)
                        ->bind(':doctor_id', $doctorId)
                        ->bind(':date', $date)
                        ->bind(':start_time', $startTime)
                        ->bind(':end_time', $endTime);

        if ($excludeId) {
            $query->bind(':exclude_id', $excludeId);
        }

        $result = $query->fetch();
        return $result['count'] == 0;
    }

    /**
     * Crear cita
     */
    public function createAppointment($data) {
        // Verificar disponibilidad
        if (!$this->checkAvailability(
            $data['doctor_id'],
            $data['appointment_date'],
            $data['start_time'],
            $data['end_time']
        )) {
            return ['success' => false, 'error' => 'El horario seleccionado no está disponible'];
        }

        $id = $this->create($data);

        if ($id) {
            return ['success' => true, 'id' => $id];
        }

        return ['success' => false, 'error' => 'Error al crear la cita'];
    }

    /**
     * Actualizar estado de cita
     */
    public function updateStatus($id, $status, $additionalData = []) {
        $data = ['status' => $status];

        // Agregar timestamp según el estado
        switch ($status) {
            case 'confirmed':
                $data['confirmed_at'] = date('Y-m-d H:i:s');
                break;
            case 'waiting':
                $data['arrived_at'] = date('Y-m-d H:i:s');
                break;
            case 'in_progress':
                $data['started_at'] = date('Y-m-d H:i:s');
                break;
            case 'completed':
                $data['completed_at'] = date('Y-m-d H:i:s');
                break;
        }

        // Agregar datos adicionales
        $data = array_merge($data, $additionalData);

        return $this->update($id, $data);
    }

    /**
     * Obtener citas pendientes de hoy
     */
    public function getTodayPending($clinicId) {
        $sql = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name,
                u.first_name as doctor_first_name, u.last_name as doctor_last_name
                FROM {$this->table} a
                LEFT JOIN patients p ON a.patient_id = p.id
                LEFT JOIN users u ON a.doctor_id = u.id
                WHERE a.clinic_id = :clinic_id
                AND a.appointment_date = CURDATE()
                AND a.status IN ('scheduled', 'confirmed', 'waiting')
                ORDER BY a.start_time";

        return $this->db->query($sql)
                       ->bind(':clinic_id', $clinicId)
                       ->fetchAll();
    }

    /**
     * Obtener estadísticas de citas
     */
    public function getStats($clinicId, $startDate, $endDate) {
        $sql = "SELECT
                COUNT(*) as total_appointments,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN status = 'no_show' THEN 1 ELSE 0 END) as no_shows,
                SUM(CASE WHEN status IN ('scheduled', 'confirmed') THEN 1 ELSE 0 END) as pending
                FROM {$this->table}
                WHERE clinic_id = :clinic_id
                AND appointment_date BETWEEN :start_date AND :end_date";

        return $this->db->query($sql)
                       ->bind(':clinic_id', $clinicId)
                       ->bind(':start_date', $startDate)
                       ->bind(':end_date', $endDate)
                       ->fetch();
    }
}
