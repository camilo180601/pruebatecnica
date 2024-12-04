<?php

/**
 * Function to send a JSON response to the client.
 *
 * @param bool   $success Indicates whether the response is successful or not.
 * @param mixed  $data    The data to include in the response.
 * @param string $message An optional message to include in the response.
 */
function sendResponse($success, $data = null, $message = '') {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'message' => $message
    ]);
    exit;
}