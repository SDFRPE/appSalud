<?php
namespace App\Models;

use PDO;
use PDOException;

class User
{
    private $conn;
    private $table_name = "usuario";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($dni, $nombres, $apellidos, $fecha_nacimiento, $sexo, $email, $password, $telefono)
    {
        $query = "INSERT INTO " . $this->table_name . " (dni, nombres, apellidos, fecha_nacimiento, sexo, email, contraseña, telefono) 
                  VALUES (:dni, :nombres, :apellidos, :fecha_nacimiento, :sexo, :email, :password, :telefono)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = hash('sha512', $password);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':telefono', $telefono);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error para violación de clave única
                return false;
            }
            error_log("Error en el registro: " . $e->getMessage());
            return false;
        }
    }

    public function login($input, $password)
    {
        $is_email = filter_var($input, FILTER_VALIDATE_EMAIL);
        $query = $is_email
            ? "SELECT * FROM " . $this->table_name . " WHERE email = :input AND contraseña = :password"
            : "SELECT * FROM " . $this->table_name . " WHERE dni = :input AND contraseña = :password";

        $stmt = $this->conn->prepare($query);
        $hashed_password = hash('sha512', $password);
        $stmt->bindParam(':input', $input);
        $stmt->bindParam(':password', $hashed_password); // Este parámetro se utiliza en ambas consultas

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            error_log("Error en el login: " . $e->getMessage());
        }

        return false;
    }

    public function updatePassword($id, $hashedPassword) {
        $query = "UPDATE " . $this->table_name . " SET contraseña = :hashed_password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':hashed_password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function findByCode($code) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE verification_code = :code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByDni($dni)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE dni = :dni";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);  // Cambiado $this->db por $this->conn
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveVerificationCode($id, $code)
    {
        $query = "UPDATE " . $this->table_name . " SET verification_code = :code WHERE id = :id";
        $stmt = $this->conn->prepare($query);  // Cambiado $this->db por $this->conn
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public
    function existsByDni($dni)
    {
        $query = "SELECT 1 FROM " . $this->table_name . " WHERE dni = :dni LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public
    function existsByEmail($email)
    {
        $query = "SELECT 1 FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function updateUser($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $distrito, $direccion, $sexo, $fecha_nacimiento)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET 
                    nombres = :nombres, 
                    apellidos = :apellidos, 
                    email = :email, 
                    telefono = :telefono, 
                    departamento = :departamento, 
                    provincia = :provincia, 
                    ciudad = :ciudad, 
                    distrito = :distrito,
                    direccion = :direccion, 
                    sexo = :sexo, 
                    fecha_nacimiento = :fecha_nacimiento 
                  WHERE dni = :dni";

            $stmt = $this->conn->prepare($query);

            // Log de la consulta SQL y parámetros
            error_log("Ejecutando consulta SQL de actualización");
            error_log("DNI para actualización: $dni");

            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->bindParam(':provincia', $provincia);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':distrito', $distrito);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':dni', $dni);

            $result = $stmt->execute();
            error_log("Resultado de la ejecución SQL: " . ($result ? "exitoso" : "fallido"));
            error_log("Filas afectadas: " . $stmt->rowCount());

            return $result;
        } catch (PDOException $e) {
            error_log("Error en actualización de usuario: " . $e->getMessage());
            return false;
        }
    }
}
