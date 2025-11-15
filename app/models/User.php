<?php
/**
 * Modelo User - Gestión de usuarios
 */
class User extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * Buscar usuario por email
     */
    public function findByEmail($email) {
        return $this->where(['email' => $email], null, 1);
    }

    /**
     * Buscar usuario por username
     */
    public function findByUsername($username) {
        return $this->where(['username' => $username], null, 1);
    }

    /**
     * Autenticar usuario
     */
    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);

        if (!$user) {
            $user = $this->findByEmail($username);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['is_active']) {
                // Actualizar último login
                $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
                return $user;
            }
        }

        return false;
    }

    /**
     * Crear nuevo usuario
     */
    public function createUser($data) {
        // Hash de la contraseña
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        return $this->create($data);
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword($userId, $newPassword) {
        $data = ['password_hash' => password_hash($newPassword, PASSWORD_DEFAULT)];
        return $this->update($userId, $data);
    }

    /**
     * Obtener usuarios por clínica
     */
    public function getByClinic($clinicId) {
        return $this->where(['clinic_id' => $clinicId, 'is_active' => 1], 'first_name, last_name');
    }

    /**
     * Obtener doctores activos
     */
    public function getDoctors($clinicId = null) {
        $conditions = ['is_doctor' => 1, 'is_active' => 1];

        if ($clinicId) {
            $conditions['clinic_id'] = $clinicId;
        }

        return $this->where($conditions, 'first_name, last_name');
    }

    /**
     * Obtener roles del usuario
     */
    public function getRoles($userId) {
        $sql = "SELECT r.* FROM roles r
                INNER JOIN user_roles ur ON r.id = ur.role_id
                WHERE ur.user_id = :user_id";

        return $this->db->query($sql)
                       ->bind(':user_id', $userId)
                       ->fetchAll();
    }

    /**
     * Asignar rol a usuario
     */
    public function assignRole($userId, $roleId) {
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";

        return $this->db->query($sql)
                       ->bind(':user_id', $userId)
                       ->bind(':role_id', $roleId)
                       ->execute();
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($userId, $roleSlug) {
        $sql = "SELECT COUNT(*) as count FROM user_roles ur
                INNER JOIN roles r ON ur.role_id = r.id
                WHERE ur.user_id = :user_id AND r.slug = :slug";

        $result = $this->db->query($sql)
                          ->bind(':user_id', $userId)
                          ->bind(':slug', $roleSlug)
                          ->fetch();

        return $result && $result['count'] > 0;
    }
}
