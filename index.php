<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir constantes principales
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/appSalud');
}

// Autoloader
spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\Controllers\\' => '/app/controllers/',
        'App\\Models\\' => '/app/models/',
        'App\\Config\\' => '/config/'
    ];

    foreach ($prefixes as $prefix => $dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = ROOT_PATH . $dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            } else {
                error_log("File not found: " . $file);
            }
        }
    }
});

// Importar controladores necesarios
use App\Controllers\Error404Controller;
use App\Controllers\AsignacionAdultosMayoresController;
use App\Controllers\LoginController;
use App\Controllers\ProfileController;
use App\Controllers\StaffController;
use App\Controllers\AdultController;
use App\Controllers\DeviceController;
use App\Controllers\RegisterController;  // Agregar esta línea
use App\Config\Database;

// Inicializar la conexión a la base de datos
try {
    $database = new Database();
    $dbConnection = $database->getConnection();
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    die("Error de conexión: " . $e->getMessage());
}

// Si no hay ruta, redirigir a login
if (empty($path) || $path === 'index.php') {
    header("Location: " . BASE_URL . "/login");
    exit();
}

// Manejo de rutas
try {
    switch ('/' . trim($path, '/')) {
        case '/register':
            $controller = new RegisterController($dbConnection);
            $controller->register();
            break;

        case '/login':
            $controller = new LoginController($dbConnection);
            $controller->login();
            break;

        case '/profile':
            $controller = new ProfileController($dbConnection);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->updateProfile();
            } else {
                $controller->showProfile();
            }
            break;

        case '/logout':
            $controller = new LoginController($dbConnection);
            $controller->logout();
            break;

        case '/dashboard':
            $controller = new AdultController($dbConnection);
            $seresQueridosDis = $controller->showListDevices();
            break;

        case '/staff':
            $controller = new StaffController($dbConnection);
            $controller->showStaff();
            break;

        case '/add-adult':
            $controller = new AdultController($dbConnection);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->registerAdultoMayor();
            } else {
                $controller->showRegisterForm();
            }
            break;

        case '/add-device':
            $controller = new DeviceController($dbConnection);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->enlazarDispositivo();
            } else {
                $controller->showRegisterForm();
            }
            break;

        case '/':
            header("Location: " . BASE_URL . "/login");
            exit();

        default:
            error_log("404 Error - Path not found: " . $path);
            $errorController = new Error404Controller($dbConnection);
            $errorController->show404();
            break;
    }
} catch (Exception $e) {
    error_log("Application Error: " . $e->getMessage());
    die("Ha ocurrido un error en la aplicación: " . $e->getMessage());
}