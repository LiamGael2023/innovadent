<?php
/**
 * Clase Database - Manejo de conexión a base de datos con PDO
 */
class Database {
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;

    private $connection;
    private $stmt;
    private $error;

    /**
     * Constructor - Establece conexión con la base de datos
     */
    public function __construct() {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true
        ];

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->logError('Database Connection Error: ' . $this->error);

            if (DEBUG_MODE) {
                die('Error de conexión a la base de datos: ' . $this->error);
            } else {
                die('Error de conexión a la base de datos. Por favor, contacte al administrador.');
            }
        }
    }

    /**
     * Prepara una consulta SQL
     */
    public function query($sql) {
        $this->stmt = $this->connection->prepare($sql);
        return $this;
    }

    /**
     * Vincula valores a la consulta preparada
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
        return $this;
    }

    /**
     * Ejecuta la consulta preparada
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            $this->logError('Query Execution Error: ' . $this->error);
            return false;
        }
    }

    /**
     * Retorna múltiples resultados
     */
    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Retorna un solo resultado
     */
    public function fetch() {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Retorna el número de filas afectadas
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Retorna el último ID insertado
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Inicia una transacción
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Confirma una transacción
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * Revierte una transacción
     */
    public function rollBack() {
        return $this->connection->rollBack();
    }

    /**
     * Registra errores en el log
     */
    private function logError($message) {
        $logFile = LOG_PATH . '/database-' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}\n";

        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH, 0755, true);
        }

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Retorna el último error
     */
    public function getError() {
        return $this->error;
    }
}
