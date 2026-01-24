<?php
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        error_log("Archivo .env no encontrado en: " . $filePath);
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') === false) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/appSalud');
}