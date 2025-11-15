<?php
/**
 * Modelo Laboratory - Gestión de laboratorio dental
 */
class Laboratory extends Model {
    protected $table = 'lab_orders';
    protected $primaryKey = 'id';

    /**
     * Obtener órdenes de laboratorio por clínica
     */
    public function getByClinic($clinicId, $status = null) {
        $sql = "SELECT lo.*, p.first_name as patient_first_name, p.last_name as patient_last_name,
                u.first_name as doctor_first_name, u.last_name as doctor_last_name,
                pt.name as prosthetic_type_name, dl.name as lab_name
                FROM {$this->table} lo
                LEFT JOIN patients p ON lo.patient_id = p.id
                LEFT JOIN users u ON lo.doctor_id = u.id
                LEFT JOIN prosthetic_types pt ON lo.prosthetic_type_id = pt.id
                LEFT JOIN dental_labs dl ON lo.dental_lab_id = dl.id
                WHERE lo.clinic_id = :clinic_id";

        if ($status) {
            $sql .= " AND lo.status = :status";
        }

        $sql .= " ORDER BY lo.order_date DESC";

        $query = $this->db->query($sql)->bind(':clinic_id', $clinicId);

        if ($status) {
            $query->bind(':status', $status);
        }

        return $query->fetchAll();
    }

    /**
     * Generar número de orden automático
     */
    public function generateOrderNumber($clinicId) {
        $sql = "SELECT MAX(CAST(SUBSTRING(order_number, 4) AS UNSIGNED)) as max_number
                FROM {$this->table}
                WHERE clinic_id = :clinic_id";

        $result = $this->db->query($sql)->bind(':clinic_id', $clinicId)->fetch();
        $nextNumber = ($result && $result['max_number']) ? $result['max_number'] + 1 : 1;

        return 'LAB' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Crear orden de laboratorio
     */
    public function createLabOrder($data) {
        if (!isset($data['order_number'])) {
            $data['order_number'] = $this->generateOrderNumber($data['clinic_id']);
        }

        return $this->create($data);
    }

    /**
     * Obtener estadísticas de laboratorio
     */
    public function getStats($clinicId, $startDate, $endDate) {
        $sql = "SELECT
                COUNT(*) as total_orders,
                SUM(CASE WHEN status = 'ready' THEN 1 ELSE 0 END) as ready,
                SUM(CASE WHEN status = 'in_process' THEN 1 ELSE 0 END) as in_process,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                SUM(cost) as total_cost
                FROM {$this->table}
                WHERE clinic_id = :clinic_id
                AND order_date BETWEEN :start_date AND :end_date";

        return $this->db->query($sql)
                       ->bind(':clinic_id', $clinicId)
                       ->bind(':start_date', $startDate)
                       ->bind(':end_date', $endDate)
                       ->fetch();
    }
}
