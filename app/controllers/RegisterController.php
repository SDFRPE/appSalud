<?php
namespace App\Controllers;

use App\Models\User;

class RegisterController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register() {
        if (isset($_SESSION['nombre'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }

        $error_message = '';
        $dni_error = '';
        $email_error = '';
        $input = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener y limpiar datos del formulario
            $dni = trim($_POST['dni'] ?? '');
            $nombres = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Establecer valores por defecto para campos opcionales
            $fecha_nacimiento = null;
            $sexo = null;
            $telefono = null;

            $user = new User($this->db);

            // Validaciones
            if (empty($dni) || empty($nombres) || empty($apellidos) || empty($email) ||
                empty($password) || empty($confirm_password)) {
                $error_message = 'Todos los campos son obligatorios.';
            } elseif (!preg_match("/^[0-9]{8}$/", $dni)) {
                $dni_error = 'El DNI debe tener exactamente 8 dígitos.';
            } elseif ($user->existsByDni($dni)) {
                $dni_error = 'Este DNI ya está registrado. Por favor, contacta con soporte.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = 'Por favor, ingresa un correo electrónico válido.';
            } elseif ($user->existsByEmail($email)) {
                $email_error = 'Este correo electrónico ya está registrado. Por favor, contacta con soporte.';
            } elseif (strlen($password) < 6) {
                $error_message = 'La contraseña debe tener al menos 6 caracteres.';
            } elseif ($password !== $confirm_password) {
                $error_message = 'Las contraseñas no coinciden.';
            } else {
                // Intento de registro
                try {
                    if ($user->register($dni, $nombres, $apellidos, $fecha_nacimiento, $sexo, $email, $password, $telefono)) {
                        $_SESSION['successMessage'] = 'Registro exitoso. Puedes iniciar sesión ahora.';
                        header("Location: " . BASE_URL . "/login");
                        exit;
                    } else {
                        $error_message = 'Error en el registro. Por favor, inténtelo de nuevo más tarde.';
                    }
                } catch (\Exception $e) {
                    error_log("Error en registro de usuario: " . $e->getMessage());
                    $error_message = 'Ocurrió un error durante el registro. Por favor, inténtelo de nuevo.';
                }
            }

            // Mantener los valores en el formulario excepto las contraseñas
            $input = [
                'dni' => $dni,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'email' => $email
            ];
        }

        // Pasar variables a la vista
        $data = [
            'error_message' => $error_message,
            'dni_error' => $dni_error,
            'email_error' => $email_error,
            'input' => $input
        ];

        extract($data);
        include __DIR__ . '/../views/auth/register.php';
    }
}