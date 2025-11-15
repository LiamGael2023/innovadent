<?php
/**
 * API Controller para Pacientes
 * Endpoints: /api/patients
 */
class PatientsApiController extends Api {
    private $patientModel;

    public function __construct() {
        parent::__construct();
        require_once APP_PATH . '/models/Patient.php';
        $this->patientModel = new Patient();
    }

    /**
     * GET /api/patients - Listar pacientes
     * GET /api/patients/{id} - Obtener paciente específico
     */
    protected function get() {
        $user = $this->authenticate();

        // Si hay ID en la URL, obtener paciente específico
        if (isset($_GET['id'])) {
            $patient = $this->patientModel->find($_GET['id']);

            if (!$patient) {
                return $this->response(['error' => 'Paciente no encontrado'], 404);
            }

            // Obtener información adicional
            $medicalHistory = $this->patientModel->getMedicalHistory($_GET['id']);
            $stats = $this->patientModel->getPatientStats($_GET['id']);

            return $this->response([
                'success' => true,
                'data' => [
                    'patient' => $patient,
                    'medical_history' => $medicalHistory,
                    'stats' => $stats
                ]
            ]);
        }

        // Listar pacientes con paginación
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 20;
        $search = $_GET['search'] ?? null;

        if ($search) {
            $patients = $this->patientModel->searchByName($search, $user['clinic_id']);
            $total = count($patients);
            $pagination = $this->paginate($total, 1, $total);
        } else {
            $result = $this->patientModel->getByClinic($user['clinic_id'], $page);
            $patients = $result['data'];
            $pagination = $this->paginate($result['total'], $page, $perPage);
        }

        return $this->response([
            'success' => true,
            'data' => $patients,
            'pagination' => $pagination
        ]);
    }

    /**
     * POST /api/patients - Crear nuevo paciente
     */
    protected function post() {
        $user = $this->authenticate();
        $data = $this->getRequestData();

        // Validar datos requeridos
        $required = ['first_name', 'last_name', 'gender', 'phone'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->response([
                    'error' => 'Validación fallida',
                    'message' => "El campo {$field} es requerido"
                ], 422);
            }
        }

        // Agregar clinic_id del usuario autenticado
        $data['clinic_id'] = $user['clinic_id'];

        // Crear paciente
        $patientId = $this->patientModel->createPatient($data);

        if ($patientId) {
            $patient = $this->patientModel->find($patientId);

            return $this->response([
                'success' => true,
                'message' => 'Paciente creado exitosamente',
                'data' => $patient
            ], 201);
        }

        return $this->response([
            'error' => 'Error al crear paciente'
        ], 500);
    }

    /**
     * PUT /api/patients/{id} - Actualizar paciente
     */
    protected function put() {
        $user = $this->authenticate();
        $data = $this->getRequestData();

        if (!isset($_GET['id'])) {
            return $this->response(['error' => 'ID de paciente no proporcionado'], 400);
        }

        $patient = $this->patientModel->find($_GET['id']);

        if (!$patient) {
            return $this->response(['error' => 'Paciente no encontrado'], 404);
        }

        // Actualizar
        if ($this->patientModel->update($_GET['id'], $data)) {
            $updatedPatient = $this->patientModel->find($_GET['id']);

            return $this->response([
                'success' => true,
                'message' => 'Paciente actualizado exitosamente',
                'data' => $updatedPatient
            ]);
        }

        return $this->response(['error' => 'Error al actualizar paciente'], 500);
    }

    /**
     * DELETE /api/patients/{id} - Eliminar paciente (soft delete)
     */
    protected function delete() {
        $user = $this->authenticate();

        if (!isset($_GET['id'])) {
            return $this->response(['error' => 'ID de paciente no proporcionado'], 400);
        }

        if ($this->patientModel->softDelete($_GET['id'])) {
            return $this->response([
                'success' => true,
                'message' => 'Paciente eliminado exitosamente'
            ]);
        }

        return $this->response(['error' => 'Error al eliminar paciente'], 500);
    }
}
