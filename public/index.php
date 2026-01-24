<?php
// public/index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicializar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la ruta limpia antes de incluir el index principal
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = str_replace('/appSalud', '', $path);

// Debug
error_log("Request Path: " . $path);

// Incluir el index principal
require_once dirname(__DIR__) . '/index.php';