<?php
/**
 * API Controller para Citas
 * Endpoints: /api/appointments
 */
class AppointmentsApiController extends Api {
    private $appointmentModel;

    public function __construct() {
        parent::__construct();
        require_once APP_PATH . '/models/Appointment.php';
        $this->appointmentModel = new Appointment();
    }

    /**
     * GET /api/appointments - Listar citas
     * GET /api/appointments/{id} - Obtener cita específica
     */
    protected function get() {
        $user = $this->authenticate();

        // Obtener cita específica
        if (isset($_GET['id'])) {
            $appointment = $this->appointmentModel->find($_GET['id']);

            if (!$appointment) {
                return $this->response(['error' => 'Cita no encontrada'], 404);
            }

            return $this->response([
                'success' => true,
                'data' => $appointment
            ]);
        }

        // Filtros
        $date = $_GET['date'] ?? date('Y-m-d');
        $doctorId = $_GET['doctor_id'] ?? null;
        $clinicId = $user['clinic_id'];

        // Obtener citas
        if ($doctorId) {
            $appointments = $this->appointmentModel->getByDateAndDoctor($date, $doctorId);
        } else {
            $appointments = $this->appointmentModel->getByDateAndClinic($date, $clinicId);
        }

        return $this->response([
            'success' => true,
            'data' => $appointments,
            'filters' => [
                'date' => $date,
                'doctor_id' => $doctorId
            ]
        ]);
    }

    /**
     * POST /api/appointments - Crear nueva cita
     */
    protected function post() {
        $user = $this->authenticate();
        $data = $this->getRequestData();

        // Validar campos requeridos
        $required = ['patient_id', 'doctor_id', 'appointment_date', 'start_time', 'duration_minutes'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->response([
                    'error' => 'Validación fallida',
                    'message' => "El campo {$field} es requerido"
                ], 422);
            }
        }

        // Calcular end_time
        $startTime = $data['start_time'];
        $duration = $data['duration_minutes'];
        $endTime = date('H:i', strtotime($startTime) + ($duration * 60));

        $appointmentData = [
            'clinic_id' => $user['clinic_id'],
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'appointment_type_id' => $data['appointment_type_id'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_minutes' => $duration,
            'reason' => $data['reason'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'scheduled',
            'created_by' => $user['id']
        ];

        $result = $this->appointmentModel->createAppointment($appointmentData);

        if ($result['success']) {
            $appointment = $this->appointmentModel->find($result['id']);

            return $this->response([
                'success' => true,
                'message' => 'Cita creada exitosamente',
                'data' => $appointment
            ], 201);
        }

        return $this->response([
            'error' => 'Error al crear cita',
            'message' => $result['error']
        ], 400);
    }

    /**
     * PUT /api/appointments/{id} - Actualizar cita
     */
    protected function put() {
        $user = $this->authenticate();
        $data = $this->getRequestData();

        if (!isset($_GET['id'])) {
            return $this->response(['error' => 'ID de cita no proporcionado'], 400);
        }

        $appointment = $this->appointmentModel->find($_GET['id']);

        if (!$appointment) {
            return $this->response(['error' => 'Cita no encontrada'], 404);
        }

        // Actualizar estado si se proporciona
        if (isset($data['status'])) {
            $this->appointmentModel->updateStatus($_GET['id'], $data['status']);
        } else {
            // Actualizar otros campos
            $this->appointmentModel->update($_GET['id'], $data);
        }

        $updatedAppointment = $this->appointmentModel->find($_GET['id']);

        return $this->response([
            'success' => true,
            'message' => 'Cita actualizada exitosamente',
            'data' => $updatedAppointment
        ]);
    }

    /**
     * DELETE /api/appointments/{id} - Cancelar cita
     */
    protected function delete() {
        $user = $this->authenticate();

        if (!isset($_GET['id'])) {
            return $this->response(['error' => 'ID de cita no proporcionado'], 400);
        }

        if ($this->appointmentModel->updateStatus($_GET['id'], 'cancelled')) {
            return $this->response([
                'success' => true,
                'message' => 'Cita cancelada exitosamente'
            ]);
        }

        return $this->response(['error' => 'Error al cancelar cita'], 500);
    }
}
