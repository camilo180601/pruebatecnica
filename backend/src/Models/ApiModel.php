<?php
namespace Prueba\Backend\Models;

class ApiModel {
    private $apiBaseUrl;
    private $username;
    private $accessKey;

    public function __construct($config) {
        $this->apiBaseUrl = $config['api_base_url'];
        $this->username = $config['username'];
        $this->accessKey = $config['access_key'];
    }

    public function getChallenge() {
        $url = "{$this->apiBaseUrl}?operation=getchallenge&username={$this->username}";
        return $this->sendRequest($url);
    }

    public function login($token) {
        $generatedKey = md5($token . $this->accessKey); // Generar el accessKey
        $postData = [
            'operation' => 'login',
            'username' => $this->username,
            'accessKey' => $generatedKey
        ];

        // Log temporal para verificar el accessKey y los datos enviados
        error_log("AccessKey generado: $generatedKey");
        error_log("Datos enviados para login: " . json_encode($postData));

        return $this->sendRequest($this->apiBaseUrl, $postData);
    }

    public function queryContacts($sessionName) {
        $query = urlencode("select * from Contacts;");
        $url = "{$this->apiBaseUrl}?operation=query&sessionName={$sessionName}&query={$query}";
    
        // Log para depurar la URL generada
        error_log("URL generada para queryContacts: $url");
    
        $response = $this->sendRequest($url);
    
        // Log de la respuesta procesada
        error_log("Respuesta de queryContacts: " . json_encode($response));
    
        if (isset($response['success']) && !$response['success']) {
            error_log("Error en queryContacts: " . $response['error']);
        }
    
        return $response;
    }
    
    private function sendRequest($url, $postData = null) {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        }
    
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json'
        ]);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
    
            // Log del error
            error_log("Error en cURL: $error");
    
            return [
                'success' => false,
                'error' => "cURL error: $error"
            ];
        }
    
        curl_close($ch);
    
        // Log para verificar la respuesta recibida
        error_log("Respuesta recibida: $response");
    
        $decodedResponse = json_decode($response, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Error decodificando JSON: " . json_last_error_msg());
            return [
                'success' => false,
                'error' => "Invalid JSON response",
                'raw_response' => $response
            ];
        }
    
        return $decodedResponse;
    }    
    
}
