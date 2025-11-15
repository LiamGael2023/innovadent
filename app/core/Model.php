<?php
/**
 * Clase Model - Clase base para todos los modelos
 */
class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $timestamps = true;

    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Obtener todos los registros
     */
    public function all($orderBy = null) {
        $sql = "SELECT * FROM {$this->table}";

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Buscar un registro por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";

        return $this->db->query($sql)
                       ->bind(':id', $id)
                       ->fetch();
    }

    /**
     * Buscar registros con condiciones
     */
    public function where($conditions, $orderBy = null, $limit = null) {
        $sql = "SELECT * FROM {$this->table} WHERE ";

        $whereClauses = [];
        foreach ($conditions as $key => $value) {
            $whereClauses[] = "{$key} = :{$key}";
        }

        $sql .= implode(' AND ', $whereClauses);

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }

        $query = $this->db->query($sql);

        foreach ($conditions as $key => $value) {
            $query->bind(":{$key}", $value);
        }

        return $limit === 1 ? $query->fetch() : $query->fetchAll();
    }

    /**
     * Crear un nuevo registro
     */
    public function create($data) {
        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $columns = array_keys($data);
        $values = array_map(function($col) { return ":{$col}"; }, $columns);

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $values) . ")";

        $query = $this->db->query($sql);

        foreach ($data as $key => $value) {
            $query->bind(":{$key}", $value);
        }

        if ($query->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Actualizar un registro
     */
    public function update($id, $data) {
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $setClauses = [];
        foreach ($data as $key => $value) {
            $setClauses[] = "{$key} = :{$key}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setClauses) .
               " WHERE {$this->primaryKey} = :id";

        $query = $this->db->query($sql);

        foreach ($data as $key => $value) {
            $query->bind(":{$key}", $value);
        }

        $query->bind(':id', $id);

        return $query->execute();
    }

    /**
     * Eliminar un registro
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";

        return $this->db->query($sql)
                       ->bind(':id', $id)
                       ->execute();
    }

    /**
     * Soft delete (marcar como eliminado)
     */
    public function softDelete($id) {
        $data = ['deleted_at' => date('Y-m-d H:i:s')];
        return $this->update($id, $data);
    }

    /**
     * Contar registros
     */
    public function count($conditions = []) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";

        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "{$key} = :{$key}";
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $query = $this->db->query($sql);

        foreach ($conditions as $key => $value) {
            $query->bind(":{$key}", $value);
        }

        $result = $query->fetch();
        return $result ? (int)$result['total'] : 0;
    }

    /**
     * Paginación
     */
    public function paginate($page = 1, $perPage = ITEMS_PER_PAGE, $conditions = []) {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM {$this->table}";

        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "{$key} = :{$key}";
            }
            $sql .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $sql .= " LIMIT {$perPage} OFFSET {$offset}";

        $query = $this->db->query($sql);

        foreach ($conditions as $key => $value) {
            $query->bind(":{$key}", $value);
        }

        $data = $query->fetchAll();
        $total = $this->count($conditions);

        return [
            'data' => $data,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil($total / $perPage)
        ];
    }

    /**
     * Ejecutar consulta SQL personalizada
     */
    public function rawQuery($sql, $params = []) {
        $query = $this->db->query($sql);

        foreach ($params as $key => $value) {
            $query->bind($key, $value);
        }

        return $query->fetchAll();
    }
}
