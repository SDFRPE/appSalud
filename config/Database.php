<?php
namespace App\Config;

require_once __DIR__ . '/env.php';
loadEnv(__DIR__ . '/../.env');

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: $_ENV['DB_HOST'];
        $this->db_name = getenv('DB_NAME') ?: $_ENV['DB_NAME'];
        $this->username = getenv('DB_USERNAME') ?: $_ENV['DB_USERNAME'];
        $this->password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'];

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            throw new \RuntimeException('Variables de entorno no configuradas correctamente');
        }
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new \PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (\PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
        }
        return $this->conn;
    }
}