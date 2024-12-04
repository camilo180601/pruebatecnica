<?php

require_once __DIR__ . '/vendor/autoload.php'; // Ruta a autoload.php desde la raíz
use Prueba\Backend\Controllers\ApiController;
use Tuupola\Middleware\CorsMiddleware;

// Configuración de CORS
$cors = new CorsMiddleware([
    "origin" => ["*"], // Permite cualquier origen
    "methods" => ["GET", "POST", "OPTIONS"], // Métodos permitidos
    "headers.allow" => ["Content-Type", "Authorization", "X-Requested-With"], // Cabeceras permitidas
    "headers.expose" => [], // Cabeceras expuestas
    "credentials" => false, // No enviar credenciales como cookies
    "cache" => 86400 // Tiempo de caché en segundos
]);

// Aplicar Middleware CORS
$response = null;
try {
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

    // Manejo de solicitudes OPTIONS (preflight)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204); // Sin contenido para preflight
        exit;
    }

    // Ejecutar el controlador y obtener la respuesta
    $response = $controller->getContacts();

    // Validar respuesta del controlador
    if (!is_array($response) || !isset($response['success'])) {
        http_response_code(500);
        echo json_encode(['error' => 'Unexpected response from controller']);
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    $response = ['error' => 'Server error', 'details' => $e->getMessage()];
}

// Aplicar CORS al final
$responseWithCors = $cors($response);
echo json_encode($responseWithCors);
