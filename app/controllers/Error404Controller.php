<?php

namespace App\Controllers;

class Error404Controller {
    public function show404() {
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        echo "<p>Lo sentimos, la página que estás buscando no existe.</p>";
    }
}