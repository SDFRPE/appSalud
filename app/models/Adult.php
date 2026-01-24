<?php
namespace App\Models;

use PDO;
use PDOException;

class Adult {
    private $conn;
    private $table_name = "adultoMayor";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertOlderAdult($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $direccion, $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre, $padecimientos, $responsable_id) {
        try {
            $query = "CALL InsertarAdultoMayor(:dni, :nombres, :apellidos, :email, :telefono, :departamento, :provincia, :ciudad, :direccion, :sexo, :estatura, :fecha_nacimiento, :tipo_de_sangre, :padecimientos, :responsable_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':nombres', $nombres, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':departamento', $departamento, PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $stmt->bindParam(':estatura', $estatura, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_de_sangre', $tipo_de_sangre, PDO::PARAM_STR);
            $stmt->bindParam(':padecimientos', $padecimientos, PDO::PARAM_STR);
            $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "Adulto mayor registrado correctamente";
            }
            return "Error al registrar adulto mayor";
        } catch (PDOException $e) {
            error_log("Error en el registro de adulto mayor: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }

    public function getSeresQueridos($responsable_id) {
        try {
            error_log("Obteniendo seres queridos para responsable_id: " . $responsable_id);

            $query = "SELECT * FROM " . $this->table_name . " WHERE responsable_id = :responsable_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':responsable_id', $responsable_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Número de seres queridos encontrados: " . count($result));
            error_log("Datos encontrados: " . print_r($result, true));

            return $result ?: []; // Retorna array vacío en lugar de false
        } catch (PDOException $e) {
            error_log("Error en getSeresQueridos: " . $e->getMessage());
            return [];
        }
    }

    public function showDevicesPerson($id_usuario) {
        try {
            error_log("Consultando dispositivos para usuario ID: " . $id_usuario);

            $query = "SELECT 
                        am.id AS id_adultoMayor, 
                        am.dni,
                        am.nombres AS nombre_adulto, 
                        am.apellidos AS apellido_adulto, 
                        am.fecha_nacimiento, 
                        d.dispositivo_id, 
                        d.alias, 
                        d.ultima_fecha_actualizacion 
                    FROM " . $this->table_name . " am 
                    LEFT JOIN dispositivo d ON am.id = d.adulto_mayor_id 
                    WHERE am.responsable_id = :id_usuario";

            error_log("Query a ejecutar: " . $query);

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Número de registros encontrados: " . count($result));
            error_log("Resultados: " . print_r($result, true));

            return $result ?: []; // Retorna array vacío en lugar de false
        } catch (PDOException $e) {
            error_log("Error en showDevicesPerson: " . $e->getMessage());
            return [];
        }
    }

    public function delAdultoMayor($id) {
        try {
            error_log("Intentando eliminar adulto mayor con ID: " . $id);

            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                error_log("Adulto mayor eliminado correctamente");
                return "Adulto mayor eliminado correctamente";
            }
            error_log("Error al eliminar adulto mayor - No se encontró el registro o no se pudo eliminar");
            return "Error al eliminar adulto mayor";
        } catch (PDOException $e) {
            error_log("Error en delAdultoMayor: " . $e->getMessage());
            return "Error: " . $e->getMessage();
        }
    }
}