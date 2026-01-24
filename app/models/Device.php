<?php
namespace App\Models;

use PDO;
use PDOException;

class Device {
    private $conn;
    private $table_name = "dispositivo";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function enlazarDispositivo($dispositivo_id, $alias, $adulto_mayor_id, $responsable_id) {
        try {
            // Verificar si el dispositivo ya existe
            $check_query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE dispositivo_id = :dispositivo_id";
            $check_stmt = $this->conn->prepare($check_query);
            $check_stmt->bindParam(':dispositivo_id', $dispositivo_id);
            $check_stmt->execute();

            if ($check_stmt->fetchColumn() > 0) {
                error_log("El dispositivo ya está registrado: " . $dispositivo_id);
                throw new \Exception('El dispositivo ya está registrado');
            }

            // Insertar nuevo dispositivo
            $query = "INSERT INTO " . $this->table_name . " 
                     (dispositivo_id, alias, adulto_mayor_id, responsable_id) 
                     VALUES (:dispositivo_id, :alias, :adulto_mayor_id, :responsable_id)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':dispositivo_id', $dispositivo_id);
            $stmt->bindParam(':alias', $alias);
            $stmt->bindParam(':adulto_mayor_id', $adulto_mayor_id, PDO::PARAM_INT);
            $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);

            error_log("Ejecutando query de inserción para dispositivo: " . $dispositivo_id);
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Error en enlazarDispositivo: " . $e->getMessage());
            return false;
        }
    }
}