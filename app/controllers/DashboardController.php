<?php
namespace App\Controllers;

class DashboardController {
    public function showDashboard() {
        session_start();

        if (!isset($_SESSION['nombre']) || !isset($_SESSION['dni'])) {
            header('Location: ' . BASE_URL . '/login');
            exit();
        }

        include __DIR__ . '/../views/dashboard.php';
    }
}
