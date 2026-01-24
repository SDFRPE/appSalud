<?php
namespace App\Controllers;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Adult.php';

use App\Models\User;
use App\Models\Adult;

class ProfileController {
    private $userModel;
    private $adultModel;
    private $db;

    public function __construct($db) {
        // Verificar si la sesión NO está activa, entonces iniciarla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->userModel = new User($db);
        $this->adultModel = new Adult($db);

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function showProfile() {
        $dni = $_SESSION['dni'];
        $userData = $this->userModel->getUserByDni($dni);
        $successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : null;
        unset($_SESSION['successMessage']);

        $id_usuario = $_SESSION['user_id'];
        $seresQueridos = $this->adultModel->getSeresQueridos($id_usuario);

        require __DIR__ . '/../views/profile.php';
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Log de datos recibidos
            error_log("Datos recibidos para actualización:");
            error_log(print_r($_POST, true));

            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $departamento = $_POST['departamento'];
            $provincia = $_POST['provincia'];
            $ciudad = $_POST['ciudad'];
            $distrito = $_POST['distrito'] ?? null;
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];

            // Log de datos procesados
            error_log("Datos preparados para actualización:");
            error_log("DNI: $dni");
            error_log("Nombres: $nombres");
            error_log("Email: $email");

            // Validación de campos obligatorios
            if (empty($nombres) || empty($apellidos) || empty($email) || empty($telefono)) {
                $_SESSION['errorMessage'] = 'Todos los campos son obligatorios.';
                error_log("Error: campos obligatorios faltantes");
                header("Location: " . BASE_URL . "/profile");
                exit();
            }

            // Actualización del usuario
            $result = $this->userModel->updateUser($dni, $nombres, $apellidos, $email, $telefono, $departamento, $provincia, $ciudad, $distrito, $direccion, $sexo, $fecha_nacimiento);

            error_log("Resultado de actualización: " . ($result ? "exitoso" : "fallido"));

            if ($result) {
                $_SESSION['successMessage'] = 'Los datos se actualizaron satisfactoriamente.';
            } else {
                $_SESSION['errorMessage'] = 'Error al actualizar los datos. Por favor, inténtelo de nuevo.';
            }
            header("Location: " . BASE_URL . "/profile");
            exit();
        }
    }
}