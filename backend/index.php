<?php

require_once __DIR__ . '/vendor/autoload.php'; // Ruta a autoload.php desde la raíz
use Prueba\Backend\Controllers\ApiController;

$response = null;
// Cargar la configuración
$configPath = __DIR__ . '/config/config.php';
$config = require $configPath;

// Crear instancia del controlador
$controller = new ApiController($config);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');


// Manejo de solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Sin contenido para preflight
    exit;
}

try {
    $response = $controller->getContacts();
    // Validar respuesta del controlador
    if (!is_array($response) || !isset($response['success'])) {
        http_response_code(500);
        echo json_encode(['error' => 'Unexpected response from controller']);
        exit;
    }
    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    $response = ['error' => 'Server error', 'details' => $e->getMessage()];
}
