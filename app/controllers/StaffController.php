<?php
namespace App\Controllers;

class StaffController {
    public function showStaff() {
        // Validar si el usuario ha iniciado sesión
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Si no está logueado, redirigir al login
        if (!isset($_SESSION['nombre'])) {
            header("Location: " . BASE_URL . "/login");
            exit();
        }

        // Si está logueado, mostrar la página de staff
        include __DIR__ . '/../views/staff.php';
    }
}
