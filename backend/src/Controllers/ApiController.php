<?php
namespace Prueba\Backend\Controllers;

use Prueba\Backend\Models\ApiModel;
require_once __DIR__ . '/../Views/response.php';

class ApiController {
    private $model;

    public function __construct($config) {
        $this->model = new ApiModel($config);
    }

    public function getContacts() {
        try {
            // Obtener el token de desafío
            $challenge = $this->model->getChallenge();
            if (!$challenge['success']) {
                sendResponse(false, null, 'Failed to get challenge');
            }

            // Generar el token y realizar login
            $token = $challenge['result']['token'];
            $login = $this->model->login($token);
            
            if (!$login['success']) {
                sendResponse(false, null, 'Login failed');
            }

            // Obtener el sessionName y consultar contactos
            $sessionName = $login['result']['sessionName'];
            $contacts = $this->model->queryContacts($sessionName);

            if (isset($contacts['success']) && !$contacts['success']) {
                sendResponse(false, null, 'Failed to fetch contacts');
            }

            // Enviar respuesta de éxito con los datos de contactos
            sendResponse(true, $contacts['result'], 'Contacts retrieved successfully');
        } catch (Exception $e) {
            // Enviar respuesta de error en caso de excepciones
            sendResponse(false, null, 'Server error: ' . $e->getMessage());
        }
    }
}