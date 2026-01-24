<?php
namespace App\Controllers;

use App\Models\Device;

class DeviceController {
    private $deviceModel;
    private $db;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->deviceModel = new Device($db);  // Pasar la conexión al modelo

        // Verificar sesión
        if (!isset($_SESSION['dni'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function showRegisterForm() {
        require __DIR__ . '/../views/device/register.php';
    }

    public function enlazarDispositivo() {
        header('Content-Type: application/json');

        try {
            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                throw new \Exception('Método no permitido');
            }

            // Validar y obtener datos
            $dispositivo_id = trim($_POST['dispositivo_id'] ?? '');
            $alias = trim($_POST['alias'] ?? '');
            $adulto_mayor_id = intval($_POST['adulto_id'] ?? 0);
            $responsable_id = intval($_SESSION['user_id'] ?? 0);

            // Debug
            error_log("Datos recibidos en enlazarDispositivo:");
            error_log("dispositivo_id: " . $dispositivo_id);
            error_log("alias: " . $alias);
            error_log("adulto_mayor_id: " . $adulto_mayor_id);
            error_log("responsable_id: " . $responsable_id);

            // Validar datos
            if (empty($dispositivo_id) || empty($alias) || $adulto_mayor_id <= 0) {
                throw new \Exception('Faltan datos o datos inválidos');
            }

            // Intentar enlazar el dispositivo
            $result = $this->deviceModel->enlazarDispositivo(
                $dispositivo_id,
                $alias,
                $adulto_mayor_id,
                $responsable_id
            );

            if (!$result) {
                throw new \Exception('Error al enlazar el dispositivo');
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Dispositivo enlazado correctamente'
            ]);

        } catch (\Exception $e) {
            error_log("Error en enlazarDispositivo: " . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}