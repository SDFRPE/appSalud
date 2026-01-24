<?php
namespace App\Controllers;

use App\Models\User;

class LoginController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if (isset($_SESSION['nombre'])) {
            header("Location: " . BASE_URL . "/dashboard");
            exit();
        }

        $error_message = "";
        $input = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new User($this->db);  // Pasamos la conexión aquí
            $input = $_POST['input'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($input) || empty($password)) {
                $error_message = "Por favor, completa todos los campos.";
            } else {
                $result = $user->login($input, $password);

                if ($result) {
                    $_SESSION['user_id'] = $result['id'];
                    $_SESSION['nombre'] = $result['nombres'];
                    $_SESSION['dni'] = $result['dni'];

                    header("Location: " . BASE_URL . "/dashboard");
                    exit();
                } else {
                    $error_message = "Credenciales inválidas";
                }
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit();
    }

    public function recoverPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            $userModel = new User($this->db);  // Pasamos la conexión aquí
            $user = $userModel->findByEmail($email);

            if ($user) {
                $code = bin2hex(random_bytes(16));
                $userModel->saveVerificationCode($user['id'], $code);

                $serviceMail = new \App\Services\ServiceMail();
                $subject = "Recuperación de Contraseña";
                $message = "Tu código de verificación es: $code";

                $result = $serviceMail->sendMail($email, $subject, $message);

                if ($result->isSuccess) {
                    echo "Se ha enviado un código de verificación a tu correo electrónico.";
                } else {
                    echo "Error al enviar el correo: " . $result->getMessage;
                }
            } else {
                echo "El correo electrónico no está registrado.";
            }
        }
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $newPassword = $_POST['new_password'];
            $hashedPassword = hash('sha512', $newPassword);

            $userModel = new User($this->db);  // Pasamos la conexión aquí
            $user = $userModel->findByCode($code);

            if ($user) {
                $userModel->updatePassword($user['id'], $hashedPassword);
                echo "Tu contraseña ha sido restablecida con éxito.";
            } else {
                echo "Código de verificación inválido.";
            }
        }
    }
}