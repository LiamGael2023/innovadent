<?php
/**
 * Modelo Patient - Gestión de pacientes
 */
class Patient extends Model {
    protected $table = 'patients';
    protected $primaryKey = 'id';

    /**
     * Generar número de paciente automático
     */
    public function generatePatientNumber($clinicId) {
        $sql = "SELECT MAX(CAST(SUBSTRING(patient_number, 4) AS UNSIGNED)) as max_number
                FROM {$this->table}
                WHERE clinic_id = :clinic_id";

        $result = $this->db->query($sql)
                          ->bind(':clinic_id', $clinicId)
                          ->fetch();

        $nextNumber = ($result && $result['max_number']) ? $result['max_number'] + 1 : 1;

        return 'PAC' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Buscar paciente por número
     */
    public function findByNumber($patientNumber) {
        return $this->where(['patient_number' => $patientNumber], null, 1);
    }

    /**
     * Buscar pacientes por nombre
     */
    public function searchByName($name, $clinicId = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE (first_name LIKE :name OR last_name LIKE :name OR second_last_name LIKE :name)";

        if ($clinicId) {
            $sql .= " AND clinic_id = :clinic_id";
        }

        $sql .= " AND is_active = 1 ORDER BY first_name, last_name LIMIT 50";

        $query = $this->db->query($sql)->bind(':name', "%{$name}%");

        if ($clinicId) {
            $query->bind(':clinic_id', $clinicId);
        }

        return $query->fetchAll();
    }

    /**
     * Obtener pacientes por clínica
     */
    public function getByClinic($clinicId, $page = 1) {
        return $this->paginate($page, ITEMS_PER_PAGE, [
            'clinic_id' => $clinicId,
            'is_active' => 1
        ]);
    }

    /**
     * Crear paciente con número automático
     */
    public function createPatient($data) {
        if (!isset($data['patient_number'])) {
            $data['patient_number'] = $this->generatePatientNumber($data['clinic_id']);
        }

        return $this->create($data);
    }

    /**
     * Obtener historia clínica del paciente
     */
    public function getMedicalHistory($patientId) {
        $sql = "SELECT * FROM medical_histories WHERE patient_id = :patient_id LIMIT 1";

        return $this->db->query($sql)
                       ->bind(':patient_id', $patientId)
                       ->fetch();
    }

    /**
     * Crear o actualizar historia clínica
     */
    public function saveMedicalHistory($patientId, $data) {
        $existing = $this->getMedicalHistory($patientId);

        if ($existing) {
            $sql = "UPDATE medical_histories SET ";
            $sets = [];
            foreach ($data as $key => $value) {
                $sets[] = "{$key} = :{$key}";
            }
            $sql .= implode(', ', $sets) . " WHERE patient_id = :patient_id";

            $query = $this->db->query($sql);
            foreach ($data as $key => $value) {
                $query->bind(":{$key}", $value);
            }
            $query->bind(':patient_id', $patientId);

            return $query->execute();
        } else {
            $data['patient_id'] = $patientId;
            $columns = array_keys($data);
            $values = array_map(function($col) { return ":{$col}"; }, $columns);

            $sql = "INSERT INTO medical_histories (" . implode(', ', $columns) . ")
                    VALUES (" . implode(', ', $values) . ")";

            $query = $this->db->query($sql);
            foreach ($data as $key => $value) {
                $query->bind(":{$key}", $value);
            }

            return $query->execute();
        }
    }

    /**
     * Obtener próximas citas del paciente
     */
    public function getUpcomingAppointments($patientId, $limit = 5) {
        $sql = "SELECT a.*, u.first_name as doctor_first_name, u.last_name as doctor_last_name,
                at.name as appointment_type_name
                FROM appointments a
                LEFT JOIN users u ON a.doctor_id = u.id
                LEFT JOIN appointment_types at ON a.appointment_type_id = at.id
                WHERE a.patient_id = :patient_id
                AND a.appointment_date >= CURDATE()
                AND a.status NOT IN ('cancelled', 'completed')
                ORDER BY a.appointment_date, a.start_time
                LIMIT {$limit}";

        return $this->db->query($sql)
                       ->bind(':patient_id', $patientId)
                       ->fetchAll();
    }

    /**
     * Obtener historial de citas
     */
    public function getAppointmentHistory($patientId, $limit = 10) {
        $sql = "SELECT a.*, u.first_name as doctor_first_name, u.last_name as doctor_last_name,
                at.name as appointment_type_name
                FROM appointments a
                LEFT JOIN users u ON a.doctor_id = u.id
                LEFT JOIN appointment_types at ON a.appointment_type_id = at.id
                WHERE a.patient_id = :patient_id
                ORDER BY a.appointment_date DESC, a.start_time DESC
                LIMIT {$limit}";

        return $this->db->query($sql)
                       ->bind(':patient_id', $patientId)
                       ->fetchAll();
    }

    /**
     * Obtener estadísticas del paciente
     */
    public function getPatientStats($patientId) {
        $sql = "SELECT
                (SELECT COUNT(*) FROM appointments WHERE patient_id = :patient_id AND status = 'completed') as total_appointments,
                (SELECT COUNT(*) FROM appointments WHERE patient_id = :patient_id AND status = 'no_show') as no_shows,
                (SELECT SUM(amount_paid) FROM payments WHERE patient_id = :patient_id) as total_paid,
                (SELECT SUM(balance) FROM invoices WHERE patient_id = :patient_id) as total_balance";

        return $this->db->query($sql)
                       ->bind(':patient_id', $patientId)
                       ->fetch();
    }
}
