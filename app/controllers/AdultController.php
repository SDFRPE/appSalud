<?php
namespace App\Controllers;

use App\Models\Adult;

class AdultController {
    private $adultModel;
    private $db;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->adultModel = new Adult($db);

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function showListDevices() {
        $id_usuario = $_SESSION['user_id'];
        error_log("ID de usuario en showListDevices: " . $id_usuario);

        $seresQueridosDis = $this->adultModel->showDevicesPerson($id_usuario);
        error_log("Seres queridos encontrados: " . print_r($seresQueridosDis, true));

        // Asegurarse de que $seresQueridosDis sea siempre un array
        if ($seresQueridosDis === false) {
            $seresQueridosDis = [];
        }

        require_once __DIR__ . '/../views/dashboard.php';
    }

    public function showRegisterForm() {
        require_once __DIR__ . '/../views/adult/register.php';
    }

    public function registerAdultoMayor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $departamento = $_POST['departamento'];
            $provincia = $_POST['provincia'];
            $ciudad = $_POST['ciudad'];
            $direccion = $_POST['direccion'];
            $sexo = $_POST['sexo'];
            $estatura = $_POST['estatura'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $tipo_de_sangre = $_POST['tipo_de_sangre'];
            $padecimientos = $_POST['padecimientos'];
            $responsable_id = $_SESSION['user_id'];

            $result = $this->adultModel->insertOlderAdult(
                $dni, $nombres, $apellidos, $email, $telefono,
                $departamento, $provincia, $ciudad, $direccion,
                $sexo, $estatura, $fecha_nacimiento, $tipo_de_sangre,
                $padecimientos, $responsable_id
            );

            if (strpos($result, 'Error') === false) {
                $_SESSION['successMessage'] = 'Adulto mayor registrado exitosamente';
            } else {
                $_SESSION['errorMessage'] = $result;
            }

            header("Location: " . BASE_URL . "/profile");
            exit();
        }
    }
}