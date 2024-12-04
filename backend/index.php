<?php

require_once __DIR__ . '/vendor/autoload.php'; // Ruta a autoload.php desde la raíz
use Prueba\Backend\Controllers\ApiController;

// Cargar la configuración
$configPath = __DIR__ . '/config/config.php';
if (!file_exists($configPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Configuration file not found']);
    exit;
}

$config = require $configPath;

// Crear instancia del controlador
$controller = new ApiController($config);

// Permitir cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir cualquier método
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// Permitir cualquier cabecera
header("Access-Control-Allow-Headers: *");
// No requiere credenciales (como cookies)
header("Access-Control-Allow-Credentials: false");

// Manejo de solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Sin contenido para preflight
    exit;
}

// Intentar ejecutar y manejar errores
try {
    $response = $controller->getContacts();

    if (!is_array($response) || !isset($response['success'])) {
        http_response_code(500);
        echo json_encode(['error' => 'Unexpected response from controller']);
        exit;
    }

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error', 'details' => $e->getMessage()]);
}