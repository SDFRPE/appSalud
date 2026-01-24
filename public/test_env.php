<?php
require_once '../config/env.php';
loadEnv(__DIR__ . '/../.env');

echo 'DB_HOST: ' . $_ENV['DB_HOST'] . '<br>';
echo 'DB_NAME: ' . $_ENV['DB_NAME'] . '<br>';
echo 'DB_USERNAME: ' . $_ENV['DB_USERNAME'] . '<br>';
echo 'DB_PASSWORD: ' . $_ENV['DB_PASSWORD'] . '<br>';